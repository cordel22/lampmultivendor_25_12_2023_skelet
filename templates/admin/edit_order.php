<?php
// templates/admin/edit_order.php

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

// Check if the order_id is provided in the URL
if (!isset($_GET['order_id'])) {
    header("Location: /templates/admin/index.php");
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details from the database
$order = get_order_by_id($order_id);
// Fetch order details from the database
$orderDetails = get_order_details_by_id($order_id);


// Handle form submission to update order details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update order logic
    $updatedData = [
        // Add fields to update based on your form inputs
    ];

    update_order($order_id, $updatedData);

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
    <title>Edit Order</title>
    <!-- Add any additional styles or scripts here -->
</head>
<body>

<h1>Edit Order</h1>

<!-- Order Details Form -->
<form action="" method="post">
    <!-- Display order details and allow editing if needed -->

    <input type="submit" value="Update Order">
</form>

<!-- Order Details Table -->
<h2>Order Details</h2>
<table>
    <tr>
        <th>Product ID</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($orderDetails as $detail) : ?>
        <tr>
            <td><?= $detail['product_id']; ?></td>
            <td><?= $detail['quantity']; ?></td>
            <td>
                <a href="edit_order_detail.php?order_detail_id=<?= $detail['order_detail_id']; ?>">Edit</a>
                <a href="delete_order_detail.php?order_detail_id=<?= $detail['order_detail_id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Add any additional content or links here -->

</body>
</html>