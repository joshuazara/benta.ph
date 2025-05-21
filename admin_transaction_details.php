<?php
// Check if directly accessed
if(!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}

$id = $_GET["id"];

// Process actions
if(isset($_POST["btnapprove"])) {
    mysqli_query($conn, "UPDATE transaction SET status = 'Approved' WHERE transactionid = $id");
    echo "<script>alert('Transaction #$id has been approved.');</script>";
    echo "<script>window.location = 'adminindex.php?pg=transaction_details&id=$id';</script>";
}

if(isset($_POST["btncancel"])) {
    mysqli_query($conn, "UPDATE transaction SET status = 'Cancelled' WHERE transactionid = $id");
    echo "<script>alert('Transaction #$id has been cancelled.');</script>";
    echo "<script>window.location = 'adminindex.php?pg=transaction_details&id=$id';</script>";
}

if(isset($_POST["btncomplete"])) {
    mysqli_query($conn, "UPDATE transaction SET status = 'Completed' WHERE transactionid = $id");
    echo "<script>alert('Transaction #$id has been completed.');</script>";
    echo "<script>window.location = 'adminindex.php?pg=transaction_details&id=$id';</script>";
}

// Get transaction details
$q = mysqli_query($conn, "SELECT t.*, u.firstname, u.lastname 
                       FROM transaction t
                       JOIN user u ON t.userid = u.userid
                       WHERE t.transactionid = $id");
$r = mysqli_fetch_array($q);

// Format the status with appropriate color and icon
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

// Format date
$orderDate = date("F d, Y h:i A", strtotime($r["ordereddate"]));
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-file-invoice me-2"></i>Transaction Details</h2>
        <p class="text-muted mb-0">
            Transaction #<?php echo $id; ?> | 
            <span class="badge <?php echo $statusClass; ?>"><i class="<?php echo $statusIcon; ?> me-1"></i><?php echo $r["status"]; ?></span>
        </p>
    </div>
    <div>
        <a href="adminindex.php?pg=transactions" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Transactions
        </a>
    </div>
</div>

<div class="row">
    <!-- Transaction Summary -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Transaction Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i><strong>Order Date:</strong> <?php echo $orderDate; ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-user me-2 text-primary"></i><strong>Customer:</strong> <?php echo $r["firstname"] . " " . $r["lastname"]; ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-phone me-2 text-primary"></i><strong>Contact Number:</strong> <?php echo $r["contactnumber"]; ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Delivery Address:</strong> <?php echo $r["deliveryaddress"]; ?>
                </div>
                <div class="mb-3">
                    <i class="fas fa-tag me-2 text-primary"></i><strong>Status:</strong> 
                    <span class="badge <?php echo $statusClass; ?>"><i class="<?php echo $statusIcon; ?> me-1"></i><?php echo $r["status"]; ?></span>
                </div>
                
                <!-- Action Buttons -->
                <form method="POST">
                    <div class="mt-4">
                        <?php if($r["status"] == "Pending") { ?>
                            <button type="submit" name="btnapprove" class="btn btn-success mb-2 me-2">
                                <i class="fas fa-check me-2"></i>Approve Transaction
                            </button>
                        <?php } ?>
                        
                        <?php if($r["status"] == "Approved") { ?>
                            <button type="submit" name="btncomplete" class="btn btn-info mb-2 me-2">
                                <i class="fas fa-check-double me-2"></i>Complete Transaction
                            </button>
                        <?php } ?>
                        
                        <?php if($r["status"] == "Pending" || $r["status"] == "Approved") { ?>
                            <button type="submit" name="btncancel" class="btn btn-danger mb-2">
                                <i class="fas fa-times me-2"></i>Cancel Transaction
                            </button>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Order Items -->
    <div class="col-md-7 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-box me-1"></i>Item</th>
                                <th class="text-center"><i class="fas fa-tag me-1"></i>Price</th>
                                <th class="text-center"><i class="fas fa-sort-amount-up me-1"></i>Quantity</th>
                                <th class="text-end"><i class="fas fa-calculator me-1"></i>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get transaction items
                            $itemsQuery = mysqli_query($conn, "SELECT ti.*, i.itemname, i.image 
                                                FROM transactionitem ti
                                                JOIN item i ON ti.itemid = i.itemid
                                                WHERE ti.transactionid = $id");
                            
                            while($item = mysqli_fetch_array($itemsQuery)) {
                            ?>
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <div class="me-2">
                                            <?php if(!empty($item["image"])) { ?>
                                                <img src="<?php echo $item["image"]; ?>" alt="<?php echo $item["itemname"]; ?>" style="width:40px; height:40px; object-fit:cover;" class="border rounded">
                                            <?php } else { ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded border" style="width:40px; height:40px;">
                                                    <i class="fas fa-box text-secondary"></i>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php echo $item["itemname"]; ?>
                                    </td>
                                    <td class="text-center">₱<?php echo number_format($item["price"], 2); ?></td>
                                    <td class="text-center"><?php echo $item["quantity"]; ?></td>
                                    <td class="text-end">₱<?php echo number_format($item["subtotal"], 2); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end"><i class="fas fa-receipt me-1"></i><strong>Subtotal:</strong></td>
                                <td class="text-end">₱<?php echo number_format($r["subtotal"], 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><i class="fas fa-truck me-1"></i><strong>Shipping Fee:</strong></td>
                                <td class="text-end">₱<?php echo number_format($r["shippingfee"], 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><i class="fas fa-money-bill-wave me-1"></i><strong>Total Amount:</strong></td>
                                <td class="text-end"><strong>₱<?php echo number_format($r["totalamount"], 2); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>