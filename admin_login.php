<?php
// Start session
session_start();

// If admin is already logged in, redirect to admin panel
if(isset($_SESSION['admin_username'])) {
    header("Location: adminindex.php");
    exit();
}

// Check for form submission
if(isset($_POST['login'])) {
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "dbbenta");
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Get form inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query the admin table
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    // Check if user exists
    if(mysqli_num_rows($result) > 0) {
        // Set session variables
        $_SESSION['admin_username'] = $username;
        
        // Redirect to admin panel
        header("Location: adminindex.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}

// Check if database needs admin setup
$conn = mysqli_connect("localhost", "root", "", "dbbenta");
$check_admin = "SELECT * FROM admin";
$admin_result = mysqli_query($conn, $check_admin);

if(mysqli_num_rows($admin_result) == 0) {
    // Insert default admin (username: admin, password: admin)
    $insert_admin = "INSERT INTO admin (username, password) VALUES ('admin', 'admin')";
    mysqli_query($conn, $insert_admin);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENTA.PH - Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
        }
        
        .card-header {
            background-color: #212529;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            width: 100%;
            padding: 12px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <div class="logo">BENTA.PH</div>
                <p class="mb-0">Admin Login</p>
            </div>
            <div class="card-body">
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>
                
                <div class="mt-3 text-center">
                    <small class="text-muted">Default login: admin / admin</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>