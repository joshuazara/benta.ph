<?php
if(!isset($conn)) {
    echo "<script>window.location = 'admin_login.php';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-plus-circle me-2"></i>Add New Category</h2>
        <p class="text-muted mb-0">Create a new product category</p>
    </div>
    <div>
        <a href="index.php?pg=categories" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Category Information</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="categoryname" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryname" name="categoryname" required>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" name="btnsave" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Category
                        </button>
                        <a href="index.php?pg=categories" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                    
                    <?php
                    if(isset($_POST["btnsave"])) {
                        $categoryname = $_POST["categoryname"];
                        
                        mysqli_query($conn, "INSERT INTO category (name) VALUES ('$categoryname')");
                        echo "<script>alert('Category added successfully.');</script>";
                        echo "<script>window.location = 'index.php?pg=categories';</script>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>