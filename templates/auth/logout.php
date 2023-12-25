<?php

// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';

// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session and redirect to the home page
session_destroy();
header('Location: ' . BASE_URL . '/index.php');
exit();
?>