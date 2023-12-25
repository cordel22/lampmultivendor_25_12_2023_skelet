<?php
// templates/admin/index.php

// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in as an admin, if not, redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /templates/auth/login.php");
    exit();
}

// Fetch users from the database
$queryUsers = "SELECT * FROM users";
$stmtUsers = $conn->query($queryUsers);
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

// Fetch orders and their details from the database
$queryOrders = "SELECT * FROM orders";
$stmtOrders = $conn->query($queryOrders);
$orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add any additional styles or scripts here -->
</head>
<body>

<h1>Admin Dashboard</h1>

<!-- Users Section -->
<section>
    <h2>Users</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user['user_id']; ?></td>
                <td><?= $user['username']; ?></td>
                <td><?= $user['role']; ?></td>
                <td>
                    <a href="edit_user.php?user_id=<?= $user['user_id']; ?>">Edit</a>
                    <a href="delete_user.php?user_id=<?= $user['user_id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<!-- Orders Section -->
<section>
    <h2>Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?= $order['order_id']; ?></td>
                <td><?= $order['user_id']; ?></td>
                <td><?= $order['order_date']; ?></td>
                <td><?= $order['total_amount']; ?></td>
                <td>
                    <a href="edit_order.php?order_id=<?= $order['order_id']; ?>">Edit</a>
                    <a href="delete_order.php?order_id=<?= $order['order_id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<!-- Add any additional content or links here -->

</body>
</html>