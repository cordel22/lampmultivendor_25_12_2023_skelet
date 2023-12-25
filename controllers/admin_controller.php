<?php
// controllers/admin_controller.php

// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to get all users
function get_all_users() {
    global $conn;
    $query = "SELECT * FROM users";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get all orders
function get_all_orders() {
    global $conn;
    $query = "SELECT * FROM orders";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Add any other necessary functions for managing users and orders here


// Function to get user details by ID
function get_user_by_id($user_id) {
    global $conn;
    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Function to update user details
function update_user($user_id, $username, $role) {
    global $conn;
    $query = "UPDATE users SET username = :username, role = :role WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->execute();
}


// Function to delete user by ID
function delete_user($user_id) {
    global $conn;

        // Delete corresponding vendors first
        $queryDeleteVendors = "DELETE FROM vendors WHERE user_id = :user_id";
        $stmtDeleteVendors = $conn->prepare($queryDeleteVendors);
        $stmtDeleteVendors->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtDeleteVendors->execute();
    
        
    $query = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
}

// Function to get order details by ID
function get_order_by_id($order_id) {
    global $conn;
    $query = "SELECT * FROM orders WHERE order_id = :order_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get order details by ID
function get_order_details_by_id($order_id) {
    global $conn;
    $query = "SELECT * FROM order_details WHERE order_id = :order_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to update order details
function update_order($order_id, $updatedData) {
    global $conn;

    // Construct the update query based on the keys in $updatedData
    $updateFields = [];
    foreach ($updatedData as $key => $value) {
        $updateFields[] = "$key = :$key";
    }

    $updateFieldsString = implode(', ', $updateFields);

    $query = "UPDATE orders SET $updateFieldsString WHERE order_id = :order_id";
    $stmt = $conn->prepare($query);

    // Bind parameters
    foreach ($updatedData as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
}

// Function to get order detail by ID
function get_order_detail_by_id($order_detail_id) {
    global $conn;
    $query = "SELECT * FROM order_details WHERE order_detail_id = :order_detail_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':order_detail_id', $order_detail_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to update order detail
function update_order_detail($order_detail_id, $updatedData) {
    global $conn;

    // Construct the update query based on the keys in $updatedData
    $updateFields = [];
    foreach ($updatedData as $key => $value) {
        $updateFields[] = "$key = :$key";
    }

    $updateFieldsString = implode(', ', $updateFields);

    $query = "UPDATE order_details SET $updateFieldsString WHERE order_detail_id = :order_detail_id";
    $stmt = $conn->prepare($query);

    // Bind parameters
    foreach ($updatedData as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    $stmt->bindParam(':order_detail_id', $order_detail_id, PDO::PARAM_INT);
    $stmt->execute();
}

// Function to delete order detail by ID
function delete_order_detail($order_detail_id) {
    global $conn;
    $query = "DELETE FROM order_details WHERE order_detail_id = :order_detail_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':order_detail_id', $order_detail_id, PDO::PARAM_INT);
    $stmt->execute();
}




?>



?>

?>