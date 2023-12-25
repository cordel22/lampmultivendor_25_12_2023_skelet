<?php
// checkout.php

//  NOT USED AT da MOMENT!!!

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

// Get user and order details from the session
$userId = $_SESSION['user_id'];
$totalAmount = $_SESSION['cart_total'];
$cart = $_SESSION['cart'];

// Insert order details into the database
// Add your database insertion logic here...

// Clear the cart and update the database with the order information
$_SESSION['cart'] = [];
$_SESSION['cart_total'] = 0.00;

// Redirect to the confirmation page
header("Location: " . BASE_URL . "/templates/confirmation/confirmation.php");
exit();
?>