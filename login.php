<?php
session_start(); // Start the session

// Include database connection
include 'conn.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials in the correct table `master_login`
    $sql = "SELECT * FROM master_login WHERE userid = ?";
    $stmt = $conn->prepare($sql); // Using MySQLi to prepare the statement
    $stmt->bind_param('s', $username); // Bind the username to the query
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set

    if ($user = $result->fetch_assoc()) { // Fetch the result as an associative array
        // Check if the entered password matches the plain text password in the database
        if ($password === $user['password']) { // Plain text comparison
            $_SESSION['userid'] = $username; // Set session variable
            header("Location: https://localhost/dbms/dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid username or password."; // Password doesn't match
        }
    } else {
        $error = "Invalid username or password."; // User not found
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            background-color: #004B87;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size:30px;
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
  font-size: 1.2rem;
}

.nav ul li a:hover {
  background-color: #575757;
}

        .container {

    padding: 40px 5%;
    width: 40%;
    margin: 0 auto; /* Center the container */
    display: flex;
    flex-direction: column; /* Align items in a column */
    justify-content: center; /* Center items vertically */
    align-items: center; /* Center items horizontally */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: add some shadow for better visibility */
    border-radius: 10px; /* Optional: add rounded corners */
    background-color: white; /* Optional: background color for the form */
}

input[type="text"], input[type="password"] {
    width: 90%;
    padding: 10px;
    margin: 5px 0 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #004B87;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
}

        .footer {
  padding: 20px;
  background-color: #333;
  color: white;
  text-align: center;
  font-size:15px;
}
.header {
    display: flex;
    align-items: center;
    padding: 20px;
    background-color: #004B87;
    color: #fff;
    position: relative; /* Allows absolute positioning for title */
}

.logo {
    margin-right: 20px; /* Add some space between the logo and the title */
}

.logo-image {
    height: 200px;
    width: 200px;
}

.title {
    flex: 1; /* Allows title to take remaining space */
    display: flex;
    justify-content: center; /* Centers the title horizontally */
}

.title h1 {
    font-size: 5rem;
    font-weight: bold;
    padding: 0;
    margin: 0; /* Remove default margin for better centering */
}


    </style>
</head>
<body>
    <header class="header">
    <div class="logo">
            <img src="https://localhost/dbms/images/sbi.png" alt="SBI Logo" class="logo-image">
        </div.
        <div class="title"></div>
        <h1>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SBI Login </h1>
    </header>
    
    <nav class="nav">
        <ul>
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
        </ul>
    </nav>
    <br>
    <br>
    <div class="container">
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </form>
    </div>
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
