<?php

// controllers/cart_controller.php

// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to initialize or retrieve the shopping cart data from the session
function get_cart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

// Function to add a product to the cart
function add_to_cart($productId) {

    // Log the product ID for debugging
    error_log("Adding product to cart. Product ID: $productId");
    echo "Adding product to cart. Product ID: $productId";
    // Fetch the product details from the database (replace this with your actual database query)
    $product = get_product_by_id($productId);

    if ($product) {
        // Add the product to the cart or update its quantity
        $cart = get_cart();

        if (array_key_exists($productId, $cart)) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => 1,
            ];
        }

        // Update the total amount in the session
        $_SESSION['cart_total'] = calculate_total_amount($cart);


        // Update the cart in the session
        $_SESSION['cart'] = $cart;
    }
}

// Function to calculate the total amount in the cart
function calculate_total_amount($cart) {
    $totalAmount = 0.00;

    foreach ($cart as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }

    return $totalAmount;
}

// Function to remove a product from the cart
function remove_from_cart($productId) {
    // Remove the product from the cart
    $cart = get_cart();
    if (array_key_exists($productId, $cart)) {
        unset($cart[$productId]);

        // Update the cart in the session
        $_SESSION['cart'] = $cart;
    }
}

// Function to get product details by ID (replace this with your actual database query)
function get_product_by_id($productId) {
    global $conn;
    // Replace this with your actual database query to fetch product details
    $query = "SELECT * FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the product details
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    return $product;
}

?>