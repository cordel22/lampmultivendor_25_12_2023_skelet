<?php
// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';
require_once '../../controllers/vendorshop_controller.php';

//  u ll need just one a rekon
include '../../includes/header.php';


// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: /login.php');
    exit();
}

// Check if the request has the product_id parameter
if (!isset($_GET['product_id'])) {
    // Redirect to an error page or handle accordingly
    header('Location: /error.php');
    exit();
}

// Sanitize the product_id from the URL
$product_id = filter_var($_GET['product_id'], FILTER_SANITIZE_NUMBER_INT);

// Get product details for the given product_id
$productDetails = get_product_details($product_id);

// Check if the product exists
if (!$productDetails) {
    // Redirect to an error page or handle accordingly
    header('Location: /error.php');
    exit();
}

// Check if the logged-in user is the vendor of the product
//  if ($_SESSION['user_id'] !== $productDetails['vendor_id']) {
    if (isset($_SESSION['user_id'], $_SESSION['user_role'], $productDetails['vendor_id']) &&
    !(($_SESSION['user_role'] == 'admin') || ($_SESSION['vendor_id'] == $productDetails['vendor_id']))) {
    // Redirect to an unauthorized page or handle accordingly
    header('Location: /unauthorized.php');
    exit();
}

// Handle the form submission for deleting the product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (delete_product($product_id)) {
        // Product successfully deleted, redirect to the shop view or handle accordingly
        header('Location: /index.php');
        exit();
    } else {
        // Error deleting product, handle accordingly
        $error = "Failed to delete product.";
    }
}
?>

<!-- Your HTML form for confirming the deletion -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
</head>
<body>
    <h1>Delete Product</h1>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <!-- Display the confirmation message and options for deleting the product -->
    <p>Are you sure you want to delete the product: <?= $productDetails['product_name']; ?>?</p>

    <!-- Add a form for confirming the deletion -->
    <form method="post" action="">
        <button type="submit">Yes, Delete Product</button>
    </form>

    <!-- Add a cancel button or link if needed -->
</body>
</html>