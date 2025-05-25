<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "dbbenta");

// Get the page parameter
$pg = isset($_GET["pg"]) ? $_GET["pg"] : "homepage";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENTA.PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
      body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            font-size: 1rem;
            line-height: 1.6;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .navbar .nav-link {
            margin-right: 1rem;
        }

         footer {
            background-color: #212529;
            color: white;
            padding: 2rem 0;
            font-size: 0.95rem;
        }

        h3, h5 {
            font-weight: bold;
        }

</style>
</head>
<body>

   <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fs-5">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Benta<span class="text-primary">.ph</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">My Account</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0 d-flex align-items-center gap-3">
                <li class="nav-item">
                    <button class="btn btn-outline-success d-flex align-items-center" type="button">
                <i class="fa fa-shopping-cart"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    
    <main>
        <?php
        // Include the appropriate page based on the pg parameter
        switch($pg) {
            case 'homepage':
                include('users/homepage.php');
                break;
            case 'shop':
                include('users/shop.php');
                break;
            case 'about':
                include('users/about.php');
                break;
            case 'login':
                include('users/login.php');
                break;
            case 'register':
                include('users/register.php');
                break;
            case 'cart':
                include('users/cart.php');
                break;
            case 'checkout':
                include('users/checkout.php');
                break;
            case 'myaccount':
                include('users/myaccount.php');
                break;
            case 'transactions':
                include('users/transactions.php');
                break;
            case 'item_details':
                include('users/item_details.php');
                break;
            case 'update_account':
                include('users/update_account.php');
                break;
            default:
                include('users/homepage.php');
                break;
        }
        ?>
    </main>

 
<footer class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h5>Benta<span class="text-primary">.ph</span></h5>
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

</body>
</html>