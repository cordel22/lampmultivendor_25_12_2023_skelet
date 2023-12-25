<?php
error_reporting(E_ALL);
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';
/*
// Start the session    here
session_start();
//  TODO reconsider to here
*/

/*  moved after header!!!
// Check if the user is already logged in, redirect to the dashboard
//  if (isset($_SESSION['user_role'])) {
if (($_SESSION['user_role'] != 'random_visitor')) {
    //  header('Location: ' . BASE_URL . '/templates/' . $_SESSION['user_role'] . '/index.php');
    header('Location: ' . BASE_URL . '/index.php');
    exit();
    
}

//  testing
echo "the user role in templates/auth/login.php now is : " . $_SESSION['user_role'];
//  end tesing
*/
?>


<?php include '../../includes/header.php'; ?>


<?php
//  check the session[user_role] here

//  moved from before the header

/**/

// Check if the user is already logged in, redirect to the dashboard
//  if (isset($_SESSION['user_role'])) {
    if (($_SESSION['user_role'] != 'random_visitor')) {
        //  header('Location: ' . BASE_URL . '/templates/' . $_SESSION['user_role'] . '/index.php');
        header('Location: ' . BASE_URL . '/index.php');
        exit();
    }
    
    //  testing
    echo "the user role in templates/auth/login.php now is : " . $_SESSION['user_role'];
    //  end tesing

?>

<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/register_vendor.php">Register Vendor</a>
    </li>
    <!--
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/register_admin.php">Register Admin</a>
    </li>
-->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/register_buyer.php">Register Buyer</a>
    </li>
</ul>

<main class="container mt-4">
    <h1>Login</h1>

    <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger" role="alert">
            <p style="color: red;"><?php echo $error_message; ?></p>
        </div>
    <?php } ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // If the request is POST, include and call the login process file
        require_once '../../controllers/login_process.php';
        loginProcess();
    }
    ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</main>

<?php include '../../includes/footer.php'; ?>

</body>
</html>