<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login - Benta.ph</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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
            <h3 class="text-center fw-bold mb-4"><i class="fas fa-user-shield text-dark"></i> Admin Login</h3>
            <form method="post">
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" name="btnLogin" class="btn btn-dark w-100">Login</button>
            </form>

            <div class="mt-3">
                <?php
                if (isset($_POST["btnLogin"])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
                    $result = mysqli_query($con, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $_SESSION['admin_username'] = $username;
                        echo "<script>window.location.href = 'index.php';</script>";
                    } else {
                        echo "<div class='alert alert-danger'>Invalid admin credentials.</div>";
                    }
                }
                ?>
            </div>

            <div class="text-center mt-4">
                <p>Not an admin? <a href="../users/login.php" class="text-primary text-decoration-none">User login</a></p>
            </div>
        </div>
    </div>

</body>

</html>