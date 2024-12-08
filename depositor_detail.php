<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: https://localhost/dbms/login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection
$link = mysqli_connect('localhost', 'root', '', '23BCS220');

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT depositer.customer_name,depositer.account_number , account.balance  FROM depositer JOIN account ON depositer.account_number=account.account_number;";
$result = mysqli_query($link, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depositor Details</title>
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
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #004B87;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #004B87;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
        <h1 style="font-size: 50px;">Depositor Details</h1>
    </header>
    
    <nav class="nav">
        <ul>
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
            <li><a href="https://localhost/dbms/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h2>Depositors Information</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Account Number</th>
                    <th>Balance</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['account_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['balance']); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No depositors found.</p>
        <?php endif; ?>
    </div>
    <br>
    <footer class="footer">
        <p>© 2024 State Bank of India. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
mysqli_close($link);
?>
