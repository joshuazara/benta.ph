<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Login - Benta.ph</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .form-icon {
            width: 38px;
            text-align: center;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">Benta<span class="text-primary">.ph</span></a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card p-4 shadow mx-auto" style="max-width: 450px;">
            <h3 class="text-center fw-bold mb-4"><i class="fas fa-sign-in-alt text-primary"></i> User Login</h3>
            <form method="post">
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-envelope"></i></span>
                    <input type="text" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="btnLogin" class="btn btn-primary w-100">Login</button>
            </form>

            <div class="mt-3">
                <?php
                if (isset($_POST["btnLogin"])) {
                    $email = $_POST['email'];
                    $password = md5($_POST['password']);

                    $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
                    $result = mysqli_query($con, $query);

                    if (mysqli_num_rows($result) > 0) {             
                        $_SESSION['email'] = $email;
                        echo "<script>window.location.href = '../index.php';</script>";
                    } else {
                        echo "<div class='alert alert-danger'>Invalid login credentials.</div>";
                    }
                }
                ?>
            </div>

            <div class="text-center mt-4">
                <p>Don't have an account? <a href="register.php" class="text-primary text-decoration-none">Register here</a></p>
                <p>Are you an admin? <a href="../admin/admin_login.php" class="text-primary text-decoration-none">Login here</a></p>
            </div>
        </div>
    </div>

</body>

</html>