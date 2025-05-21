<?php
// Check if directly accessed
if(!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}

// Process category creation
if(isset($_POST["btnsave"])) {
    $categoryName = $_POST["categoryname"];
    
    // Check if category name already exists
    $checkQuery = mysqli_query($conn, "SELECT * FROM category WHERE name = '$categoryName'");
    if(mysqli_num_rows($checkQuery) > 0) {
        echo "<script>alert('Category name already exists. Please use a different name.');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO category (name) VALUES ('$categoryName')");
        echo "<script>alert('Category added successfully.');</script>";
        echo "<script>window.location = 'adminindex.php?pg=categories';</script>";
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-plus-circle me-2"></i>Add New Category</h2>
        <p class="text-muted mb-0">Create a new product category</p>
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
                        <input type="text" class="form-control" id="categoryname" name="categoryname" required>
                        <div class="form-text">Enter a unique name for the category</div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" name="btnsave" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Category
                        </button>
                        <a href="adminindex.php?pg=categories" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>