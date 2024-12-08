<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: https://localhost/dbms/login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user details from the master_login table
include 'conn.php'; // Include database connection
$username = $_SESSION['userid'];

// Adjust the query to fetch from the correct table (master_login instead of users)
$sql = "SELECT * FROM master_login WHERE userid = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "Error: User not found.";
        exit();
    }
} else {
    echo "Error preparing statement: " . $conn->error; // Added error handling for statement preparation
    exit();
}

// Database connection for fetching depositor and borrower details
$link = mysqli_connect('localhost', 'root', '', '23BCS220');
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch depositor details
$query_depositors = "SELECT depositer.customer_name, depositer.account_number, account.balance 
                     FROM depositer 
                     JOIN account ON depositer.account_number = account.account_number";
$result_depositors = mysqli_query($link, $query_depositors);

// Fetch borrower details
$query_borrowers = "SELECT borrower.customer_name, borrower.loan_number, loan.amount 
                    FROM borrower 
                    JOIN loan ON borrower.loan_number = loan.loan_number";
$result_borrowers = mysqli_query($link, $query_borrowers);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            font-size: 30px;
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
            display: flex;
            flex: column;
            justify-content: space-around;

            
        }
        table {
            width: 150%;
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
        <h1>Welcome to Your Dashboard</h1>
    </header>
    
    <nav class="nav">
        <ul>
           
            <li><a href="https://localhost/dbms/account.php">Open account</a></li>
            <li><a href="https://localhost/dbms/view_account_details.php">Account Details</a></li>   
            <li><a href="https://localhost/dbms/view_loan_details.php">Loan Details</a></li>
            <!-- <li><a href="https://localhost/dbms/register_update_loan.php">Register/Update Loan</a></li> -->
            <li><a href="https://localhost/dbms/view_branch_details.php">Branch Details</a></li>
            <!-- <li><a href="https://localhost/dbms/register_update_branch.php">Register/Update Branch</a></li> -->
            <li></li><li></li><li></li><li></li>  <li></li>  <li></li>  <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> 
            <li><a href="https://localhost/dbms/view_all_branch_details.php">All Branch Details </a></li>     
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
            <li><a href="https://localhost/dbms/logout.php">Logout</a></li>

        </ul>
    </nav>
    
    <div class="container">
      <div>
        <h2 id="depositor detail">Depositor Details</h2>
        <?php if (mysqli_num_rows($result_depositors) > 0): ?>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Account Number</th>
                    <th>Balance</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result_depositors)): ?>
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
  
        <div>
        <h2 id="borrower detail">Borrower Details</h2>
        <?php if (mysqli_num_rows($result_borrowers) > 0): ?>
            <table>
                <tr>
                    <th>Customer Name</th>
                    <th>Loan Number</th>
                    <th>Amount  </th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result_borrowers)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['loan_number']); ?></td>
                    <td colspan="3"><?php echo htmlspecialchars($row['amount']); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No borrowers found.</p>
        <?php endif; ?>
        </div>
        <div><br></div>
    </div>
    
    <footer class="footer">
        <p>© 2024 State Bank of India. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
mysqli_close($link);
?>
