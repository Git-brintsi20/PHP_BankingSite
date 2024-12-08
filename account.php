<?php
session_start(); // Start the session

if (!isset($_SESSION['userid'])) {
    header("Location: https://localhost/dbms/login.php"); // Redirect to login if not logged in
    exit(); // Stop further execution of the code
}
include 'conn.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user inputs and sanitize them
    $name = trim($_POST['name']);
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);

    // Check if the customer already exists
    $stmt = $conn->prepare("SELECT * FROM customer WHERE customer_name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Customer already exists!";
    } else {
        // Insert new customer
        $stmt = $conn->prepare("INSERT INTO customer (customer_name, customer_street, customer_city) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $street, $city);
        
        if ($stmt->execute()) {
            echo "Account created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close(); // Close statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Account</title>
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
            padding: 15px;
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
            width: 40%;
    margin: 0 auto; /* Center the container */
    display: flex;
    flex-direction: column; /* Align items in a column */
    justify-content: center; /* Center items vertically */
    align-items: center; /* Center items horizontally */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: add some shadow for better visibility */
    border-radius: 10px; /* Optional: add rounded corners */
    background-color: white;
        }
        input[type="text"]{
            width: 100%;
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
        
        .message {
            margin: 20px 0;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }     .footer {
  padding: 20px;
  background-color: #333;
  color: white;
  text-align: center;
  font-size: 15px;
}
button{
    padding: 10px;;
    margin-top:10px;
    color:white;
    background-color: grey;
    border-radius: 10%;
    font-size: 20px;
}
   
    </style>
</head>
<body>
    <header class="header">
        <h1 style="font-size: 50px;">Open an Account</h1>
    </header>
    
    <nav class="nav">
        <ul>
            <li><a href="https://localhost/dbms/bank2.html">Home</a></li>
            <li><a href="https://localhost/dbms/login.php">Login</a></li>
            <li><a href="https://localhost/dbms/dashboard.php">Dashboard</a></li>
        </ul>
    </nav>
    <br>
    <br>
    <div class="container">
    <form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    
    <label for="street">Street:</label>
    <input type="text" name="street" required>
    
    <label for="city">City:</label>
    <input type="text" name="city" required>
    
    <button type="submit">Create Account</button>
</form>
</div>


        <?php if (isset($success)) echo "<p class='message success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='message error'>$error</p>"; ?>
    </div>
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
