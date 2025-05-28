<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f7f9;
            font-family: Arial, sans-serif;
        }
        .card-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
        }
        .quantity-control button {
            border: none;
            background: #eee;
            padding: 5px 10px;
            margin: 0 5px;
        }
        .item-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>

 
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand fw-bold" href="#">BentaPH</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Account</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
            </ul>
            <a href="cart.php" class="btn btn-outline-dark">
                <i class="bi bi-cart"></i> Cart
            </a>
        </div>
    </nav>


    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h3>Shopping Cart</h3>
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="https://i.imgur.com/B2FKZTp.jpg" class="item-img me-2"> Egg Roast</td>
                            <td>₱12.50</td>
                            <td>
                                <div class="quantity-control">
                                    <button>-</button>
                                    <span>1</span>
                                    <button>+</button>
                                </div>
                            </td>
                            <td>₱12.50</td>
                            <td><button class="btn btn-sm btn-outline-danger">Remove</button></td>
                        </tr>
                        <tr>
                            <td><img src="https://i.imgur.com/JG3uGzD.jpg" class="item-img me-2"> Spicy Chicken Roast</td>
                            <td>₱10.00</td>
                            <td>
                                <div class="quantity-control">
                                    <button>-</button>
                                    <span>1</span>
                                    <button>+</button>
                                </div>
                            </td>
                            <td>₱10.00</td>
                            <td><button class="btn btn-sm btn-outline-danger">Remove</button></td>
                        </tr>
                        <tr>
                            <td><img src="https://i.imgur.com/w1XzTDM.jpg" class="item-img me-2"> Rose berry cake</td>
                            <td>₱22.50</td>
                            <td>
                                <div class="quantity-control">
                                    <button>-</button>
                                    <span>1</span>
                                    <button>+</button>
                                </div>
                            </td>
                            <td>₱22.50</td>
                            <td><button class="btn btn-sm btn-outline-danger">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn btn-outline-primary btn-sm">&larr; Continue Shopping</a>
                    <button class="btn btn-outline-danger btn-sm">Clear All</button>
                </div>
                <h5 class="mt-3">Subtotal: <strong>₱45.00</strong></h5>
                <div class="mt-3">
                    <button class="btn btn-danger w-100" onclick="checkout()">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        function checkout() {
            window.location.href = "cart2.php"; 
        }
    </script>

</body>
</html>
