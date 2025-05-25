<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "dbbenta");

if (!isset($_SESSION['email'])) {
    // User not logged in
}

// Get the page parameter
$pg = isset($_GET["pg"]) ? $_GET["pg"] : "homepage";

// Handle logout
if ($pg == 'logout') {
    session_destroy();
    echo "<script>window.location = 'index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENTA.PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            line-height: 1.6;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .navbar .nav-link {
            font-weight: 500;
            margin: 0 5px;
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
        }

        .cart-btn {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer {
            background-color: #212529;
            color: white;
            padding: 3rem 0 2rem 0;
            margin-top: 4rem;
            font-size: 0.95rem;
        }

        .footer-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.25rem 0.5rem;
            text-decoration: none;
        }

        .footer-nav .nav-link:hover {
            color: white;
        }

        h3,
        h5 {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Benta<span class="text-primary">.ph</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['email'])) { ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?pg=myaccount">My Account</a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?pg=about">About Us</a></li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 d-flex align-items-center gap-3">
                    <!-- Cart button - always visible -->
                    <li class="nav-item">
                        <?php if (isset($_SESSION['email'])) { ?>
                            <a href="index.php?pg=cart" class="btn btn-outline-success d-flex align-items-center cart-btn">
                                <i class="fa fa-shopping-cart me-2"></i>Cart
                                <?php
                                // Get cart count for logged in user
                                $user_query = mysqli_query($conn, "SELECT userid FROM user WHERE email = '" . $_SESSION['email'] . "'");
                                if ($user_query && mysqli_num_rows($user_query) > 0) {
                                    $user_data = mysqli_fetch_array($user_query);
                                    $cart_count_query = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE userid = " . $user_data['userid']);
                                    if ($cart_count_query) {
                                        $cart_count_data = mysqli_fetch_array($cart_count_query);
                                        $cart_count = ($cart_count_data['total']) ? $cart_count_data['total'] : 0;
                                        if ($cart_count > 0) {
                                            echo "<span class='cart-badge'>" . $cart_count . "</span>";
                                        }
                                    }
                                }
                                ?>
                            </a>
                        <?php } else { ?>
                            <a href="users/login.php" class="btn btn-outline-success d-flex align-items-center cart-btn">
                                <i class="fa fa-shopping-cart me-2"></i>Cart
                            </a>
                        <?php } ?>
                    </li>
                    <!-- Login/Logout -->
                    <li class="nav-item">
                        <?php if (isset($_SESSION['email'])) { ?>
                            <a class="nav-link" href="index.php?pg=logout">Logout</a>
                        <?php } else { ?>
                            <a class="nav-link" href="users/login.php">Login</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php
        // Include the appropriate page based on the pg parameter
        switch ($pg) {
            case 'homepage':
                include('users/homepage.php');
                break;
            case 'about':
                include('users/about.php');
                break;
            case 'cart':
                if (isset($_SESSION['email'])) {
                    include('users/cart.php');
                } else {
                    echo "<script>alert('Please login to access your cart.'); window.location = 'users/login.php';</script>";
                }
                break;
            case 'checkout':
                if (isset($_SESSION['email'])) {
                    include('users/checkout.php');
                } else {
                    echo "<script>alert('Please login to checkout.'); window.location = 'users/login.php';</script>";
                }
                break;
            case 'myaccount':
                if (isset($_SESSION['email'])) {
                    include('users/myaccount.php');
                } else {
                    echo "<script>alert('Please login to access your account.'); window.location = 'users/login.php';</script>";
                }
                break;
            case 'transactions':
                if (isset($_SESSION['email'])) {
                    include('users/transactions.php');
                } else {
                    echo "<script>alert('Please login to view your transactions.'); window.location = 'users/login.php';</script>";
                }
                break;
            case 'item_details':
                include('users/item_details.php');
                break;
            case 'update_account':
                if (isset($_SESSION['email'])) {
                    include('users/update_account.php');
                } else {
                    echo "<script>alert('Please login to update your account.'); window.location = 'users/login.php';</script>";
                }
                break;
            default:
                include('users/homepage.php');
                break;
        }
        ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h5>Benta<span class="text-primary">.ph</span></h5>
                    <p class="mb-3">Your Ultimate Online Shopping Destination for affordable, quality products.</p>
                </div>
                <div class="col-lg-6 mb-4">
                    <h6 class="text-uppercase fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled footer-nav">
                        <li><a href="index.php" class="nav-link">Home</a></li>
                        <li><a href="index.php?pg=shop" class="nav-link">Shop</a></li>
                        <li><a href="index.php?pg=about" class="nav-link">About Us</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© <?php echo date("Y"); ?> Benta.ph. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>