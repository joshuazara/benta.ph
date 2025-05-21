<?php
// Check if directly accessed
if(!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}

// Delete category if requested
if(isset($_GET['delete'])) {
    $categoryId = $_GET['delete'];
    
    // Check if category is in use by any items
    $checkItems = mysqli_query($conn, "SELECT COUNT(*) as count FROM item WHERE categoryid = $categoryId");
    $itemRow = mysqli_fetch_assoc($checkItems);
    $itemCount = $itemRow['count'];
    if($itemCount > 0) {
        echo "<script>alert('Cannot delete category because it is being used by $itemCount item(s).');</script>";
    } else {
        mysqli_query($conn, "DELETE FROM category WHERE categoryid = $categoryId");
        echo "<script>alert('Category deleted successfully.');</script>";
    }
    
    echo "<script>window.location = 'adminindex.php?pg=categories';</script>";
}
?>

<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-tags me-2"></i>Category Management</h2>
        <p class="text-muted">Manage product categories</p>
    </div>
    <div class="col-auto">
        <a href="adminindex.php?pg=add_category" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Add New Category
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Categories</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>ID</th>
                        <th><i class="fas fa-tag me-1"></i>Category Name</th>
                        <th><i class="fas fa-box me-1"></i>Items Count</th>
                        <th><i class="fas fa-cog me-1"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get all categories
                    $q = mysqli_query($conn, "SELECT c.*, 
                                             (SELECT COUNT(*) FROM item i WHERE i.categoryid = c.categoryid) as item_count
                                          FROM category c
                                          ORDER BY c.name ASC");
                    
                    while($r = mysqli_fetch_array($q)) {
                    ?>
                        <tr>
                            <td><?php echo $r["categoryid"]; ?></td>
                            <td><?php echo $r["name"]; ?></td>
                            <td><?php echo $r["item_count"]; ?></td>
                            <td>
                                <a href="adminindex.php?pg=edit_category&id=<?php echo $r["categoryid"]; ?>" class="btn btn-sm btn-info me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <?php if($r["item_count"] == 0) { ?>
                                <a href="adminindex.php?pg=categories&delete=<?php echo $r["categoryid"]; ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <?php } else { ?>
                                <button class="btn btn-sm btn-secondary" disabled title="Cannot delete category with items">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php
                    }
                    
                    if(mysqli_num_rows($q) == 0) {
                        echo "<tr><td colspan='4' class='text-center py-4'><i class='fas fa-info-circle me-2'></i>No categories found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>