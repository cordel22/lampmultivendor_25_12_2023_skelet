<?php
// Include configuration and common functions
//  you need this here, for some reason, header not enuff

require_once '../../config.php';
require_once '../../includes/database.php';

include '../../includes/header.php';

// Retrieve product vendor_id from GET parameter
//  tu sa zasiva!!!
$product_vendorId = isset($_GET['product_vendor_id']) ? $_GET['product_vendor_id'] : null;



// Include configuration and database connection
/*  should work from header..?

require_once '../../controllers/vendorshop_controller.php';
*/
/*
function includeFileWithFallback($filePaths) {
    foreach ($filePaths as $filePath) {
        if (file_exists($filePath)) {
            require_once $filePath;
            return true;
        }
    }
    return false;
}

*/

/*
// Define possible paths to the productdisplay_controller.php file
$filePaths_config = [
    'config.php',
    '../config.php',
    '../../config.php',
];

// Attempt to include the file
if (!includeFileWithFallback($filePaths_config)) {
    // Handle the case where the file couldn't be included
    die('Error: Unable to include config.php');
}


// Define possible paths to the productdisplay_controller.php file
$filePaths_includes_database = [
    'includes/database.php',
    '../includes/database.php',
    '../../includes/database.php',
];

// Attempt to include the file
if (!includeFileWithFallback($filePaths_includes_database)) {
    // Handle the case where the file couldn't be included
    die('Error: Unable to include database.php');
}

// Define possible paths to the productdisplay_controller.php file
$filePaths_controllers_vendorshop_controller = [
    'controllers/vendorshop_controller.php',
    '../controllers/vendorshop_controller.php',
    '../../controllers/vendorshop_controller.php.php',
];

// Attempt to include the file
if (!includeFileWithFallback($filePaths_controllers_vendorshop_controller)) {
    // Handle the case where the file couldn't be included
    die('Error: Unable to include vendorshop_controller.php');
}

// Define possible paths to the productdisplay_controller.php file
$filePaths_controllers_productdisplay_controller = [
    'controllers/productdisplay_controller.php',
    '../controllers/productdisplay_controller.php',
    '../../controllers/productdisplay_controller.php',
];

// Attempt to include the file
if (!includeFileWithFallback($filePaths_controllers_productdisplay_controller)) {
    // Handle the case where the file couldn't be included
    die('Error: Unable to include productdisplay_controller.php');
}

// Retrieve products using the vendorshop_controller function   and put it into includes/header.php
//  $products = get_products();

*/



/*
//  TODO delete from here
// Start the session    here
session_start();
//  TODO reconsider to here

// Check if the user is a vendor; if not, redirect to login
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'vendor') {
    //  TODO    maybe to the root index
    //  header('Location: ' . BASE_URL . 'templates/auth/login.php');
    header('Location: ' . BASE_URL . 'templates/buyer/index.php');
    exit();
}

*/

?>

<!--
TODO delete from here

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    Add any additional styles or scripts here
</head>
<body>
    
TODO delete to here
-->




<main class="container mt-4">
    <?php
// Check user role to display role-specific content
            if ($user_role === 'vendor' && $user_name == $shop_name) {
                // Vendor-specific content (form to add new product)
                if (isset($_POST['add_product'])) {
                    $productName = $_POST['product_name'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $stock = $_POST['stock'];
                
                    // Additional fields can be processed similarly
                
                    $newProductDetails = [
                        'product_name' => $productName,
                        'description' => $description,
                        'price' => $price,
                        'stock' => $stock,
                        // Add other fields here
                    ];
                
                    // Call the function to add the product
                    $result = add_product($newProductDetails);
                
                    // Handle the result (e.g., show a success message or error)
                    if ($result) {
                        $message = "Product added successfully!";
                    } else {
                        $message = "Failed to add the product. Please try again.";
                    }
                }
                
                echo '<h2>Add New Product</h2>';
                if (isset($message)): ?>
                    <div class="alert alert-success" role="alert">
                        <p><?php echo $message; ?></p>
                    </div>
                <?php endif;

                ?>
                <form action="../../templates/vendor/index.php" method="post">  <!--    maybe '' would be enuff -->
                    <div class="mb-3">    
                        <label for="product_name">Product Name:</label>
                        <input type="text" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <textarea name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price">Price:</label>
                        <input type="number" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock">Stock:</label>
                        <input type="number" name="stock" required>
                    </div>

                    <!-- Add any additional fields as needed -->

                    <input type="submit" name="add_product" value="Add Product">
                </form>

    <?php
          /*   TODO: are next 2 lines necessary???  */ 
        echo '<h2>Display, modify delete Products</h2>';
        include '../../templates/shop/index.php';
                      
                
            }
            
            //  TODO: is the following code useful..?
            if ($user_role === 'admin') {
                // Vendor and Admin content (modify or delete products and comments)
                echo '<h2>Manage Products and Comments</h2>';
                include '../../templates/shop/index.php';
                // Include code for vendors and admins to modify or delete products and comments
            }

            if ($user_role === 'buyer' || $user_role === 'vendor' && $user_name !== $shop_name) {
                // Vendor and Admin content (modify or delete products and comments)
                echo '<h2>Shop</h2>';
                include '../../templates/shop/index.php';
                // Include code for vendors and admins to modify or delete products and comments
                echo '<h2>Comment</h2>';
            }

            if ($user_role === 'random_visitor') {
                // Vendor and Admin content (modify or delete products and comments)
                echo '<h2>Shop</h2>';
                include '../../templates/shop/index.php';
                // Include code for vendors and admins to modify or delete products and comments
                echo '<h2>Read comments</h2>';

            }

            ?>
    <!-- <h1>Welcome, Vendor!</h1> -->

    <!-- Vendor-specific content goes here -->

    <div>
        <!-- Placeholder content for vendor dashboard -->
        <!-- <p>This is your vendor dashboard. Add, edit, or remove products here.</p>
    </div>
</main> -->

<?php include '../../includes/footer.php'; ?>
