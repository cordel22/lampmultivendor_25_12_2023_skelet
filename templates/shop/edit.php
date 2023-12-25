<?php
ob_start();
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

// Debugging output
echo "<br />";
echo "<h3>";
echo 'SESSION = ' . var_dump($_SESSION);
echo "</h3>";
echo "<br />";
// end Debugging output

// Debugging output
echo "<br />";
echo "<h3>";
echo 'productDetails = ' . var_dump($productDetails);
echo "</h3>";
echo "<br />";
// end Debugging output

// Check if the logged-in user is the vendor of the product
//  if ($_SESSION['user_id'] !== $productDetails['vendor_id'] || $_SESSION['user_role'] !== 'admin') {
    
    if (isset($_SESSION['user_id'], $_SESSION['user_role'], $productDetails['vendor_id']) &&
    !(($_SESSION['user_role'] == 'admin') || ($_SESSION['vendor_id'] == $productDetails['vendor_id']))) {
    
        echo "_SESSION['user_role'] == 'admin')" . ($_SESSION['user_role'] == 'admin') . '<br />'; 
        echo "(_SESSION['user_id'] == productDetails['vendor_id'])" . ($_SESSION['user_id'] == $productDetails['vendor_id']) . '<br />'; 
        echo 'Redirect to an unauthorized page or handle accordingly';
    // Redirect to an unauthorized page or handle accordingly
    header('Location: /kokotunauthorized.php');
    exit();
}


// Handle the form submission for editing the product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form inputs
    // ...

    // Update product details
    $newDetails = [
        'product_id' => $productDetails['product_id'],
        'product_name' => $_POST['product_name'],
        'description' => $_POST['description'],
        'price' => (float) $_POST['price'],
        'stock' => $_POST['stock'],
        'category_id' => NULL,
        'vendor_id' => $productDetails['vendor_id'],
    ];


    // Debugging output
echo "Debug: User ID - " . $_SESSION['user_id'] . "<br>";
echo "Debug: User Role - " . $_SESSION['user_role'] . "<br>";
echo "Debug: Product Vendor ID - " . $productDetails['vendor_id'] . "<br>";
echo "Debug: productDetails - " . var_dump($productDetails) . "<br>";
// end Debugging output

    // Debugging output
echo "Debug: User Role - " . $_SESSION['user_role'] . "<br>";
echo "Debug: Is Vendor? - " . ($_SESSION['user_role'] === 'vendor' ? 'Yes' : 'No') . "<br>";
echo "Debug: Is Admin? - " . ($_SESSION['user_role'] === 'admin' ? 'Yes' : 'No') . "<br>";
echo "Debug: newDetails - " . var_dump($newDetails) . "<br>";
// end Debugging output

    if (edit_product($product_id, $newDetails)) {
        // Product successfully updated, redirect to the shop view or handle accordingly
        //  header('Location: /index.php');
        header('Location: /');
        exit();
    } else {
        // Error updating product, handle accordingly
        $error = "Failed to update product.";
    }
}
?>

<!-- Your HTML form for editing the product -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <!-- Your form fields with pre-filled values from $productDetails -->
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" value="<?= $productDetails['product_name']; ?>" required>

        <label for="description">Description:</label>
        <textarea name="description"><?= $productDetails['description']; ?></textarea>

        <label for="price">Price:</label>
        <input type="text" name="price" value="<?= $productDetails['price']; ?>" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" value="<?= $productDetails['stock']; ?>" required>

        <!-- Add more form fields as needed based on your product structure -->


        <button type="submit">Save Changes</button>
    </form>
    <?php   ob_end_flush(); ?>
</body>
</html>

