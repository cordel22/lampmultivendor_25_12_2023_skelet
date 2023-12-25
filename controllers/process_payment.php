<?php
// process_payment.php

// Include necessary files
require_once '../config.php';
require_once '../includes/database.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $payerName = $_POST['payer_name'];
    $password = $_POST['password'];
    $totalAmount = floatval($_POST['total_amount']);

    // Validate the payer's name and password (perform additional validation if needed)

    // Check if the total amount matches the session
    if ($totalAmount !== $_SESSION['cart_total']) {
        // If the amount is modified, reject the payment and redirect to billing with an error message
        $error_message = "Invalid total amount. Please check your cart and try again.";
        header('Location: ' . BASE_URL . '/templates/billing/' . 'billing.php');
        exit();
    }

    // Rest of the payment processing logic goes here...

    
    // Insert a new order
    $userId = $_SESSION['user_id'];
    $orderDate = date('Y-m-d H:i:s');
    $insertOrderQuery = "INSERT INTO orders (user_id, order_date, total_amount) VALUES (:user_id, :order_date, :total_amount)";
    $stmt = $conn->prepare($insertOrderQuery);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':order_date', $orderDate);
    $stmt->bindParam(':total_amount', $totalAmount, PDO::PARAM_STR);
    $stmt->execute();

    // Retrieve the order_id of the newly inserted order
    $orderId = $conn->lastInsertId();

    // Iterate through the items in the cart and insert order_details
    foreach ($_SESSION['cart'] as $item) {
        $productId = $item['product_id'];
        $quantity = $item['quantity'];

        $insertOrderDetailsQuery = "INSERT INTO order_details (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
        $stmt = $conn->prepare($insertOrderDetailsQuery);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Clear the cart in the session
    unset($_SESSION['cart']);
    unset($_SESSION['cart_total']);

    

    // Redirect to a confirmation page
    header('Location: ' . BASE_URL . '/templates/checkout/' . 'checkout.php');
    exit();
} else {
    // If the form is not submitted, redirect to billing page
    header('Location: ' . BASE_URL . '/templates/billing/' . 'billing.php');
    exit();
}
?>