<?php
// Check if directly accessed
if(!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}

// Check if ID is provided
if(!isset($_GET["id"])) {
    echo "<script>window.location = 'adminindex.php?pg=items';</script>";
}

$id = $_GET["id"];

// Get item details
$q = mysqli_query($conn, "SELECT * FROM item WHERE itemid = $id");
$r = mysqli_fetch_array($q);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="fas fa-edit me-2"></i>Edit Item</h2>
        <p class="text-muted mb-0">Edit item: <?php echo $r["itemname"]; ?></p>
    </div>
    <div>
        <a href="adminindex.php?pg=items" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Items
        </a>
    </div>
</div>

<div class="row">
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
                            <input type="text" class="form-control" id="itemname" name="itemname" value="<?php echo $r["itemname"]; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="categoryid" class="form-label">Category</label>
                            <select class="form-select" id="categoryid" name="categoryid" required>
                                <option value="" disabled>Select Category</option>
                                <?php
                                $categories = mysqli_query($conn, "SELECT * FROM category ORDER BY name");
                                while($category = mysqli_fetch_array($categories)) {
                                    $selected = ($category["categoryid"] == $r["categoryid"]) ? "selected" : "";
                                ?>
                                <option value="<?php echo $category["categoryid"]; ?>" <?php echo $selected; ?>><?php echo $category["name"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" value="<?php echo $r["price"]; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="<?php echo $r["quantity"]; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?php echo $r["description"]; ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <?php if(!empty($r["image"])) { ?>
                            <div class="mb-2">
                                <img src="<?php echo $r["image"]; ?>" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        <?php } ?>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" name="btnupdate" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Item
                        </button>
                        <a href="adminindex.php?pg=items" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                    
                    <?php
                    if(isset($_POST["btnupdate"])) {
                        $itemname = $_POST["itemname"];
                        $categoryid = $_POST["categoryid"];
                        $price = $_POST["price"];
                        $quantity = $_POST["quantity"];
                        $description = $_POST["description"];
                        $image = $r["image"]; // Keep current image by default
                        
                        // Handle image upload if a new image is provided
                        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                            $image = "uploads/".basename($_FILES["image"]["name"]);
                            move_uploaded_file($_FILES["image"]["tmp_name"], $image);
                        }
                        
                        // Update item
                        mysqli_query($conn, "UPDATE item SET 
                                      categoryid = $categoryid,
                                      itemname = '$itemname',
                                      price = $price,
                                      quantity = $quantity,
                                      description = '$description',
                                      image = '$image'
                                      WHERE itemid = $id");
                        
                        echo "<script>alert('Item updated successfully.');</script>";
                        echo "<script>window.location = 'adminindex.php?pg=items';</script>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Item Status</h5>
            </div>
            <div class="card-body">
                <?php if($r["quantity"] == 0) { ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>This item is out of stock.
                    </div>
                <?php } else if($r["quantity"] < 5) { ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle me-2"></i>This item is low in stock.
                    </div>
                <?php } else { ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>This item is in stock.
                    </div>
                <?php } ?>
                
                <div class="mt-4">
                    <h6>Item Tips:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Make sure image quality is good</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Write detailed descriptions</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Keep inventory up to date</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>