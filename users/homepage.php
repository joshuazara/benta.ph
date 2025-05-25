<?php 
$con = mysqli_connect("localhost", "root", "", "dbbenta");

// Get search query and category filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Build the SQL query - category filter overrides search
$sql = "SELECT * FROM item WHERE 1=1";

if (!empty($category_filter) && $category_filter != 'all') {
    // Category selected - show only items from that category (ignore search)
    $sql .= " AND categoryid = '$category_filter'";
} elseif (!empty($search)) {
    // No category selected - use search function
    $sql .= " AND (itemname LIKE '%$search%' OR description LIKE '%$search%')";
}

$sql .= " ORDER BY itemname ASC";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BENTA.PH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>

        .product-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .product-card {
            height: 100%;
        }

        .product-title {
            height: 3rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-height: 1.5rem;
        }

        .product-category {
            height: 1.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-price {
            height: 2rem;
            display: flex;
            align-items: center;
        }

        .product-stock {
            height: 1.5rem;
            display: flex;
            align-items: center;
        }

        h3, h5 {
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Enhanced Banner -->
<div class="container mt-4 mb-4">
    <div class="card text-center border-0 shadow-sm bg-dark text-white">
        <div class="card-body py-5">
            <h1 class="card-title fw-bold mb-3">
                <i class="fas fa-shopping-bag me-3"></i>SHOP NOW!
            </h1>
            <p class="card-text fs-5 mb-0">Discover amazing deals on quality products at unbeatable prices</p>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="container mb-4">
    <form class="d-flex justify-content-center" method="GET" action="">
        <div class="input-group" style="max-width: 600px;">
            <input class="form-control form-control-lg" type="search" name="search" 
                   placeholder="Search for products..." value="<?php echo htmlspecialchars($search); ?>"/>
            <button class="btn btn-success btn-lg" type="submit">
                <i class="fas fa-search me-2"></i>Search
            </button>
            <?php if (!empty($category_filter)) { ?>
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category_filter); ?>">
            <?php } ?>
        </div>
    </form>
</div>

<!-- Products Section -->
<div class="container">
    <!-- Category Tabs -->
    <?php
    // Get all categories
    $categories_query = mysqli_query($con, "SELECT * FROM category ORDER BY name ASC");
    $categories = array();
    while ($cat = mysqli_fetch_array($categories_query)) {
        $categories[] = $cat;
    }
    
    $total_categories = count($categories);
    $max_tabs = 4; // Show 4 regular tabs + 1 "More" dropdown if needed
    ?>
    
    <ul class="nav nav-tabs nav-fill mb-4">
        <!-- All Products Tab -->
        <li class="nav-item">
            <a class="nav-link <?php echo empty($category_filter) || $category_filter == 'all' ? 'active' : ''; ?>" 
               href="?category=all">
                <i class="fas fa-th-large me-2"></i><strong>ALL</strong>
            </a>
        </li>
        
        <?php
        // Show first 4 categories as regular tabs
        for ($i = 0; $i < min($max_tabs, $total_categories); $i++) {
            $cat = $categories[$i];
            $active = ($category_filter == $cat['categoryid']) ? 'active' : '';
            echo "<li class='nav-item'>
                    <a class='nav-link $active' href='?category={$cat['categoryid']}'><strong>" . strtoupper($cat['name']) . "</strong></a>
                  </li>";
        }
        
        // If there are more categories, show "More" dropdown
        if ($total_categories > $max_tabs) {
            echo "<li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' data-bs-toggle='dropdown' href='#'>
                        <i class='fas fa-ellipsis-h me-2'></i><strong>MORE</strong>
                    </a>
                    <ul class='dropdown-menu'>";
            
            for ($i = $max_tabs; $i < $total_categories; $i++) {
                $cat = $categories[$i];
                $active = ($category_filter == $cat['categoryid']) ? 'active' : '';
                echo "<li><a class='dropdown-item $active' href='?category={$cat['categoryid']}'><strong>" . strtoupper($cat['name']) . "</strong></a></li>";
            }
            
            echo "</ul></li>";
        }
        ?>
    </ul>

    <!-- Products Display -->
    <div class="mb-3">
        <h4 class="fw-bold">
            <?php 
            if (!empty($search)) {
                echo "Search Results for: \"" . htmlspecialchars($search) . "\"";
            } elseif (!empty($category_filter) && $category_filter != 'all') {
                // Get category name
                $cat_name_query = mysqli_query($con, "SELECT name FROM category WHERE categoryid = '$category_filter'");
                $cat_name_result = mysqli_fetch_array($cat_name_query);
                echo $cat_name_result ? strtoupper($cat_name_result['name']) : 'Products';
            } else {
                echo "All Products";
            }
            ?>
        </h4>
    </div>

    <div class="row g-4">
        <?php
        $q = mysqli_query($con, $sql);

        if (mysqli_num_rows($q) > 0) {
            while ($r = mysqli_fetch_array($q)) {
                // Get category name
                $cat_query = mysqli_query($con, "SELECT name FROM category WHERE categoryid = {$r['categoryid']}");
                $cat_result = mysqli_fetch_array($cat_query);
                $category_name = $cat_result ? $cat_result['name'] : 'Uncategorized';
                
                // Stock status
                $stock_class = 'text-success';
                $stock_text = $r['quantity'] . ' available';
                
                if ($r['quantity'] == 0) {
                    $stock_class = 'text-danger';
                    $stock_text = 'Out of Stock';
                } elseif ($r['quantity'] < 5) {
                    $stock_class = 'text-warning';
                    $stock_text = 'Low Stock (' . $r['quantity'] . ')';
                }
        ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card shadow-sm">
                <?php 
                if (!empty($r['image'])) {
                    echo '<img src="' . $r['image'] . '" class="product-img card-img-top" alt="' . htmlspecialchars($r['itemname']) . '">';
                } else {
                    echo '<div class="product-img bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted fs-1"></i>
                          </div>';
                }
                ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title product-title mb-2"><?php echo htmlspecialchars($r['itemname']); ?></h5>
                    <p class="card-text text-muted small product-category mb-2"><?php echo strtoupper(htmlspecialchars($category_name)); ?></p>
                    <div class="product-price mb-2">
                        <span class="fs-5 fw-bold text-success">₱<?php echo number_format($r['price'], 2); ?></span>
                    </div>
                    <div class="product-stock <?php echo $stock_class; ?> mb-3">
                        <small><i class="fas fa-box me-1"></i><?php echo $stock_text; ?></small>
                    </div>
                    <div class="mt-auto">
                        <a href="index.php?pg=item_details&id=<?php echo $r['itemid']; ?>" class="btn btn-primary w-100">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col-12'>
                    <div class='text-center py-5'>
                        <i class='fas fa-search fs-1 text-muted mb-3'></i>
                        <h5 class='text-muted'>No products found</h5>
                        <p class='text-muted'>Try adjusting your search or browse different categories.</p>
                    </div>
                  </div>";
        }
        ?>
    </div>
</div>

</body>
</html>