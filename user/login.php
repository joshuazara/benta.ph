<?php
$conn = mysqli_connect("localhost", "root", "", "dbbenta");
session_start();

if(isset($_SESSION['userid'])) {
    echo "<script>window.location = 'index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENTA.PH - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>BENTA.PH</h3>
                        <p class="mb-0">Welcome Back!</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="btnlogin" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                            
                            <?php
                            if(isset($_POST["btnlogin"])) {
                                $email = $_POST["email"];
                                $password = $_POST["password"];
                                
                                $q = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' AND password = '$password'");
                                
                                if(mysqli_num_rows($q) > 0) {
                                    $user = mysqli_fetch_array($q);
                                    $_SESSION['userid'] = $user['userid'];
                                    $_SESSION['firstname'] = $user['firstname'];
                                    $_SESSION['lastname'] = $user['lastname'];
                                    $_SESSION['email'] = $user['email'];
                                    echo "<script>window.location = 'index.php';</script>";
                                } else {
                                    echo "<div class='alert alert-danger'>Invalid email or password.</div>";
                                }
                            }
                            ?>
                        </form>
                        
                        <div class="text-center">
                            <p class="mb-0">Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
                            <p class="mb-0"><a href="index.php" class="text-decoration-none">Back to Home</a></p>
                            <hr>
                            <p class="mb-0"><small><a href="admin_login.php" class="text-muted text-decoration-none">Admin Login</a></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>