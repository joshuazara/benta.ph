<?php

session_start();

$con = mysqli_connect("localhost", "root", "", "dbbenta");
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">


    <title>My Account</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }



        .container {
            max-width: 900px;
            margin: auto;
        }



        h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }



        form {
            margin-bottom: 30px;
        }



        label {
            display: block;
            margin-top: 10px;
        }



        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {



            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;



        }



        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }



        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }



        th {
            background: #f4f4f4;
        }



        .btn {
            margin-top: 15px;
            padding: 8px 16px;
        }



        .scroll-table {
            max-height: 400px;
            overflow-y: auto;
            display: block;
        }
    </style>



</head>



<body>



    <div class="container">



        <h2>My Account</h2>



        <form id="updateAccountForm" method="POST" action="">



            <label for="name">Full Name:</label>



            <input type="text" id="name" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">




            <label for="address">Address:</label>



            <input type="text" id="address" name="address" placeholder="Address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">




            <label for="phone">Phone Number:</label>



            <input type="tel" id="phone" name="phone" placeholder="Number" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">




            <label for="email">Email:</label>



            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">




            <label for="password">Password:</label>



            <input type="password" id="password" name="password" placeholder="Enter new password">




            <button type="submit" class="btn">Update Account</button>



        </form>





        <h2>Transaction List</h2>



        <div class="scroll-table">



            <table>



                <thead>



                    <tr>



                        <th>Full Name</th>



                        <th>Delivery Address</th>



                        <th>Contact Number</th>



                        <th>Subtotal</th>



                        <th>Fee</th>



                        <th>Total</th>



                        <th>Status</th>



                        <th>Date</th>



                        <th>Action</th>



                    </tr>



                </thead>



                <tbody id="transactionTable">



                    <?php if (count($transactions) > 0): ?>



                        <?php foreach ($transactions as $t): ?>



                            <tr>



                                <td><?php echo $t['fullName']; ?></td>

                                <td><?php echo $t['address']; ?></td>

                                <td><?php echo $t['phone']; ?></td>

                                <td><?php echo $t['subtotal']; ?></td>

                                <td><?php echo $t['fee']; ?></td>

                                <td><?php echo $t['total']; ?></td>

                                <td><?php echo $t['status']; ?></td>

                                <td><?php echo $t['date']; ?></td>

                                <td><button class="btn" onclick="viewDetails('<?php echo $t['fullName']; ?>')">View</button></td>



                            </tr>



                        <?php endforeach; ?>



                    <?php else: ?>



                        <tr>
                            <td colspan="9">No transactions found.</td>
                        </tr>



                    <?php endif; ?>



                </tbody>



            </table>



        </div>



    </div>



    <script>
        // JavaScript function for the action button



        function viewDetails(name) {



            alert('View details for ' + name);



        }
    </script>



</body>



</html>