<?php
// billing.php

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: /templates/auth/login.php");
    exit();
}

// Get the total amount from the session
$totalAmount = isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 0.00;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing</title>
    <!-- Add any additional styles or scripts here -->
</head>
<body>

<h1>Billing Information</h1>

<!-- Display total amount -->
<p>Total Amount: $<?= number_format($totalAmount, 2); ?></p>

<!-- Billing form -->
<form action="../../controllers/process_payment.php" method="post">
    <label for="payer_name">Name:</label>
    <input type="text" name="payer_name" value="<?= $_SESSION['user_name']; ?>" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <input type="hidden" name="total_amount" value="<?= $totalAmount; ?>">
    <input type="submit" value="Proceed to Payment">
</form>

<!-- Add any additional content or links here -->

</body>
</html>