<?php
// templates/admin/edit_user.php

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

// Check if the user_id is provided in the URL
if (!isset($_GET['user_id'])) {
    header("Location: /templates/admin/index.php");
    exit();
}

$user_id = $_GET['user_id'];

// Fetch user details from the database

$user = get_user_by_id($user_id);

// Handle form submission to update user details (assuming you have an update_user function)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and update user details
    // Example: update_user($user_id, $_POST['username'], $_POST['role']);
    update_user($user_id, $_POST['username'], $_POST['role']);
    // Redirect back to the admin index page
    header("Location: /templates/admin/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Add any additional styles or scripts here -->
</head>
<body>

<h1>Edit User</h1>

<!-- User Details Form -->
<form action="" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" value="<?= $user['username']; ?>" required>

    <label for="role">Role:</label>
    <select name="role">
        <option value="buyer" <?= ($user['role'] === 'buyer') ? 'selected' : ''; ?>>Buyer</option>
        <option value="vendor" <?= ($user['role'] === 'vendor') ? 'selected' : ''; ?>>Vendor</option>
        <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
    </select>

    <input type="submit" value="Update User">
</form>

<!-- Add any additional content or links here -->

</body>
</html>