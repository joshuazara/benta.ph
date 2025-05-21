<?php
    // Start session to maintain admin login state
    session_start();
    
    // Check if admin is logged in, if not redirect to login page
    if(!isset($_SESSION['admin_username'])) {
        header("Location: admin_login.php");
        exit();
    }
    
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "dbbenta");
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Get page parameter for indexing
    $pg = isset($_GET["pg"]) ? $_GET["pg"] : "dashboard";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BENTA.PH - Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            width: 250px;
            background-color: #212529;
            color: white;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .sidebar .nav-link {
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid #0d6efd;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .sidebar.collapsed {
            width: 60px;
        }
        
        .sidebar.collapsed .sidebar-header .title,
        .sidebar.collapsed .nav-link-text {
            display: none;
        }
        
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 5px;
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 20px;
        }
        
        .card-dashboard {
            height: 100%;
            transition: transform 0.3s ease;
        }
        
        .card-dashboard:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            font-size: 2rem;
            color: #0d6efd;
        }
        
        .btn-toggle-sidebar {
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h5 class="mb-0 title">BENTA.PH</h5>
            <button class="btn-toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="adminindex.php?pg=dashboard" class="nav-link <?php echo ($pg == 'dashboard') ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="adminindex.php?pg=myaccount" class="nav-link <?php echo ($pg == 'myaccount') ? 'active' : ''; ?>">
                    <i class="fas fa-user"></i>
                    <span class="nav-link-text">My Account</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="adminindex.php?pg=transactions" class="nav-link <?php echo ($pg == 'transactions' || $pg == 'transaction_details') ? 'active' : ''; ?>">
                    <i class="fas fa-exchange-alt"></i>
                    <span class="nav-link-text">Transactions</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="adminindex.php?pg=management" class="nav-link <?php echo ($pg == 'management') ? 'active' : ''; ?>">
                    <i class="fas fa-cogs"></i>
                    <span class="nav-link-text">Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="admin_logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-link-text">Log out</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Top Navigation Bar -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3">BENTA.PH Admin Panel</h1>
                        <a href="admin_logout.php" class="btn btn-sm btn-outline-dark">
                            <i class="fas fa-sign-out-alt me-2"></i>Log out
                        </a>
                    </div>
                    <hr>
                </div>
            </div>

            <!-- Dynamic Content Based on Page Parameter -->
            <?php
            switch($pg) {
                case "dashboard":
                    include("admin_dashboard.php");
                    break;
                case "myaccount":
                    include("admin_myaccount.php");
                    break;
                case "transactions":
                    include("admin_transactions.php");
                    break;
                case "transaction_details":
                    include("admin_transaction_details.php");
                    break;
                case "management":
                    include("admin_management.php");
                    break;
                case "categories":
                    include("admin_categories.php");
                    break;
                case "add_category":
                    include("admin_add_category.php");
                    break;
                case "edit_category":
                    include("admin_edit_category.php");
                    break;
                case "items":
                    include("admin_items.php");
                    break;
                case "add_item":
                    include("admin_add_item.php");
                    break;
                case "edit_item":
                    include("admin_edit_item.php");
                    break;
                default:
                    include("admin_dashboard.php");
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Toggle sidebar function
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }
        
        // Confirm delete function
        function confirmDelete(message, url) {
            if (confirm(message)) {
                window.location.href = url;
            }
        }
    </script>
</body>
</html>