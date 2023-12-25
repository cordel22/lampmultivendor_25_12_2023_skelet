<?php
/*  in templates
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';
*/
function registerBuyer($buyerUsername, $buyerPassword) {
global $conn; // Use the existing PDO connection

try {
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Perform buyer registration
        $buyerUsername = $_POST['buyer_username'];
        $buyerPassword = $_POST['buyer_password'];

        // Start a transaction to ensure data consistency
        $conn->beginTransaction();

        // Placeholder registration, you should insert into your database
        // and handle the registration logic
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:buyerUsername, :buyerPassword, 'buyer')");
        $stmt->bindParam(':buyerUsername', $buyerUsername);
        $stmt->bindParam(':buyerPassword', $buyerPassword);
        $stmt->execute();

        /*  only for vendors, this is buyer
        // Get the newly inserted user_id
        $newUserId = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO vendors (user_id, shop_name) VALUES (:newUserId, :vendorshopname)");
        $stmt->bindParam(':newUserId', $newUserId);
        $stmt->bindParam(':vendorshopname', $vendorUsername);
        $stmt->execute();
        */
        // Commit the transaction
        $conn->commit();


        // Registration success, set user role and redirect to the CARTcart
        /*  redirect to login like a
        $_SESSION['user_role'] = 'buyer';
        $_SESSION['user_name'] = $buyerUsername;
        header('Location: ' . BASE_URL . '/templates/cart/cart.php');
        */
        header('Location: ' . BASE_URL . '/templates/auth/login.php');
        
        exit();
    }
} catch (PDOException $e) {
    // Rollback the transaction in case of an error
    $conn->rollBack();

    // Handle database connection errors
    echo "Buyer registration failed: " . $e->getMessage();
}
}
?>