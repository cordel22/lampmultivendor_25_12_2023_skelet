<?php
/*  THIS FIE IS  NOT BEING USED ANYWHERE !!!   DELETE it TO <>  */
/*
// Include configuration and common functions
require_once '../../config.php';
require_once '../../includes/database.php';
require_once '../../controllers/vendorshop_controller.php';
require_once '../../controllers/productdisplay_controller.php';



// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    

//  TODO are you using productId at all?
// Retrieve product ID from GET parameter
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;


// Retrieve user ID and role from the session
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'random_visitor';


// Retrieve product details using the controller function
// You may need to pass the product_id to this file through GET or POST parameters
$productDetails = get_product_details($productId); // Replace $productId with the actual product ID

// Retrieve product IDs based on user role
$productIds = get_product_ids_by_user_role($userId, $userRole);




// Check if the product exists
if ($productDetails && in_array($productId, $productIds)) {
    

    // Display product details
    echo "<h1>{$productDetails['product_name']}</h1>";
    echo "<p>Description: {$productDetails['description']}</p>";
    echo "<p>Price: {$productDetails['price']}</p>";
    echo "<p>Stock: {$productDetails['stock']}</p>";

    // Check user role to display role-specific options
    $userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'random_visitor';

    if ($userRole === 'buyer' || $userRole === 'random_visitor') {
        // Display add to cart button or link
        echo "<button onclick=\"addToCart({$productDetails['product_id']})\">Add to Cart</button>";
    }

    if ($userRole === 'vendor' && $_SESSION['username'] !== $productDetails['shop_name']) {
        // Display link to vendor's index.php for modification
        echo "<a href='" . BASE_URL . "templates/vendor/index.php'>Go to Vendor Dashboard</a>";
    }

    if ($userRole === 'admin' || ($userRole === 'vendor' && $_SESSION['username'] === $productDetails['shop_name'])) {
        // Display options for admin or product-owning vendor
        echo "<p>Options for admin or product-owning vendor</p>";
        echo "<button onclick=\"modifyProduct({$productDetails['product_id']})\">Modify Product</button>";
        echo "<button onclick=\"removeProduct({$productDetails['product_id']})\">Remove Product</button>";
    }
} else {
    // Product not found, display an error message
    echo "<p>Product not found or you do not have access to view this product.</p>";
}
?>

<!-- Include JavaScript functions for AJAX requests -->
<script src="../assets/js/product_actions.js"></script>

*/