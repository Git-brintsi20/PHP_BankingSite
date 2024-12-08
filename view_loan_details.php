<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: https://localhost/dbms/login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch loan details from the database
include 'conn.php'; // Include database connection
$username = $_SESSION['userid'];

// Assuming you have a way to associate users with loans through the borrower and customer tables
$sql = "SELECT l.loan_number, l.amount
        FROM loan l
        JOIN borrower b ON l.loan_number = b.loan_number
        JOIN customer c ON b.customer_name = c.customer_name
        WHERE c.customer_name = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$loans = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Details</title>
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
        <h1 style="font-size: 45px;">Loan Details</h1>
    </header>
    
    <nav class="nav">
        <ul>
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
            <li><a href="https://localhost/dbms/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h2>Your Loan Information:</h2>
        <?php if ($loans->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Loan Number</th>
                    <th>Amount</th>
                </tr>
                <?php while ($loan = $loans->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($loan['loan_number']); ?></td>
                    <td><?php echo htmlspecialchars($loan['amount']); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p><b>No loans found.</b></p>
            <p><b>Please check if you have applied for any loans.</b></p>
            <p><b>If you haven't applied for any loans yet, go back to the dashboard and click on Register/Update Loan in the Navigation Menu.</b></p>
        <?php endif; ?>
    </div><br>
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
