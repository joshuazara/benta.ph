<?php 
$con = mysqli_connect("localhost", "root", "", "dbbenta");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        .hero-section {
            padding: 80px 0;
        }
        
        .feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            font-size: 1.5rem;
        }
        
        .card {
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        @media (max-width: 991.98px) {
            .hero-section {
                text-align: center;
                padding: 60px 0;
            }
            
            .hero-section img {
                margin-top: 40px;
            }
        }
        
        @media (max-width: 767.98px) {
            h1 {
                font-size: 2.5rem;
            }
            
            h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <section class="hero-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">ABOUT US</h1>
                    <p class="lead mb-4">Welcome to <span class="fw-bold">Benta.ph</span> – Your Ultimate Online Shopping Destination!</p>
                    <a href="#learn-more" class="btn btn-primary btn-lg rounded-pill px-4">Learn More</a>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" class="img-fluid rounded-3 shadow" alt="Online Shopping">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" id="learn-more">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4">Our Mission</h2>
                    <p class="lead">At <span class="fw-bold">Benta.ph</span>, we believe that everyone deserves access to quality products without breaking the bank. Our mission is to bring you a diverse range of affordable items that cater to your everyday needs and special occasions alike. Whether you're shopping for the latest fashion trends, home essentials, electronics, or unique gifts, Benta.ph is your go-to online store.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1887&q=80" class="img-fluid rounded-3 shadow" alt="Quality Products">
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5">
                        <h2 class="fw-bold mb-4">Our Goal: Affordability Meets Quality</h2>
                        <p>Benta.ph is committed to offering the best prices on the market without compromising on quality. We understand the importance of value for money, and our goal is to make shopping a delightful experience by providing high-quality products at prices you can afford.</p>
                        <p>By sourcing directly from manufacturers and trusted suppliers, we ensure that our customers get the best deals available.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Why Shop with Benta.ph?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white mb-4">
                                <i class="fas fa-store"></i>
                            </div>
                            <h5 class="fw-bold">Wide Selection</h5>
                            <p class="text-muted">From trendy apparel and accessories to household gadgets and tech innovations, our extensive catalog has something for everyone.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white mb-4">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h5 class="fw-bold">Customer Satisfaction</h5>
                            <p class="text-muted">Your satisfaction is our top priority. We strive to provide excellent customer service, fast shipping, and a hassle-free return policy.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white mb-4">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="fw-bold">Secure Shopping</h5>
                            <p class="text-muted">Shop with confidence knowing that your transactions are safe and secure with our advanced encryption technology.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white mb-4">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <h5 class="fw-bold">Community Focus</h5>
                            <p class="text-muted">We are proud to support local businesses and artisans by featuring their products on our platform, promoting sustainable and ethical shopping practices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-4">Join the Benta.ph Family Today</h2>
                    <p class="lead mb-4">Experience the joy of finding great deals on the products you love. Happy shopping!</p>
                    <a href="index.php" class="btn btn-light btn-lg rounded-pill px-5">Shop Now</a>
                </div>
            </div>
        </div>
    </section>

</body>
</html>