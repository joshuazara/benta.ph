<?php

$pendingResult = mysqli_query($conn, "SELECT COUNT(*) as count FROM transaction WHERE status = 'Pending'");
$pendingRow = mysqli_fetch_assoc($pendingResult);
$pendingCount = $pendingRow['count'];

$approvedResult = mysqli_query($conn, "SELECT COUNT(*) as count FROM transaction WHERE status = 'Approved'");
$approvedRow = mysqli_fetch_assoc($approvedResult);
$approvedCount = $approvedRow['count'];

$itemResult = mysqli_query($conn, "SELECT COUNT(*) as count FROM item");
$itemRow = mysqli_fetch_assoc($itemResult);
$itemCount = $itemRow['count'];

$categoryResult = mysqli_query($conn, "SELECT COUNT(*) as count FROM category");
$categoryRow = mysqli_fetch_assoc($categoryResult);
$categoryCount = $categoryRow['count'];

?>


<div class="row mb-4">
    <div class="col">
        <h2>Dashboard</h2>
        <p class="text-muted">Welcome to your BENTA.PH admin dashboard</p>
    </div>
</div>


<div class="row mb-4">
  
    <div class="col-md-6 mb-3">
    <a href="adminindex.php?pg=transactions" class="text-decoration-none text-dark">
        <div class="card card-dashboard bg-white h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-check-circle card-icon"></i>
                </div>
                <h5 class="card-title">Approved Transactions</h5>
                <h2 class="display-4 fw-bold"><?php echo $approvedCount; ?></h2>
                    <p class="card-text text-muted mb-0">Total approved orders</p>
                </div>
            </div>
        </a>
    </div>
    
    
    <div class="col-md-6 mb-3">
        <a href="adminindex.php?pg=transactions" class="text-decoration-none text-dark">
        <div class="card card-dashboard bg-white">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-hourglass-half card-icon text-warning"></i>
                </div>
                <h5 class="card-title">Pending Transactions</h5>
                <h2 class="display-4 fw-bold"><?php echo $pendingCount; ?></h2>
                    <p class="card-text text-muted mb-0">Orders awaiting approval</p>
                </div>
            </div>
        </a>
    </div>


<div class="row mb-4">
    <div class="col-12 mb-3">
        <h3>Quick Access</h3>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <a href="adminindex.php?pg=myaccount" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-light p-3 rounded-circle">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Update Account</h5>
                            <p class="text-muted mb-0">Change your admin password</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <a href="adminindex.php?pg=transactions" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-light p-3 rounded-circle">
                                <i class="fas fa-list text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Transactions</h5>
                            <p class="text-muted mb-0">View and manage order transactions</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12 mb-3">
        <h3>Management</h3>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <a href="adminindex.php?pg=items" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-light p-3 rounded-circle">
                                <i class="fas fa-box text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Items</h5>
                            <p class="text-muted mb-0">Number of items: <?php echo $itemCount; ?></p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <a href="adminindex.php?pg=categories" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-light p-3 rounded-circle">
                                <i class="fas fa-tags text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Categories</h5>
                            <p class="text-muted mb-0">Number of categories: <?php echo $categoryCount; ?></p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-chevron-right text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>