<?php

if (!isset($conn)) {
    echo "<script>window.location = 'admin_login.php';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-plus-circle me-2"></i>Add New Item</h2>
        <p class="text-muted mb-0">Create a new product item</p>
    </div>
    <div>
        <a href="index.php?pg=items" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Items
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-box me-2"></i>Item Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="itemname" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="itemname" name="itemname" required>
                        </div>
                        <div class="col-md-6">
                            <label for="categoryid" class="form-label">Category</label>
                            <select class="form-select" id="categoryid" name="categoryid" required>
                                <option value="" selected disabled>Select Category</option>
                                <?php
                                $categories = mysqli_query($conn, "SELECT * FROM category ORDER BY name");
                                while ($category = mysqli_fetch_array($categories)) {
                                    ?>
                                    <option value="<?php echo $category["categoryid"]; ?>"><?php echo $category["name"]; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="0.01"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="btnsave" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Item
                        </button>
                        <a href="index.php?pg=items" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>

                    <?php
                    if (isset($_POST["btnsave"])) {
                        $itemname = $_POST["itemname"];
                        $categoryid = $_POST["categoryid"];
                        $price = $_POST["price"];
                        $quantity = $_POST["quantity"];
                        $description = $_POST["description"];
                        $image = "";

                        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                            $allowed_types = array('image/jpeg', 'image/png');
                            $file_type = $_FILES["image"]["type"];

                            if (in_array($file_type, $allowed_types)) {
                                $image = "../uploads/" . basename($_FILES["image"]["name"]);
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
                                    $image = "uploads/" . basename($_FILES["image"]["name"]);
                                } else {
                                    echo "<script>alert('Failed to upload image.');</script>";
                                    $image = "";
                                }
                            } else {
                                echo "<script>alert('Only JPEG and PNG images are allowed.');</script>";
                                $image = "";
                            }
                        }

                        mysqli_query($conn, "INSERT INTO item(categoryid, itemname, price, image, quantity, description) 
                         VALUES($categoryid, '$itemname', $price, '$image', $quantity, '$description')");

                        echo "<script>alert('Item added successfully.');</script>";
                        echo "<script>window.location = 'index.php?pg=items';</script>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>