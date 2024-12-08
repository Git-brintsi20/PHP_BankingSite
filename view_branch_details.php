<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: https://localhost/dbms/login.php"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include 'conn.php';

// Fetch branch details from the database based on the logged-in user's branch
$username = $_SESSION['userid'];  // Assuming each user is associated with a branch
$sql = "SELECT * FROM branch WHERE branch_name IN (SELECT branch_name FROM account WHERE account_number IN (SELECT account_number FROM depositer WHERE customer_name = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$branches = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header, .footer {
            background-color: #004B87;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .nav {
            background-color: #333;
            overflow: hidden;
        }
        .nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
        }
        .nav ul li {
            padding: 14px 20px;
        }
        .nav ul li a {
            color: white;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        .container {
            padding: 40px 5%;
        }
        table {
            width: 100%; /* Set width to 100% for better alignment */
            border-collapse: collapse; /* Collapse borders for a cleaner look */
            margin-top: 20px; /* Add some space above the table */
        }
        th, td {
            border: 1px solid #004B87; /* Set border color and style */
            padding: 10px; /* Add padding for better spacing */
            text-align: left; /* Align text to the left */
        }
        th {
            background-color: #004B87; /* Set a background color for header */
            color: white; /* Set text color for header */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows for better readability */
        }
        .footer {
            padding: 20px;
            background-color: #333;
            color: white;
            text-align: center;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Branch Details</h1>
    </header>

    <nav class="nav">
        <ul>
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
            <li><a href="https://localhost/dbms/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Your Branch Information</h2>
        <?php if ($branches->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Branch Name</th>
                    <th>Branch City</th>
                    <th>Assets</th>
                </tr>
                <?php while ($branch = $branches->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $branch['branch_name']; ?></td>
                    <td><?php echo $branch['branch_city']; ?></td>
                    <td><?php echo $branch['assests']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No branch information found.</p>
        <?php endif; ?>
    </div>
    <br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

    <footer class="footer">
        <p>© 2024 State Bank of India. All rights reserved.</p>
    </footer>
</body>
</html>