<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please login to view transaction details.'); window.location = 'users/login.php';</script>";
    exit();
}

// Get user ID
$user_query = mysqli_query($con, "SELECT userid, firstname, lastname FROM user WHERE email = '" . $_SESSION['email'] . "'");
$user_data = mysqli_fetch_array($user_query);
$user_id = $user_data['userid'];

// Get transaction ID
$transaction_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Get transaction details
$transaction_query = mysqli_query($con, "SELECT * FROM transaction WHERE transactionid = $transaction_id AND userid = $user_id");

if (!$transaction_query || mysqli_num_rows($transaction_query) == 0) {
    echo "<script>alert('Transaction not found.'); window.location = 'index.php?pg=myaccount';</script>";
    exit();
}

$transaction = mysqli_fetch_array($transaction_query);

// Handle transaction cancellation
if (isset($_POST['cancel_transaction'])) {
    $restore_items_query = mysqli_query($con, "SELECT itemid, quantity FROM transactionitem WHERE transactionid = $transaction_id");
    
    while ($restore_item = mysqli_fetch_array($restore_items_query)) {
        $item_id = $restore_item['itemid'];
        $quantity_to_restore = $restore_item['quantity'];
        
        mysqli_query($con, "UPDATE item SET quantity = quantity + $quantity_to_restore WHERE itemid = $item_id");
    }
    
    mysqli_query($con, "UPDATE transaction SET status = 'Cancelled' WHERE transactionid = $transaction_id");
    
    echo "<script>alert('Transaction cancelled'); window.location = 'index.php?pg=transaction_details&id=$transaction_id';</script>";
}

// Get transaction items
$items_query = mysqli_query($con, "SELECT ti.*, i.itemname, i.image 
                                  FROM transactionitem ti 
                                  JOIN item i ON ti.itemid = i.itemid 
                                  WHERE ti.transactionid = $transaction_id");

// Status styling
$status_class = '';
$status_icon = '';

switch (strtolower($transaction['status'])) {
    case 'pending':
        $status_class = 'text-warning';
        $status_icon = 'fas fa-hourglass-half';
        break;
    case 'approved':
        $status_class = 'text-info';
        $status_icon = 'fas fa-check-circle';
        break;
    case 'completed':
        $status_class = 'text-success';
        $status_icon = 'fas fa-check-double';
        break;
    case 'cancelled':
        $status_class = 'text-danger';
        $status_icon = 'fas fa-times-circle';
        break;
}

$order_date = date("F d, Y h:i A", strtotime($transaction['ordereddate']));
?>

<style>
    .transaction-header {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>

<div class="container mt-4">
    <!-- Transaction Header -->
    <div class="transaction-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="fas fa-file-invoice me-2"></i>Transaction #<?php echo $transaction['transactionid']; ?></h2>
            <div>
                <?php if ($transaction['status'] == 'Pending' || $transaction['status'] == 'Approved') { ?>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this transaction?');">
                        <button type="submit" name="cancel_transaction" class="btn btn-danger me-2">
                            <i class="fas fa-times me-1"></i>Cancel Transaction
                        </button>
                    </form>
                <?php } ?>
                <a href="index.php?pg=myaccount" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to My Account
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <strong>Order Date:</strong><br>
                <?php echo $order_date; ?>
            </div>
            <div class="col-md-4">
                <strong>Status:</strong><br>
                <span class="<?php echo $status_class; ?>">
                    <i class="<?php echo $status_icon; ?> me-1"></i><?php echo $transaction['status']; ?>
                </span>
            </div>
            <div class="col-md-4">
                <strong>Total:</strong><br>
                <span class="text-success fw-bold">₱<?php echo number_format($transaction['totalamount'], 2); ?></span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Customer Details -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Name:</strong><br>
                        <?php echo htmlspecialchars($user_data['firstname'] . ' ' . $user_data['lastname']); ?>
                    </div>
                    <div class="mb-2">
                        <strong>Contact Number:</strong><br>
                        <?php echo htmlspecialchars($transaction['contactnumber']); ?>
                    </div>
                    <div class="mb-0">
                        <strong>Delivery Address:</strong><br>
                        <?php echo nl2br(htmlspecialchars($transaction['deliveryaddress'])); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Payment Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₱<?php echo number_format($transaction['subtotal'], 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Fee:</span>
                        <span>₱<?php echo number_format($transaction['shippingfee'], 2); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong class="text-success">₱<?php echo number_format($transaction['totalamount'], 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Ordered -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Items Ordered</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (mysqli_num_rows($items_query) > 0) {
                            while ($item = mysqli_fetch_array($items_query)) { ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['image'])) { ?>
                                                <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['itemname']); ?>" 
                                                     style="width: 50px; height: 50px; object-fit: cover;" class="me-3 rounded">
                                            <?php } else { ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center me-3 rounded" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            <?php } ?>
                                            <span><?php echo htmlspecialchars($item['itemname']); ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">₱<?php echo number_format($item['price'], 2); ?></td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-center">₱<?php echo number_format($item['subtotal'], 2); ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">No items found for this transaction.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>