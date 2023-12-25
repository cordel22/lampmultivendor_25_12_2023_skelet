<?php
// templates/admin/delete_order.php

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

// Check if the order_id is provided in the URL
if (!isset($_GET['order_id'])) {
    header("Location: /templates/admin/index.php");
    exit();
}

$order_id = $_GET['order_id'];

// Handle order deletion (assuming you have a delete_order function)
// Example: delete_order($order_id);

// Redirect back to the admin index page
header("Location: /templates/admin/index.php");
exit();
?>