<?php
// templates/admin/delete_user.php

// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';
require_once '../../controllers/admin_controller.php'; // Import the admin controller

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in as an admin, if not, redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /templates/auth/login.php");
    exit();
}

// Check if the user_id is provided in the URL
if (!isset($_GET['user_id'])) {
    header("Location: /templates/admin/index.php");
    exit();
}

$user_id = $_GET['user_id'];

// Handle user deletion (assuming you have a delete_user function)
delete_user($user_id);

// Redirect back to the admin index page
header("Location: /templates/admin/index.php");
exit();
?>