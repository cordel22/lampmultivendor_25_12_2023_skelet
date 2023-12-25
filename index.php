<?php

// Include configuration and common functions
require_once 'config.php';
require_once 'includes/database.php';
/*
// Start the session
session_start();

//  echo "landing multivendor page mah niggaz";

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];
} else {
    // For non-logged-in users, create a temporary session ID for cart functionality
    if (!isset($_SESSION['temp_user_id'])) {
        $_SESSION['temp_user_id'] = uniqid('temp_user_');
    }

    $user_id = $_SESSION['temp_user_id'];
    //  $user_role = 'buyer'; // Default role for non-logged-in users   Asi ne!!!
    $user_role = 'random_visitor';
}

*/
?>
<?php include 'includes/header.php'; ?>

<?php
//  testing
//  echo "the user role in /index.php now is : " . $_SESSION['user_role'];
//  end tesing
?>


<?php include 'templates/shop/index.php'; ?>


<?php include 'includes/footer.php'; ?>

</body>
</html>