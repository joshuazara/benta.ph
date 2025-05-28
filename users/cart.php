<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");


// Get user ID
$user_query = mysqli_query($con, "SELECT userid FROM user WHERE email = '" . $_SESSION['email'] . "'");
$user_data = mysqli_fetch_array($user_query);
$user_id = $user_data['userid'];

// Handle cart updates
if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $new_quantity = $_POST['quantity'];
    
    if ($new_quantity > 0) {
        mysqli_query($con, "UPDATE cart SET quantity = $new_quantity WHERE cartid = $cart_id AND userid = $user_id");
    } else {
        mysqli_query($con, "DELETE FROM cart WHERE cartid = $cart_id AND userid = $user_id");
    }
    echo "<script>window.location = 'index.php?pg=cart';</script>";
}

// Handle item removal
if (isset($_GET['remove'])) {
    $cart_id = $_GET['remove'];
    mysqli_query($con, "DELETE FROM cart WHERE cartid = $cart_id AND userid = $user_id");
    echo "<script>window.location = 'index.php?pg=cart';</script>";
}

// Handle clear cart
if (isset($_POST['clear_cart'])) {
    mysqli_query($con, "DELETE FROM cart WHERE userid = $user_id");
    echo "<script>window.location = 'index.php?pg=cart';</script>";
}

// Get cart items
$cart_query = mysqli_query($con, "SELECT c.*, i.itemname, i.price, i.image, i.quantity as stock_quantity FROM cart c JOIN item i ON c.itemid = i.itemid WHERE c.userid = $user_id");

$cart_items = array();
$subtotal = 0;

while ($cart_item = mysqli_fetch_array($cart_query)) {
    $cart_items[] = $cart_item;
    $subtotal += $cart_item['price'] * $cart_item['quantity'];
}

$shipping_fee = 100;
$total = $subtotal + $shipping_fee;
?>

