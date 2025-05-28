<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");


// Get user data
$user_query = mysqli_query($con, "SELECT * FROM user WHERE email = '" . $_SESSION['email'] . "'");
$user_data = mysqli_fetch_array($user_query);
$user_id = $user_data['userid'];

// Get cart items
$cart_query = mysqli_query($con, "SELECT c.*, i.itemname, i.price, i.image, i.quantity as stock_quantity FROM cart c JOIN item i ON c.itemid = i.itemid WHERE c.userid = $user_id");

$cart_items = array();
$subtotal = 0;

while ($cart_item = mysqli_fetch_array($cart_query)) {
    $cart_items[] = $cart_item;
    $subtotal += $cart_item['price'] * $cart_item['quantity'];
}

// Check if cart is empty
if (empty($cart_items)) {
    echo "<script>alert('Your cart is empty!'); window.location = 'index.php?pg=cart';</script>";
    exit();
}

$shipping_fee = 100;
$total = $subtotal + $shipping_fee;

// Handle order placement
if (isset($_POST['place_order'])) {
    $contact = $user_data['contactnumber'];
    $address = $user_data['address'];
    $order_date = date('Y-m-d H:i:s');
    
    // Check stock availability
    $stock_check = true;
    $stock_errors = array();
    
    foreach ($cart_items as $item) {
        $current_stock_query = mysqli_query($con, "SELECT quantity FROM item WHERE itemid = {$item['itemid']}");
        $current_stock_result = mysqli_fetch_array($current_stock_query);
        $current_stock = $current_stock_result['quantity'];
        
        if ($current_stock < $item['quantity']) {
            $stock_check = false;
            $stock_errors[] = $item['itemname'] . " (Available: $current_stock, Requested: {$item['quantity']})";
        }
    }
    
    if (!$stock_check) {
        echo "<div class='alert alert-danger mt-3'>";
        echo "<strong>Stock Error:</strong> The following items don't have enough stock:<br>";
        foreach ($stock_errors as $error) {
            echo "• $error<br>";
        }
        echo "</div>";
    } else {
        // Create transaction
        $insert_transaction = mysqli_query($con, "INSERT INTO transaction 
            (userid, ordereddate, subtotal, shippingfee, totalamount, deliveryaddress, contactnumber, status) 
            VALUES ($user_id, '$order_date', $subtotal, $shipping_fee, $total, '$address', '$contact', 'Pending')");
        
        if ($insert_transaction) {
            $transaction_id = mysqli_insert_id($con);
            
            // Add transaction items and update stock
            foreach ($cart_items as $item) {
                $item_subtotal = $item['price'] * $item['quantity'];
                
                // Insert transaction item
                mysqli_query($con, "INSERT INTO transactionitem 
                    (transactionid, itemid, quantity, price, subtotal) 
                    VALUES ($transaction_id, {$item['itemid']}, {$item['quantity']}, {$item['price']}, $item_subtotal)");
                
                // Update item stock
                mysqli_query($con, "UPDATE item SET quantity = quantity - {$item['quantity']} WHERE itemid = {$item['itemid']}");
            }
            
            // Clear cart
            mysqli_query($con, "DELETE FROM cart WHERE userid = $user_id");
            
            echo "<script>
                alert('Order placed successfully! Transaction ID: #$transaction_id');
                window.location = 'index.php?pg=transactions';
            </script>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error placing order. Please try again.</div>";
        }
    }
}
?>

<style>
    .checkout-item-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .order-summary {
        position: sticky;
        top: 20px;
    }
</style>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2><i class="fas fa-credit-card me-2"></i>Checkout</h2>
            <p class="text-muted">Review your order and complete your purchase</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Review</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item) { ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['image'])) { ?>
                                                <img src="<?php echo $item['image']; ?>" class="checkout-item-img me-3" alt="<?php echo htmlspecialchars($item['itemname']); ?>">
                                            <?php } else { ?>
                                                <div class="checkout-item-img bg-light d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php } ?>
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($item['itemname']); ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">₱<?php echo number_format($item['price'], 2); ?></td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-center">₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Delivery Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted">Name:</span><br>
                        <?php echo htmlspecialchars($user_data['firstname'] . ' ' . $user_data['lastname']); ?>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Contact:</span><br>
                        <?php echo htmlspecialchars($user_data['contactnumber']); ?>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted">Address:</span><br>
                        <?php echo nl2br(htmlspecialchars($user_data['address'])); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₱<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Fee:</span>
                        <span>₱<?php echo number_format($shipping_fee, 2); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5">Total:</span>
                        <span class="h5">₱<?php echo number_format($total, 2); ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between gap-2">
                        <a href="index.php?pg=cart" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Cart
                        </a>
                        <button type="submit" name="place_order" class="btn btn-success" form="checkoutForm">
                            <i class="fas fa-check me-2"></i>Place Order
                        </button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>Secure checkout guaranteed
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <form method="POST" id="checkoutForm" style="display: none;"></form>
</div>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    if (!confirm('Are you sure you want to place this order?')) {
        e.preventDefault();
        return false;
    }
});
</script>