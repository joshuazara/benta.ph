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
    <title>BENTA.PH - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .register-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-5">
            <div class="col-md-6 col-lg-5">
                <div class="card register-card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>BENTA.PH</h3>
                        <p class="mb-0">Create Your Account</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="contactnumber" class="form-label">Contact Number</label>
                                <input type="number" class="form-control" id="contactnumber" name="contactnumber" required>
                            </div>
                            
                            <button type="submit" name="btnregister" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                            
                            <?php
                            if(isset($_POST["btnregister"])) {
                                $firstname = $_POST["firstname"];
                                $lastname = $_POST["lastname"];
                                $email = $_POST["email"];
                                $password = $_POST["password"];
                                $address = $_POST["address"];
                                $contactnumber = $_POST["contactnumber"];
                                $createddate = date("Y-m-d H:i:s");
                                
                                // Check if email already exists
                                $checkEmail = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
                                if(mysqli_num_rows($checkEmail) > 0) {
                                    echo "<div class='alert alert-danger'>Email already exists. Please use a different email.</div>";
                                } else {
                                    mysqli_query($conn, "INSERT INTO user(firstname, lastname, email, password, address, contactnumber, createddate) 
                                                    VALUES('$firstname', '$lastname', '$email', '$password', '$address', $contactnumber, '$createddate')");
                                    
                                    echo "<div class='alert alert-success'>Account created successfully! You can now login.</div>";
                                    echo "<script>setTimeout(function(){ window.location = 'login.php'; }, 2000);</script>";
                                }
                            }
                            ?>
                        </form>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                            <p class="mb-0"><a href="index.php" class="text-decoration-none">Back to Home</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>