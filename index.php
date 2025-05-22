<?php
$conn = mysqli_connect("localhost", "root", "", "dbbenta");
session_start();

if(isset($_SESSION['admin_username'])) {
    echo "<script>window.location = 'adminindex.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENTA.PH - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="mb-0">BENTA.PH</h4>
                        <p class="mb-0">Admin Login</p>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="btnlogin" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                            
                            <?php
                            if(isset($_POST["btnlogin"])) {
                                $username = $_POST["username"];
                                $password = $_POST["password"];
                                
                                $q = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
                                
                                if(mysqli_num_rows($q) > 0) {
                                    $_SESSION['admin_username'] = $username;
                                    echo "<script>window.location = 'adminindex.php';</script>";
                                } else {
                                    echo "<div class='alert alert-danger mt-3'>Invalid username or password.</div>";
                                }
                            }
                            ?>
                        </form>
                        
                        <div class="mt-3 text-center">
                            <small class="text-muted">Default login: admin / admin</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>