<?php
/*
// Include configuration and common functions
require_once 'config.php';
require_once 'includes/database.php';

require_once 'controllers/vendorshop_controller.php';


require_once 'controllers/productdisplay_controller.php';
*/
// Function to attempt including a file with different relative paths

//  require_once 'controllers/header_controller.php';
/*  moved to controllers but more needed here, DONT DO THAT!!!  */
function includeFileWithFallback($filePaths) {
    foreach ($filePaths as $filePath) {
        if (file_exists($filePath)) {
            require_once $filePath;
            return true;
        }
    }
    return false;
}





// Define possible paths to the config.php file
$filePaths_config = [
    'config.php',
    '../config.php',
    '../../config.php',
];

// Attempt to include the config file
if (!includeFileWithFallback($filePaths_config)) {
    // Handle the case where the file couldn't be included
    die('Error: Unable to include config.php');
}


// Define possible paths to the database.php file
$filePaths_includes_database = [
    'includes/database.php',
    '../includes/database.php',
    '../../includes/database.php',
];

// Attempt to include the database file
if (!includeFileWithFallback($filePaths_includes_database)) {
    // Handle the case where the file couldn't be included
    die('Error: Unable to include database.php');
}

// Define possible paths to the vendorshop_controller.php file
$filePaths_controllers_vendorshop_controller = [
    'controllers/vendorshop_controller.php',
    '../controllers/vendorshop_controller.php',
    '../../controllers/vendorshop_controller.php',
];

// Attempt to include the vendorshop_controller file
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

// Attempt to include the productdisplay_controller file
if (!includeFileWithFallback($filePaths_controllers_productdisplay_controller)) {
    // Handle the case where the file couldn't be included
    die('Error: Unable to include productdisplay_controller.php');
}


// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in the $_SESSION, if he is not, assign dummy values so he can use the ccart
if (!isset($_SESSION['user_role'])) {
    $_SESSION['user_role'] = 'random_visitor';
}
$user_role = $_SESSION['user_role'];

if (!isset($_SESSION['user_name'])) {
    $_SESSION['user_name'] = 'feri mrqicka';
}
$user_name = $_SESSION['user_name'];

if (!isset($_SESSION['shop_name'])) {
    $_SESSION['shop_name'] = 'no_shop';
}
$shop_name = $_SESSION['shop_name'];

if (!isset($_SESSION['vendor_id'])) {
    $_SESSION['vendor_id'] = 00;
}
$vendorId = $_SESSION['vendor_id'];


// Retrieve products using the vendorshop_controller function
if (!isset($products)) {
    $products = get_products();
}
//  TODO  why exactly do you need this one? you should have it in products product[vendor_id] above..?
//  var_damp the $products to see if it is there or elsewhere..
//  careful, this is probably the owner of the productS, not the creator of the product
//  that means if a vendor is logged in, he can see his and other vendors' products so this will distinguishthem
$product_vendorId = null;
//  teoria: ked som na index.php a vidim setky produkty, product_vendotId je null
//  ked kliknem na link
//  <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; na Visit Vendor's Shop
//  vznikne mi product_vendorId asi v template/vendor a podla toho rozoznavam v koho obchode som
//  pri random visitorovi je to asi jedno, ale ked som tam ako vendor, hlavne, potrebujem vediet, ci je to
//  product_vendorId - ov produkt teda ako majitela toho obchodu co som klikol, alebo moj produkt, taky co mozem editovat???


//  testing
echo 'inak login je pre admina don dopici123 <br />
        a pre vendora je testvendor 1234';
echo '<br />';
echo 'dalsi login je pre vendora tiez quark 1111';
echo '<br />';
//  end tesing

echo 'inak login je pre buyera je jimmy blowjobs 666';
echo '<br />';
//  end tesing

//  testing
echo "the user role in includes/header.php now is : " . $_SESSION['user_role'] . '<br />';
//  end tesing

//  testing
echo "the $ session user_name in includes/header.php now is : " . $_SESSION['user_name'] . '<br />';
//  end tesing

//  testing
echo "the user_name variable in includes/header.php now is : " . $user_name . '<br />';
//  end tesing


//  testing
echo "the $ session shop_name in includes/header.php now is : " . $_SESSION['shop_name'] . '<br />';
//  end tesing

//  testing
echo "the user_name variable in includes/header.php now is : " . $shop_name . '<br />';
//  end tesing

//  testing
echo "the $ session vendorId  in includes/header.php now is : " . $_SESSION['vendor_id'] . '<br />';
//  end tesing


//  testing
echo "the vendorId  in includes/header.php now is : " . $vendorId . '<br />';
//  end tesing


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Add any additional styles or scripts here -->
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">multivendor</a>

        <!-- Common navigation items for all users-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php">Home</a>
            </li>
        <!--    </ul> like put it all into one navbar the entire menu  -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/shop/about.php">About</a>
            </li>

        <?php if ($user_role === 'buyer') { ?>
            <!-- Buyer-specific navigation items -->
            <!-- <ul class="navbar-nav ml-auto"> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/cart/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/logout.php">Logout</a>
                </li>
            </ul>
        <?php } elseif ($user_role === 'vendor') { ?>
            <!-- Vendor-specific navigation items -->
            <!-- <ul class="navbar-nav ml-auto"> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/vendor/index.php">Vendor Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/cart/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/logout.php">Logout</a>
                </li>
            </ul>
        <?php } elseif ($user_role === 'admin') { ?>
            <!-- Admin-specific navigation items -->
            <!-- <ul class="navbar-nav ml-auto"> -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/admin/index.php">Admin Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/logout.php">Logout</a>
                </li>
            </ul>
        <?php } else  {?>
            <!-- Common navigation items for non-logged-in users -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/cart/cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/register_vendor.php">Register Vendor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/templates/auth/login.php">Login</a>
                </li>
            </ul>
        <?php } ?>
    </div>
</nav>

<!-- Content wrapper -->
<div class="container mt-3">