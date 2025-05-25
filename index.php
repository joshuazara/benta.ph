<?php
$conn = mysqli_connect("localhost", "root", "", "dbbenta");
session_start();

// Get current page from URL parameter
$pg = isset($_GET["pg"]) ? $_GET["pg"] : "home";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENTA.PH - Your Ultimate Online Shopping Destination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .card-product {
            transition: transform 0.3s ease;
            height: 100%;
        }
        .card-product:hover {
            transform: translateY(-5px);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        .footer {
            background-color: #212529;
            color: white;
            padding: 40px 0 20px 0;
        }
        .navbar-nav .nav-link.active {
            font-weight: bold;
        }
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-shopping-cart me-2"></i>BENTA.PH
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($pg == 'home') ? 'active' : ''; ?>" href="index.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($pg == 'shop') ? 'active' : ''; ?>" href="index.php?pg=shop">
                            <i class="fas fa-store me-1"></i>Shop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($pg == 'about') ? 'active' : ''; ?>" href="index.php?pg=about">
                            <i class="fas fa-info-circle me-1"></i>About Us
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['userid'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($pg == 'cart') ? 'active' : ''; ?>" href="index.php?pg=cart">
                                <i class="fas fa-shopping-cart me-1"></i>Cart
                                <?php
                                // Get cart count
                                $cartQuery = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE userid = {$_SESSION['userid']}");
                                $cartRow = mysqli_fetch_array($cartQuery);
                                $cartCount = $cartRow['total'] ? $cartRow['total'] : 0;
                                if($cartCount > 0) {
                                    echo "<span class='cart-count'>$cartCount</span>";
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?php echo $_SESSION['firstname']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?pg=myaccount"><i class="fas fa-user me-2"></i>My Account</a></li>
                                <li><a class="dropdown-item" href="index.php?pg=transactions"><i class="fas fa-list me-2"></i>My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php
        // Include the appropriate page based on the 'pg' parameter
        if ($pg == "home") { include("home.php"); }
        else if ($pg == "shop") { include("shop.php"); }
        else if ($pg == "about") { include("about.php"); }
        else if ($pg == "cart") { include("cart.php"); }
        else if ($pg == "checkout") { include("checkout.php"); }
        else if ($pg == "myaccount") { include("myaccount.php"); }
        else if ($pg == "transactions") { include("transactions.php"); }
        else if ($pg == "transaction_details") { include("transaction_details.php"); }
        else if ($pg == "item_details") { include("item_details.php"); }
        else { include("home.php"); } // Default to home
        ?>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-shopping-cart me-2"></i>BENTA.PH</h5>
                    <p class="text-muted">Your ultimate online shopping destination for quality products at affordable prices.</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="index.php?pg=shop" class="text-muted text-decoration-none">Shop</a></li>
                        <li><a href="index.php?pg=about" class="text-muted text-decoration-none">About Us</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6>Customer Service</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Contact Us</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Returns</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6>Contact Info</h6>
                    <p class="text-muted mb-1"><i class="fas fa-envelope me-2"></i>support@benta.ph</p>
                    <p class="text-muted mb-1"><i class="fas fa-phone me-2"></i>+63 123 456 7890</p>
                    <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Philippines</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; 2025 BENTA.PH. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="admin_login.php" class="text-muted text-decoration-none small">Admin Panel</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>