<style>
    .item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .quantity-control {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    
    .quantity-control button {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: #6c757d;
        color: white;
        font-weight: bold;
    }
    
    .quantity-control button:hover {
        background: #5a6268;
        color: white;
    }
    
    .quantity-display {
        font-weight: 600;
        min-width: 30px;
        text-align: center;
    }
    
    /* Fixed table layout to prevent column movement */
    .cart-table {
        table-layout: fixed;
        width: 100%;
    }
    
    .cart-table th:nth-child(1) { width: 40%; } /* Item column */
    .cart-table th:nth-child(2) { width: 15%; } /* Price column */
    .cart-table th:nth-child(3) { width: 20%; } /* Quantity column */
    .cart-table th:nth-child(4) { width: 15%; } /* Subtotal column */
    .cart-table th:nth-child(5) { width: 10%; } /* Action column */
    
    .cart-table td {
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
            <p class="text-muted">Review and manage your selected items</p>
        </div>
    </div>
    
    <?php if (empty($cart_items)) { ?>
        <!-- Empty Cart -->
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow-sm">
                    <div class="card-body py-5">
                        <i class="fas fa-shopping-cart text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">Your cart is empty</h4>
                        <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Cart Items (<?php echo count($cart_items); ?>)</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $item) { ?>
                                    <tr data-cart-id="<?php echo $item['cartid']; ?>" data-price="<?php echo $item['price']; ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['image'])) { ?>
                                                    <img src="<?php echo $item['image']; ?>" class="item-img me-3" alt="<?php echo htmlspecialchars($item['itemname']); ?>">
                                                <?php } else { ?>
                                                    <div class="item-img bg-light d-flex align-items-center justify-content-center me-3">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php } ?>
                                                <div>
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($item['itemname']); ?></h6>
                                                    <small class="text-muted"><?php echo $item['stock_quantity']; ?> in stock</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">₱<?php echo number_format($item['price'], 2); ?></td>
                                        <td class="text-center">
                                            <div class="quantity-control">
                                                <button type="button" onclick="decreaseQuantity(this)" 
                                                        data-cart-id="<?php echo $item['cartid']; ?>" 
                                                        data-max="<?php echo $item['stock_quantity']; ?>">-</button>
                                                <span class="quantity-display"><?php echo $item['quantity']; ?></span>
                                                <button type="button" onclick="increaseQuantity(this)" 
                                                        data-cart-id="<?php echo $item['cartid']; ?>" 
                                                        data-max="<?php echo $item['stock_quantity']; ?>">+</button>
                                            </div>
                                        </td>
                                        <td class="text-center">₱<span class="item-subtotal"><?php echo number_format($item['price'] * $item['quantity'], 2); ?></span></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-danger" onclick="removeItem(<?php echo $item['cartid']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <a href="index.php" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <button class="btn btn-danger" onclick="clearCart()">
                        <i class="fas fa-trash-alt me-2"></i>Clear Cart
                    </button>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Items (<?php echo count($cart_items); ?>):</span>
                            <span>₱<span id="cart-subtotal"><?php echo number_format($subtotal, 2); ?></span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-truck me-1"></i>Shipping:</span>
                            <span>₱100.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5">Total:</span>
                            <span class="h5">₱<span id="cart-total"><?php echo number_format($total, 2); ?></span></span>
                        </div>
                        
                        <a href="index.php?pg=checkout" class="btn btn-success w-100 btn-lg" id="checkout-btn">
                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                        </a>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>Secure checkout guaranteed
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
// AJAX function to update cart
function updateCartQuantity(cartId, quantity) {
    fetch('index.php?pg=cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `update_quantity=1&cart_id=${cartId}&quantity=${quantity}`
    })
    .then(response => response.text())
    .then(data => {
        // Update successful - prices already updated in UI
        updateCartBadge();
    })
    .catch(error => {
        console.error('Error:', error);
        // Reload page on error
        window.location.reload();
    });
}

function increaseQuantity(button) {
    const cartId = button.getAttribute('data-cart-id');
    const maxQuantity = parseInt(button.getAttribute('data-max'));
    const row = button.closest('tr');
    const quantitySpan = row.querySelector('.quantity-display');
    const currentQuantity = parseInt(quantitySpan.innerText);
    
    if (currentQuantity < maxQuantity) {
        const newQuantity = currentQuantity + 1;
        quantitySpan.innerText = newQuantity;
        updateRowSubtotal(row, newQuantity);
        updateCartTotal();
        updateCartQuantity(cartId, newQuantity);
    }
}

function decreaseQuantity(button) {
    const cartId = button.getAttribute('data-cart-id');
    const row = button.closest('tr');
    const quantitySpan = row.querySelector('.quantity-display');
    const currentQuantity = parseInt(quantitySpan.innerText);
    
    if (currentQuantity > 1) {
        const newQuantity = currentQuantity - 1;
        quantitySpan.innerText = newQuantity;
        updateRowSubtotal(row, newQuantity);
        updateCartTotal();
        updateCartQuantity(cartId, newQuantity);
    }
}

function updateRowSubtotal(row, quantity) {
    const price = parseFloat(row.getAttribute('data-price'));
    const subtotal = price * quantity;
    const subtotalSpan = row.querySelector('.item-subtotal');
    subtotalSpan.innerText = subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function updateCartTotal() {
    let subtotal = 0;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const price = parseFloat(row.getAttribute('data-price'));
        const quantity = parseInt(row.querySelector('.quantity-display').innerText);
        subtotal += price * quantity;
    });
    
    const shippingFee = 100;
    const total = subtotal + shippingFee;
    
    document.getElementById('cart-subtotal').innerText = subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('cart-total').innerText = total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function removeItem(cartId) {
    if (confirm('Remove this item from cart?')) {
        window.location.href = `index.php?pg=cart&remove=${cartId}`;
    }
}

function clearCart() {
    if (confirm('Are you sure you want to clear your cart?')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = '<input type="hidden" name="clear_cart" value="1">';
        document.body.appendChild(form);
        form.submit();
    }
}

function updateCartBadge() {
    // Update the cart badge in the navigation
    const rows = document.querySelectorAll('tbody tr');
    let totalItems = 0;
    
    rows.forEach(row => {
        const quantity = parseInt(row.querySelector('.quantity-display').innerText);
        totalItems += quantity;
    });
    
    const cartBadge = document.querySelector('.cart-badge');
    if (cartBadge) {
        if (totalItems > 0) {
            cartBadge.innerText = totalItems;
            cartBadge.style.display = 'flex';
        } else {
            cartBadge.style.display = 'none';
        }
    }
}
</script>