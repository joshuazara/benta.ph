<?php

if (!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}

if (!isset($_GET["id"])) {
    echo "<script>window.location = 'adminindex.php?pg=categories';</script>";
}

$id = $_GET["id"];

$q = mysqli_query($conn, "SELECT * FROM category WHERE categoryid = $id");
$r = mysqli_fetch_array($q);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-edit me-2"></i>Edit Category</h2>
        <p class="text-muted mb-0">Edit category: <?php echo $r["name"]; ?></p>
    </div>
    <div>
        <a href="adminindex.php?pg=categories" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Category Information</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="categoryname" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryname" name="categoryname"
                            value="<?php echo $r["name"]; ?>" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="btnupdate" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Category
                        </button>
                        <a href="adminindex.php?pg=categories" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>

                    <?php
                    if (isset($_POST["btnupdate"])) {
                        $categoryname = $_POST["categoryname"];

                        mysqli_query($conn, "UPDATE category SET name = '$categoryname' WHERE categoryid = $id");
                        echo "<script>alert('Category updated successfully.');</script>";
                        echo "<script>window.location = 'adminindex.php?pg=categories';</script>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Category Statistics</h5>
            </div>
            <div class="card-body">
                <?php
                $itemsQuery = mysqli_query($conn, "SELECT COUNT(*) as count FROM item WHERE categoryid = $id");
                $itemRow = mysqli_fetch_assoc($itemsQuery);
                $itemCount = $itemRow['count'];
                ?>

                <div class="d-flex align-items-center mb-3">
                    <div class="me-3 bg-light p-3 rounded">
                        <i class="fas fa-box text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Items in Category</h6>
                        <h3 class="mb-0"><?php echo $itemCount; ?></h3>
                    </div>
                </div>

                <?php if ($itemCount > 0) { ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>This category is being used by <?php echo $itemCount; ?>
                        item(s).
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>This category has no items assigned to it yet.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>