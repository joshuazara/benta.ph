<?php
// Check if directly accessed
if(!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Welcome to BENTA.PH</h1>
                <p class="lead mb-4">Your Ultimate Online Shopping Destination! Discover quality products at unbeatable prices.</p>
                <div class="d-flex gap-3">
                    <a href="index.php?pg=shop" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <?php if(!isset($_SESSION['userid'])) { ?>
                    <a href="register.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Join Us
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <i class="fas fa-shopping-cart" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="mb-3">Why Choose BENTA.PH?</h2>
                <p class="text-muted">Discover what makes us your best shopping choice</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                    <h5>Affordable Prices</h5>
                    <p class="text-muted">Get the best deals on quality products without breaking the bank.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-shipping-fast fa-2x"></i>
                    </div>
                    <h5>Fast Delivery</h5>
                    <p class="text-muted">Quick and reliable shipping to get your orders to you fast.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h5>Secure Shopping</h5>
                    <p class="text-muted">Shop with confidence with our secure payment system.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-headset fa-2x"></i>
                    </div>
                    <h5>24/7 Support</h5>
                    <p class="text-muted">Our customer service team is here to help you anytime.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col">
                <h2 class="mb-3">Featured Products</h2>
                <p class="text-muted">Check out our most popular items</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php
            // Get 4 random featured products
            $featuredQuery = mysqli_query($conn, "SELECT i.*, c.name as categoryname 
                                               FROM item i 
                                               LEFT JOIN category c ON i.categoryid = c.categoryid 
                                               WHERE i.quantity > 0 
                                               ORDER BY RAND() 
                                               LIMIT 4");
            
            while($product = mysqli_fetch_array($featuredQuery)) {
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-product border-0 shadow-sm">
                        <?php if(!empty($product["image"])) { ?>
                            <img src="<?php echo $product["image"]; ?>" class="card-img-top product-image" alt="<?php echo $product["itemname"]; ?>">
                        <?php } else { ?>
                            <div class="card-img-top product-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image text-muted fa-3x"></i>
                            </div>
                        <?php } ?>
                        <div class="card-body">
                            <h6 class="card-title"><?php echo $product["itemname"]; ?></h6>
                            <p class="text-muted small mb-2"><?php echo $product["categoryname"]; ?></p>
                            <p class="text-primary fw-bold mb-3">₱<?php echo number_format($product["price"], 2); ?></p>
                            <a href="index.php?pg=item_details&id=<?php echo $product["itemid"]; ?>" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php
            }
            
            if(mysqli_num_rows($featuredQuery) == 0) {
                echo "<div class='col-12 text-center'><p class='text-muted'>No products available at the moment.</p></div>";
            }
            ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="index.php?pg=shop" class="btn btn-primary btn-lg">
                <i class="fas fa-store me-2"></i>View All Products
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="mb-3">Stay Updated!</h3>
                <p class="mb-0">Get notified about new products and special offers.</p>
            </div>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Enter your email address">
                    <button class="btn btn-light" type="button">
                        <i class="fas fa-envelope me-1"></i>Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>