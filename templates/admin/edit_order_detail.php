<?php
// templates/admin/edit_order_detail.php

// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';
require_once '../../controllers/admin_controller.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in as an admin, if not, redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /templates/auth/login.php");
    exit();
}

// Check if the order_detail_id is provided in the URL
if (!isset($_GET['order_detail_id'])) {
    header("Location: /templates/admin/index.php");
    exit();
}

$order_detail_id = $_GET['order_detail_id'];

// Fetch order detail from the database
$orderDetail = get_order_detail_by_id($order_detail_id);

// Handle form submission to update order detail
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update order detail logic
    $updatedData = [
        // Add fields to update based on your form inputs
        'product_id' => $_POST['product_id'], // Update based on your form input name
        'quantity' => $_POST['quantity'],     // Update based on your form input name
    ];

    update_order_detail($order_detail_id, $updatedData);

    // Redirect back to the admin index page or wherever you want
    header("Location: /templates/admin/index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order Detail</title>
    <!-- Add any additional styles or scripts here -->
</head>
<body>

<h1>Edit Order Detail</h1>

<!-- Order Details Form -->
<form action="" method="post">
    <label for="product_id">Product ID:</label>
    <input type="text" name="product_id" value="<?= $orderDetail['product_id']; ?>" required>

    <label for="quantity">Quantity:</label>
    <input type="text" name="quantity" value="<?= $orderDetail['quantity']; ?>" required>

    <input type="submit" value="Update Order Detail">
</form>

<!-- Add any additional content or links here -->

</body>
</html>

