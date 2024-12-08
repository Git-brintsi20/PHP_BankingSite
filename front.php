<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Account Balance</title>
</head>
<body>
    <form method="POST" action="transaction.php">
        <label for="customer_name">Enter Customer Name: </label>
        <input type="text" id="customer_name" name="customer_name" required>
        <button type="submit">Check Balance</button>
    </form>
</body>
</html>
