<?php
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';
//  require_once '../../includes/admin_registration.php'; // Include the admin registration logic
require_once '../../controllers/admin_registration.php';

?>

<?php include '../../includes/header.php'; ?>





<?php

// Start the session    in HEADER!
//  session_start();

// Check if the user is already logged in, redirect to the dashboard
if (($_SESSION['user_role'] != 'random_visitor')) {
    header('Location: ' . BASE_URL . 'templates/' . $_SESSION['user_role'] . '/index.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform admin registration (you'll need to implement this)
    $adminUsername = $_POST['admin_username'];
    $adminPassword = $_POST['admin_password'];

    // Placeholder registration, you should insert into your database
    // and handle the registration logic
    // For now, we'll assume the registration is successful and redirect to login
    /*
    $_SESSION['user_role'] = 'admin';
    header('Location: ' . BASE_URL . 'templates/admin/index.php');
    exit();
    */
    //  UPDATED
    if (registerAdmin($adminUsername, $adminPassword)) {
        // Registration success, set user role and redirect to the admin dashboard
        $_SESSION['user_role'] = 'admin';
        header('Location: ' . BASE_URL . 'templates/admin/index.php');
        exit();
    } else {
        // Registration failed, show an error message
        $error_message = 'Admin registration failed';
    }

}
?>
<!--    TODO do <>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    
</head>
<body>
TODO    do<>    -->
<?php 
/*  TODO do <>
include '../../includes/header.php';
*/
 ?>



<main class="container mt-4">
    <h1>Register as an Admin</h1>
    <h1>changes the role but doesnt log you in!!!</h1>
    <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php } ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="admin_username">Admin Username:</label>
            <input type="text" name="admin_username" required>
        </div>
        <div class="mb-3">
            <label for="admin_password">Admin Password:</label>
            <input type="password" name="admin_password" required>
        </div>

        <!-- Additional registration fields can be added as needed -->

        <button type="submit">Register</button>
    </form>
</main>

<?php include '../../includes/footer.php'; ?>

</body>
</html>