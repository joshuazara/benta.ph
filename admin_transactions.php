<?php

if(!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}
?>

<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-exchange-alt me-2"></i>Transaction Management</h2>
        <p class="text-muted">View and manage all customer transactions</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Transactions</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
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
                    <?php
                    $q = mysqli_query($conn, "SELECT t.*, u.firstname, u.lastname 
                                          FROM transaction t
                                          JOIN user u ON t.userid = u.userid
                                          ORDER BY t.ordereddate DESC");
                    
                    while($r = mysqli_fetch_array($q)) {
                        
                        $statusClass = '';
                        $statusIcon = '';
                        
                        if($r["status"] == "Pending") {
                            $statusClass = 'bg-warning';
                            $statusIcon = 'fas fa-hourglass-half';
                        } else if($r["status"] == "Approved") {
                            $statusClass = 'bg-info';
                            $statusIcon = 'fas fa-check-circle';
                        } else if($r["status"] == "Completed") {
                            $statusClass = 'bg-success';
                            $statusIcon = 'fas fa-check-double';
                        } else if($r["status"] == "Cancelled") {
                            $statusClass = 'bg-danger';
                            $statusIcon = 'fas fa-times-circle';
                        }
                        
                        
                        $orderDate = date("M d, Y h:i A", strtotime($r["ordereddate"]));
                    ?>
                        <tr>
                            <td><?php echo $r["transactionid"]; ?></td>
                            <td><?php echo $r["firstname"] . " " . $r["lastname"]; ?></td>
                            <td>₱<?php echo number_format($r["totalamount"], 2); ?></td>
                            <td><?php echo $r["deliveryaddress"]; ?></td>
                            <td><?php echo $r["contactnumber"]; ?></td>
                            <td><?php echo $orderDate; ?></td>
                            <td><span class="badge <?php echo $statusClass; ?>"><i class="<?php echo $statusIcon; ?> me-1"></i><?php echo $r["status"]; ?></span></td>
                            <td>
                                <a href="adminindex.php?pg=transaction_details&id=<?php echo $r["transactionid"]; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    
                    if(mysqli_num_rows($q) == 0) {
                        echo "<tr><td colspan='8' class='text-center py-4'><i class='fas fa-info-circle me-2'></i>No transactions found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>