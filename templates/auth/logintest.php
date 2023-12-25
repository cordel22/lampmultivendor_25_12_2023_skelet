<?php
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';
// Start the session    here
session_start();
//  TODO reconsider to here

echo $_SESSION['user_role'];

// Check if the user is already logged in, redirect to the dashboard
if (isset($_SESSION['user_role'])) {
    header('Location: ' . BASE_URL . '/templates/' . $_SESSION['user_role'] . '/index.php');
    exit();
}


?>
<!DOCTYPE html>
<head>
</head>
<body>
    <h1>login test</h1>
</body>
</html>