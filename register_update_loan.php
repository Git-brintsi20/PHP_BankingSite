<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: https://localhost/dbms/login.php");
    exit();
}

// Include the database connection file
include 'conn.php'; 

$username = $_SESSION['userid'];
$loan_number = "";
$branch_name = "";
$amount = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loan_number = $_POST['loan_number'];
    $branch_name = $_POST['branch_name'];
    $amount = $_POST['amount'];

    // Check if the loan already exists for the user
    $sql_check = "SELECT * FROM borrower WHERE customer_name = ? AND loan_number = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('si', $username, $loan_number);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // If the loan exists, update the loan amount and branch details
        $sql_update = "UPDATE loan SET branch_name = ?, amount = ? WHERE loan_number = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('sii', $branch_name, $amount, $loan_number);
        if ($stmt_update->execute()) {
            $message = "Loan details updated successfully!";
        } else {
            $message = "Error updating loan: " . $conn->error;
        }
    } else {
        // If the loan doesn't exist, register a new loan
        $sql_insert_loan = "INSERT INTO loan (loan_number, branch_name, amount) VALUES (?, ?, ?)";
        $stmt_insert_loan = $conn->prepare($sql_insert_loan);
        $stmt_insert_loan->bind_param('isi', $loan_number, $branch_name, $amount);
        if ($stmt_insert_loan->execute()) {
            // Register the borrower details in the borrower table
            $sql_insert_borrower = "INSERT INTO borrower (customer_name, loan_number) VALUES (?, ?)";
            $stmt_insert_borrower = $conn->prepare($sql_insert_borrower);
            $stmt_insert_borrower->bind_param('si', $username, $loan_number);
            if ($stmt_insert_borrower->execute()) {
                $message = "Loan registered successfully!";
            } else {
                $message = "Error registering borrower: " . $conn->error;
            }
        } else {
            $message = "Error registering loan: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Registration/Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
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
        form {
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #004B87;
            color: white;
            border: none;
            cursor: pointer;
        }
        .message {
            color: green;
            font-weight: bold;
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
        <h1>Loan Registration / Update</h1>
    </header>
    
    <nav class="nav">
        <ul>
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
            <li><a href="https://localhost/dbms/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
    <br> <br> <br> <br>

    <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>

    <form method="POST" action="">
        <label for="loan_number">Loan Number:</label>
        <input type="number" id="loan_number" name="loan_number" required value="<?php echo $loan_number; ?>">

        <label for="branch_name">Branch Name:</label>
        <input type="text" id="branch_name" name="branch_name" required value="<?php echo $branch_name; ?>">

        <label for="amount">Loan Amount:</label>
        <input type="number" id="amount" name="amount" required value="<?php echo $amount; ?>">

        <button type="submit">Submit</button>
    </form>
 <br><br> <br> <br> <br><br> <br> <br> <br> <br><br>
    <footer class="footer">
        <p>© 2024 State Bank of India. All rights reserved.</p>
    </footer>
</body>
</html>
