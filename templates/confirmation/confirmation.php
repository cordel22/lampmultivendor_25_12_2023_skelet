<?php
// confirmation.php

// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/templates/auth/login.php");
    exit();
}

// Display confirmation message or any other relevant information
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <!-- Add any additional styles or scripts here -->
</head>
<body>

<h1>Order Confirmation</h1>

<p>Your order has been placed successfully. Thank you for shopping with us!</p>

<br />
        <div>
            <!-- Link to proceed to billing -->
            <button><a href="/">Show me the products again i wanna shop some more!!!</a></button>
        </div>

<!-- Add any additional content or links here -->



</body>
</html>