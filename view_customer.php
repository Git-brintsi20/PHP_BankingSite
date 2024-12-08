<?php
$link = mysqli_connect('localhost', 'root', '', '23BCS220');

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM customer";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Customer Name</th><th>Street</th><th>City</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row['customer_name'] . "</td><td>" . $row['customer_street'] . "</td><td>" . $row['customer_city'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No customers found.";
}

mysqli_close($link);
?>
