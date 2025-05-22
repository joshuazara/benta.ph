<?php
if(!isset($conn)) {
    echo "<script>window.location = 'index.php';</script>";
}
?>

<div class="row mb-4">
    <div class="col">
        <h2><i class="fas fa-user me-2"></i>My Account</h2>
        <p class="text-muted">Update your admin password</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-key me-2"></i>Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="currentpassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentpassword" name="currentpassword" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="newpassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmpassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" name="btnupdate" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Password
                        </button>
                    </div>
                    
                    <?php
                    if(isset($_POST["btnupdate"])) {
                        $currentpassword = $_POST["currentpassword"];
                        $newpassword = $_POST["newpassword"];
                        $confirmpassword = $_POST["confirmpassword"];                      
                        
                        $checkQuery = mysqli_query($conn, "SELECT * FROM admin WHERE username = '{$_SESSION['admin_username']}' AND password = '$currentpassword'");
                        
                        if(mysqli_num_rows($checkQuery) == 0) {
                            echo "<div class='alert alert-danger mt-3'>Current password is incorrect.</div>";
                        } else if($newpassword != $confirmpassword) {
                            echo "<div class='alert alert-danger mt-3'>New passwords do not match.</div>";
                        } else {
                            
                            mysqli_query($conn, "UPDATE admin SET password = '$newpassword' WHERE username = '{$_SESSION['admin_username']}'");
                            echo "<div class='alert alert-success mt-3'>Password updated successfully.</div>";
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>