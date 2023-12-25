<?php
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';
require_once '../../controllers/vendor_registration.php';


include '../../includes/header.php';

// Check if the user is already logged in, redirect to the dashboard
if (($_SESSION['user_role'] != 'random_visitor')) {
    header('Location: ' . BASE_URL . 'templates/' . $_SESSION['user_role'] . '/index.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform registration (you'll need to implement this)
    $vendorUsername = $_POST['vendor_username'];
    $vendorPassword = $_POST['vendor_password'];

    // Placeholder registration, you should insert into your database
    // and handle the registration logic
    // For now, we'll assume the registration is successful and redirect to login
    /*
    $_SESSION['user_role'] = 'vendor';
    header('Location: ' . BASE_URL . 'templates/vendor/index.php');
    exit();
    */
    if (registerVendor($vendorUsername, $vendorPassword)) {
        // Registration success, set user role and redirect to the vendor dashboard
        /*  can if be empty?
        $_SESSION['user_role'] = 'vendor';
        $_SESSION['user_name'] = $vendorUsername;
        header('Location: ' . BASE_URL . 'templates/vendor/index.php');
        exit();
        */
    } else {
        // Registration failed, show an error message
        $error_message = 'Vendor registration failed';
    }
}
?>

<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
     Add any additional styles or scripts here 
</head>
<body>
-->
<?php
/*  TODO vyssie, toto do <>
include '../../includes/header.php';
*/
?>

<main class="container mt-4">
    <h1>Register as a Vendor</h1>
    <h1>changes the role but doesnt log you in!!!</h1>
    <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php } ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="vendor_username">Vendor Name same as Shop Name:</label>
            <input type="text" name="vendor_username" required>
        </div>
        <div class="mb-3">
            <label for="vendor_password">Vendor Password:</label>
            <input type="password" name="vendor_password" required>
        </div>



        <!-- Additional registration fields can be added as needed -->

        <button type="submit">Register</button>
    </form>
</main>

<?php include '../../includes/footer.php'; ?>

</body>
</html>