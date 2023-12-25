<?php
/*  in templates
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';
*/
function registerVendor($vendorUsername, $vendorPassword) {
global $conn; // Use the existing PDO connection

try {
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Perform vendor registration
        $vendorUsername = $_POST['vendor_username'];
        $vendorPassword = $_POST['vendor_password'];

        // Start a transaction to ensure data consistency
        $conn->beginTransaction();

        // Placeholder registration, you should insert into your database
        // and handle the registration logic
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:vendorUsername, :vendorPassword, 'vendor')");
        $stmt->bindParam(':vendorUsername', $vendorUsername);
        $stmt->bindParam(':vendorPassword', $vendorPassword);
        $stmt->execute();

        // Get the newly inserted user_id
        $newUserId = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO vendors (user_id, shop_name) VALUES (:newUserId, :vendorshopname)");
        $stmt->bindParam(':newUserId', $newUserId);
        $stmt->bindParam(':vendorshopname', $vendorUsername);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();


        // Registration success, set user role and redirect to the vendor dashboard
        /*  skus ho poslat na login
        $_SESSION['user_role'] = 'vendor';
        $_SESSION['user_name'] = $vendorUsername;
        header('Location: ' . BASE_URL . '/templates/vendor/index.php');
        */
        header('Location: ' . BASE_URL . '/templates/auth/login.php');
        exit();
    }
} catch (PDOException $e) {
    // Rollback the transaction in case of an error
    $conn->rollBack();

    // Handle database connection errors
    echo "Vendor registration failed: " . $e->getMessage();
}
}
?>