<?php
// Database connection file

$servername = "localhost"; // Hostname of the database server
$username = "root";        // Your database username
$password = "";            // Your database password (if any)
$dbname = "23bcs220";          // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
