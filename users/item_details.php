<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");

// Get item ID from URL
$item_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch item details
$item_query = mysqli_query($con, "SELECT i.*, c.name as category_name FROM item i 
                                  LEFT JOIN category c ON i.categoryid = c.categoryid 
                                  WHERE i.itemid = $item_id");

if (!$item_query || mysqli_num_rows($item_query) == 0) {
    echo "<script>alert('Product not found!'); window.location = '../index.php';</script>";
    exit();
}

$item = mysqli_fetch_array($item_query);

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['email'])) {
        echo "<script>alert('Please login to add items to cart.'); window.location = 'users/login.php';</script>";
        exit();
    }
    
    // Get user ID
    $user_query = mysqli_query($con, "SELECT userid FROM user WHERE email = '" . $_SESSION['email'] . "'");
    $user_data = mysqli_fetch_array($user_query);
    $user_id = $user_data['userid'];
    
    $quantity = $_POST['quantity'];
    
    // Check if item already in cart
    $cart_check = mysqli_query($con, "SELECT * FROM cart WHERE userid = $user_id AND itemid = $item_id");
    
    if (mysqli_num_rows($cart_check) > 0) {
        // Update existing cart item
        $existing_cart = mysqli_fetch_array($cart_check);
        $new_quantity = $existing_cart['quantity'] + $quantity;
        mysqli_query($con, "UPDATE cart SET quantity = $new_quantity WHERE userid = $user_id AND itemid = $item_id");
    } else {
        // Add new item to cart
        mysqli_query($con, "INSERT INTO cart (userid, itemid, quantity) VALUES ($user_id, $item_id, $quantity)");
    }
    
    echo "<script>alert('Item added to cart successfully!'); window.location = 'index.php?pg=item_details&id=$item_id';</script>";
}

// Stock status
$stock_class = 'text-success';
$stock_text = $item['quantity'] . ' available';
$stock_icon = 'fas fa-check-circle';

if ($item['quantity'] == 0) {
    $stock_class = 'text-danger';
    $stock_text = 'Out of Stock';
    $stock_icon = 'fas fa-times-circle';
} elseif ($item['quantity'] < 5) {
    $stock_class = 'text-warning';
    $stock_text = 'Low Stock (' . $item['quantity'] . ' left)';
    $stock_icon = 'fas fa-exclamation-triangle';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($item['itemname']); ?> - BENTA.PH</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        
        .product-image {
            width: 100%;
            height: 450px;
            object-fit: contain;
            border-radius: 10px;
            background-color: #f8f9fa;
        }
        
        .product-image-placeholder {
            width: 100%;
            height: 450px;
            background: linear-gradient(135deg, #e9ecef, #f8f9fa);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 2px dashed #dee2e6;
        }
        
        .price-tag {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
        }
        
        .quantity-input {
            max-width: 120px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php?category=<?php echo $item['categoryid']; ?>"><?php echo strtoupper($item['category_name']); ?></a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($item['itemname']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <?php if (!empty($item['image'])) { ?>
                        <img src="<?php echo $item['image']; ?>" class="product-image" alt="<?php echo htmlspecialchars($item['itemname']); ?>">
                    <?php } else { ?>
                        <div class="product-image-placeholder">
                            <div class="text-center text-muted">
                                <i class="fas fa-image fs-1 mb-3"></i>
                                <p class="mb-0">No Image Available</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <!-- Category Badge -->
                    <span class="badge bg-secondary mb-3"><?php echo strtoupper($item['category_name']); ?></span>
                    
                    <!-- Product Name -->
                    <h1 class="h2 fw-bold mb-3"><?php echo htmlspecialchars($item['itemname']); ?></h1>
                    
                    <!-- Price -->
                    <div class="price-tag mb-4">₱<?php echo number_format($item['price'], 2); ?></div>
                    
                    <!-- Stock Status -->
                    <div class="mb-4">
                        <span class="<?php echo $stock_class; ?> fs-5">
                            <i class="<?php echo $stock_icon; ?> me-2"></i><?php echo $stock_text; ?>
                        </span>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Description</h5>
                        <p class="text-muted lh-lg"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                    </div>
                    
                    <!-- Add to Cart Form -->
                    <?php if ($item['quantity'] > 0) { ?>
                        <form method="POST" class="mt-4">
                            <div class="row align-items-end">
                                <div class="col-md-4 mb-3">
                                    <label for="quantity" class="form-label fw-semibold">Quantity</label>
                                    <input type="number" class="form-control quantity-input" id="quantity" name="quantity" 
                                           value="1" min="1" max="<?php echo $item['quantity']; ?>" required>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <button type="submit" name="add_to_cart" class="btn btn-success btn-lg w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            This item is currently out of stock.
                        </div>
                    <?php } ?>
                    
                    <!-- Back to Shop Button -->
                    <div class="mt-3">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    <div class="mt-5">
        <h3 class="fw-bold mb-4">Related Products</h3>
        <div class="row g-4">
            <?php
            // Get related products from same category (excluding current item)
            $related_query = mysqli_query($con, "SELECT * FROM item WHERE categoryid = {$item['categoryid']} AND itemid != $item_id LIMIT 4");
            
            if (mysqli_num_rows($related_query) > 0) {
                while ($related = mysqli_fetch_array($related_query)) {
            ?>
                <div class="col-sm-6 col-md-3">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($related['image'])) { ?>
                            <img src="<?php echo $related['image']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo htmlspecialchars($related['itemname']); ?>">
                        <?php } else { ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image text-muted fs-1"></i>
                            </div>
                        <?php } ?>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?php echo htmlspecialchars($related['itemname']); ?></h6>
                            <p class="text-success fw-bold mb-3">₱<?php echo number_format($related['price'], 2); ?></p>
                            <div class="mt-auto">
                                <a href="index.php?pg=item_details&id=<?php echo $related['itemid']; ?>" class="btn btn-primary btn-sm w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p class='text-muted'>No related products found.</p>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>