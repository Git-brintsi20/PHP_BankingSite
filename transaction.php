<?php
session_start(); // Start the session


// Fetch user details from the master_login table
include 'conn.php'; // Include database connection

// Assume the customer name is passed from front-end, e.g., using POST method
$customer_name = $_POST['customer_name']; // Example: 'Priya'

// Query to get the account balance and the account creation date
$sql = "SELECT a.balance, a.DATE FROM account a
        JOIN depositer d ON a.account_number = d.account_number
        JOIN customer c ON c.customer_name = d.customer_name
        WHERE c.customer_name = '$customer_name'";

$result = $conn->query($sql);

// Check if the result exists
if ($result->num_rows > 0) {
    // Fetch the data for the customer
    $row = $result->fetch_assoc();
    $balance = $row['balance'];
    $account_date = $row['DATE'];

    // Start a transaction
    $conn->begin_transaction();

    // Check if the balance is less than 500
    if ($balance < 500) {
        // Account balance is less than 500, terminate the account
        $terminate_sql = "DELETE FROM account WHERE account_number = (SELECT account_number FROM depositer WHERE customer_name = '$customer_name')";
        if ($conn->query($terminate_sql) === TRUE) {
            echo "Account terminated for $customer_name due to low balance.<br>";
        } else {
            echo "Error terminating account: " . $conn->error;
        }
    }

    // Check if the account creation year is after 2010
    $account_year = substr($account_date, 0, 4); // Extract the year from the date
    if ($account_year >= 2010) {
        // Commit the transaction for accounts created after 2010
        $conn->commit();
        echo "Transaction COMMITTED for $customer_name.<br>";
    } else {
        // Rollback the transaction for accounts created before 2010
        $conn->rollback();
        echo "Transaction ROLLED BACK for $customer_name.<br>";
    }

} else {
    echo "No account found for $customer_name.<br>";
}

// Close the connection
$conn->close();
?>
