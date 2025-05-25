<?php 
    $con = mysqli_connect("localhost", "root", "", "dbbenta");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>BENTA.PH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
       .product-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1rem;
        }

        .form-control {
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            border-radius: 0.375rem;
        }

        h3, h5 {
            font-weight: bold;
        }
       
    </style>
</head>
<body>



<!-- Banner -->
<div class="container mt-4 mb-4">
    <div class="card text-center border-0 shadow-sm">
        <div class="card-body py-4">
            <h3 class="card-title fw-bold">SHOP NOW!</h3>
        </div>
    </div>
</div>

<!-- Search Bar -->
<div class="container mb-4">
    <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
</div>

<!-- Products Section -->
<div class="container">
    <!-- Tabs -->
    <ul class="nav nav-tabs nav-fill mb-4">
        <li class="nav-item me-3">
            <a class="nav-link active" aria-current="page" href="#">All</a>
        </li>
        <li class="nav-item me-3">
            <a class="nav-link" href="#">Smartphones</a>
        </li>
        <li class="nav-item me-3">
            <a class="nav-link" href="#">Gaming Phones</a>
        </li>
        <li class="nav-item me-3">
            <a class="nav-link" href="#">Foldables</a>
        </li>
    </ul>

    <!-- Heading -->
    <div class="mb-3">
        <h4 class="fw-bold">Featured Products</h4>
    </div>

    <div class="row g-4">
        <?php
        $q = mysqli_query($con, "SELECT * FROM item");

        if (mysqli_num_rows($q) > 0) {
            while ($r = mysqli_fetch_array($q)) {
        ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card product-card">
                <?php 
                $img = !empty($r['image']) ? $r['image'] : 'images/default.png';
                echo '<img src="' . $img . '" class="product-img card-img-top" alt="Product Image">';
                ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $r['itemname']; ?></h5>
                    <p class="card-text mb-1"><strong>Quantity:</strong> <?php echo $r['quantity']; ?></p>
                    <p class="card-text mb-3"><strong>Price:</strong> ₱<?php echo number_format($r['price'], 2); ?></p>
                    <a href="#" class="btn btn-primary w-100">Details</a>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<p class='text-muted'>No products available at the moment. Please check back later.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
