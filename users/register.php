<?php
$con = mysqli_connect("localhost", "root", "", "dbbenta");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Benta.ph</title>
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
        <div class="card p-4 shadow mx-auto" style="max-width: 500px;">
            <h3 class="text-center fw-bold mb-4"><i class="fas fa-user-plus text-primary"></i> User Registration</h3>
            <form method="POST">
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-user"></i></span>
                    <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-user"></i></span>
                    <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-phone"></i></span>
                    <input type="number" name="contact" class="form-control" placeholder="Contact Number" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text form-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>
                <button type="submit" name="btnRegister" class="btn btn-primary w-100">Register</button>
            </form>

            <div class="mt-3">
                <?php
                if (isset($_POST["btnRegister"])) {
                    $firstname = $_POST["firstname"];
                    $lastname = $_POST["lastname"];
                    $password = $_POST["password"];
                    $email = $_POST["email"];
                    $contact = $_POST["contact"];
                    $address = $_POST["address"];
                    $createddate = date("Y-m-d H:i:s");

                    $checkuser = mysqli_query($con, "SELECT * FROM user WHERE email = '$email'");
                    if (mysqli_num_rows($checkuser) > 0) {
                        echo "<div class='alert alert-danger mt-2'>Email already exists!</div>";
                    } else {
                        $insert = mysqli_query($con, "INSERT INTO user (firstname, lastname, email, password, contactnumber, address, createddate) 
                        VALUES ('$firstname', '$lastname', '$email', '$password', '$contact', '$address', '$createddate')");
                         if($insert) {
                            session_start();
                            $_SESSION['email'] = $email;
                            echo "<script>alert('Registration successful! Welcome to Benta.ph!'); window.location = '../index.php';</script>";
                        } else {
                            echo "<div class='alert alert-danger mt-2'>Registration failed. Please try again.</div>";
                        }
                    }
                }
                ?>
            </div>

            <div class="text-center mt-4">
                <p>Already registered? <a href="login.php" class="text-decoration-none text-primary">Login here</a></p>
                <p>Are you an admin? <a href="../admin/admin_login.php" class="text-decoration-none text-primary">Click here</a></p>
            </div>
        </div>
    </div>

</body>

</html>