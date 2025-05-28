<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please login to access your account.'); window.location = 'users/login.php';</script>";
    exit();
}

// Get user data
$user_query = mysqli_query($con, "SELECT * FROM user WHERE email = '" . $_SESSION['email'] . "'");
$user_data = mysqli_fetch_array($user_query);
$user_id = $user_data['userid'];

// Handle account update (password, contact details, and delivery address ONLY)
if (isset($_POST['update_account'])) {
    $password = $_POST['password'];
    $contactnumber = $_POST['contactnumber'];
    $address = $_POST['address'];
    
    // Update user information - only allowed fields
    if (!empty($password)) {
        // Update with new password
        $update_query = "UPDATE user SET 
            password = '$password', 
            contactnumber = '$contactnumber', 
            address = '$address' 
            WHERE userid = $user_id";
    } else {
        // Update without changing password
        $update_query = "UPDATE user SET 
            contactnumber = '$contactnumber', 
            address = '$address' 
            WHERE userid = $user_id";
    }
    
    if (mysqli_query($con, $update_query)) {
        $update_success = "Account updated successfully!";
        // Refresh user data
        $user_query = mysqli_query($con, "SELECT * FROM user WHERE userid = $user_id");
        $user_data = mysqli_fetch_array($user_query);
    } else {
        $update_error = "Error updating account. Please try again.";
    }
}

// Get user transactions (ordered by latest first)
$transactions_query = mysqli_query($con, "SELECT * FROM transaction WHERE userid = $user_id ORDER BY ordereddate DESC");
?>

<style>
    .account-header {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .status-pending { color: #856404; background-color: #fff3cd; }
    .status-approved { color: #0c5460; background-color: #d1ecf1; }
    .status-completed { color: #155724; background-color: #d4edda; }
    .status-cancelled { color: #721c24; background-color: #f8d7da; }
    
    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
</style>

<div class="container mt-4">
    <!-- Account Header -->
    <div class="account-header">
        <h2><i class="fas fa-user me-2"></i>My Account</h2>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($user_data['firstname'] . ' ' . $user_data['lastname']); ?></p>
                <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Contact:</strong> <?php echo htmlspecialchars($user_data['contactnumber']); ?></p>
                <p class="mb-0"><strong>Member since:</strong> <?php echo date("F d, Y", strtotime($user_data['createddate'])); ?></p>
            </div>
        </div>
    </div>

    <!-- Update Account Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Update Account</h5>
                    <small class="text-muted">You can update your password, contact details, and delivery address only</small>
                </div>
                <div class="card-body">
                    <?php if (isset($update_success)) { ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i><?php echo $update_success; ?>
                        </div>
                    <?php } ?>
                    
                    <?php if (isset($update_error)) { ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $update_error; ?>
                        </div>
                    <?php } ?>
                    
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Enter new password">
                                    <small class="form-text text-muted">Leave blank if you don't want to change your password</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contactnumber" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="contactnumber" name="contactnumber" 
                                           value="<?php echo htmlspecialchars($user_data['contactnumber']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Delivery Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required><?php echo htmlspecialchars($user_data['address']); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" name="update_account" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction List Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Transaction List</h5>
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($transactions_query) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                <th><i class="fas fa-user me-1"></i>Client Name</th>
                                <th><i class="fas fa-money-bill-wave me-1"></i>Total Amount</th>
                                <th><i class="fas fa-map-marker-alt me-1"></i>Delivery Address</th>
                                <th><i class="fas fa-phone me-1"></i>Contact</th>
                                <th><i class="fas fa-calendar-alt me-1"></i>Order Date</th>
                                <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                <th><i class="fas fa-cog me-1"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($transaction = mysqli_fetch_array($transactions_query)) { 
                                // Determine status styling
                                $status_class = '';
                                $status_icon = '';
                                
                                switch (strtolower($transaction['status'])) {
                                    case 'pending':
                                        $status_class = 'status-pending';
                                        $status_icon = 'fas fa-hourglass-half';
                                        break;
                                    case 'approved':
                                        $status_class = 'status-approved';
                                        $status_icon = 'fas fa-check-circle';
                                        break;
                                    case 'completed':
                                        $status_class = 'status-completed';
                                        $status_icon = 'fas fa-check-double';
                                        break;
                                    case 'cancelled':
                                        $status_class = 'status-cancelled';
                                        $status_icon = 'fas fa-times-circle';
                                        break;
                                }
                                
                                $order_date = date("M d, Y h:i A", strtotime($transaction['ordereddate']));
                                $client_name = $user_data['firstname'] . ' ' . $user_data['lastname'];
                            ?>
                                <tr>
                                    <td><?php echo $transaction['transactionid']; ?></td>
                                    <td><?php echo htmlspecialchars($client_name); ?></td>
                                    <td>₱<?php echo number_format($transaction['totalamount'], 2); ?></td>
                                    <td><?php echo htmlspecialchars(substr($transaction['deliveryaddress'], 0, 50)) . (strlen($transaction['deliveryaddress']) > 50 ? '...' : ''); ?></td>
                                    <td><?php echo htmlspecialchars($transaction['contactnumber']); ?></td>
                                    <td><?php echo $order_date; ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <i class="<?php echo $status_icon; ?> me-1"></i><?php echo $transaction['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="index.php?pg=transaction_details&id=<?php echo $transaction['transactionid']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="text-center py-5">
                    <i class="fas fa-receipt text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">No transactions found</h5>
                    <p class="text-muted">You haven't made any orders yet.</p>
                    <a href="index.php" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});
</script>