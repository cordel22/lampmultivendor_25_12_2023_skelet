<?php
// templates/admin/delete_order_detail.php

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

// Handle order detail deletion
delete_order_detail($order_detail_id);

// Redirect back to the admin index page or wherever you want
header("Location: /templates/admin/index.php");
exit();
?>