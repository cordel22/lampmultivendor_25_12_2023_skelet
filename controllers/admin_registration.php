<?php
/*  in templates
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';
*/
function registerAdmin($adminUsername, $adminPassword) {
    global $conn; // Use the existing PDO connection

    try {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Perform admin registration
            $adminUsername = $_POST['admin_username'];
            $adminPassword = $_POST['admin_password'];

            // Placeholder registration, you should insert into your database
            // and handle the registration logic
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:adminUsername, :adminPassword, 'admin')");
            $stmt->bindParam(':adminUsername', $adminUsername);
            $stmt->bindParam(':adminPassword', $adminPassword);
            $stmt->execute();

            /*
            // Retrieve the user_id of the newly registered admin
            $adminUserId = $conn->lastInsertId();

            // Insert into the admins table
            $stmt = $conn->prepare("INSERT INTO admins (user_id) VALUES (:adminUserId)");
            $stmt->bindParam(':adminUserId', $adminUserId);
            $stmt->execute();
            */

            // Registration success, set user role and redirect to the admin dashboard
            /*
            $_SESSION['user_role'] = 'admin';
            header('Location: ' . BASE_URL . 'templates/admin/index.php');
            */
            header('Location: ' . BASE_URL . '/templates/auth/login.php');
        
            exit();
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Admin registration failed: " . $e->getMessage();
    }
}
?>