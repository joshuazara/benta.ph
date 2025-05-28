<?php

if(!isset($conn)) {
    echo "<script>window.location = 'admin_login.php';</script>";
}

if(isset($_GET["delete"])) {
    $id = $_GET["delete"];
    mysqli_query($conn, "DELETE FROM item WHERE itemid = $id");
    echo "<script>alert('Item deleted successfully.');</script>";
    echo "<script>window.location = 'index.php?pg=items';</script>";
}
?>

<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-box me-2"></i>Item Management</h2>
        <p class="text-muted">Manage product items</p>
    </div>
    <div class="col-auto">
        <a href="index.php?pg=add_item" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Item
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Items</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT i.*, c.name as categoryname 
                                          FROM item i 
                                          LEFT JOIN category c ON i.categoryid = c.categoryid 
                                          ORDER BY i.itemname");
                    
                    while($r = mysqli_fetch_array($q)){
                    ?>
                    <tr>
                        <td><?php echo $r["itemid"]; ?></td>
                        <td>
                            <?php if(!empty($r["image"])) { ?>
                                <img src="../<?php echo $r["image"]; ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php } else { ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            <?php } ?>
                        </td>
                        <td><?php echo $r["itemname"]; ?></td>
                        <td><?php echo $r["categoryname"]; ?></td>
                        <td>₱<?php echo number_format($r["price"], 2); ?></td>
                        <td>
                            <?php 
                            echo $r["quantity"]; 
                            if($r["quantity"] == 0) {
                                echo ' <span class="badge bg-danger">Out of Stock</span>';
                            } else if($r["quantity"] < 5) {
                                echo ' <span class="badge bg-warning text-dark">Low Stock</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="index.php?pg=edit_item&id=<?php echo $r["itemid"]; ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="index.php?pg=items&delete=<?php echo $r["itemid"]; ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this item?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    
                    if(mysqli_num_rows($q) == 0) {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">No items found</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>