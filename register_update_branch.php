<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: https://localhost/dbms/login.php"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include 'conn.php';

// Define variables to store form data and error messages
$branchName = $branchCity = $assets = $message = "";
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    if (empty($_POST["branch_name"])) {
        $message = "Branch name is required.";
        $error = true;
    } else {
        $branchName = $_POST["branch_name"];
    }

    $branchCity = $_POST["branch_city"];
    $assets = $_POST["assets"];

    // If no errors, proceed to insert or update branch details
    if (!$error) {
        // Check if branch already exists
        $sql = "SELECT * FROM branch WHERE branch_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $branchName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If branch exists, update it
            $sqlUpdate = "UPDATE branch SET branch_city = ?, assests = ? WHERE branch_name = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param('sis', $branchCity, $assets, $branchName);
            if ($stmtUpdate->execute()) {
                $message = "Branch details updated successfully.";
            } else {
                $message = "Error updating branch: " . $conn->error;
            }
        } else {
            // If branch doesn't exist, insert it
            $sqlInsert = "INSERT INTO branch (branch_name, branch_city, assests) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param('ssi', $branchName, $branchCity, $assets);
            if ($stmtInsert->execute()) {
                $message = "Branch registered successfully.";
            } else {
                $message = "Error registering branch: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register/Update Branch</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
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
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #004B87;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #003366;
        }
        .message {
            margin: 20px 0;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        <h1>Register/Update Branch</h1>
    </header>

    <nav class="nav">
        <ul>
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
            <li><a href="https://localhost/dbms/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
    <br><br> <br> <br> <br>
    <div class="container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="branch_name">Branch Name</label>
                <input type="text" name="branch_name" id="branch_name" value="<?php echo $branchName; ?>" required>
            </div>
            <div class="form-group">
                <label for="branch_city">Branch City</label>
                <input type="text" name="branch_city" id="branch_city" value="<?php echo $branchCity; ?>">
            </div>
            <div class="form-group">
                <label for="assets">Assets</label>
                <input type="number" name="assets" id="assets" value="<?php echo $assets; ?>">
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
    <br><br> <br> <br> <br><br> <br> <br> <br> 
    <footer class="footer">
        <p>© 2024 State Bank of India. All rights reserved.</p>
    </footer>
</body>
</html>
