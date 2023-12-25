<?php
// cart.php

// Include necessary files
require_once '../../config.php';
require_once '../../includes/database.php';
require_once '../../controllers/cart_controller.php';

// Initialize or retrieve the shopping cart data
$cart = get_cart();

// Check if a product is being added to the cart
if (isset($_GET['action']) && $_GET['action'] === 'add_to_cart' && isset($_GET['selected_product_id'])) {
    $productId = $_GET['selected_product_id'];
    add_to_cart($productId);
    header("Location: /templates/cart/cart.php"); // Redirect after updating cart
    exit();
}

// Check if a product is being removed from the cart
if (isset($_GET['action']) && $_GET['action'] === 'remove_from_cart' && isset($_GET['remove_product_id'])) {
    $productId = $_GET['remove_product_id'];
    remove_from_cart($productId);
    header("Location: /templates/cart/cart.php"); // Redirect after updating cart
    exit();
}

// Display the shopping cart content
?>

<!-- Cart Content -->
<h1>Shopping Cart</h1>
<?php if (empty($cart)) : ?>
    <p>Your cart is empty.</p>
<?php else : ?>
    <ul>
        <?php foreach ($cart as $item) : ?>
            <li>
                <div>
                    Product: <?= $item['product_name']; ?>
                    Price: $<?= $item['price']; ?>
                    Quantity: <?= $item['quantity']; ?>
                    <form action="cart.php" method="get">
                        <input type="hidden" name="action" value="remove_from_cart">
                        <input type="hidden" name="remove_product_id" value="<?= $item['product_id']; ?>">
                        <button type="submit">Remove from Cart</button>
                    </form>
                    <button><a href="cart.php?action=add_to_cart&selected_product_id=<?= $item['product_id']; ?>">Add On Item to Cart</a></button>
                    <button><a href="cart.php?action=remove_from_cart&remove_product_id=<?= $item['product_id']; ?>">Remove from Cart</a></button>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<br />
        <div>
            <!-- Link to proceed to billing -->
            <button><a href="/templates/billing/billing.php">Proceed to Billing</a></button>
        </div>
        <div>
            <!-- Back to Shop Link -->
            <p><a href="/">Back to Shop</a></p>
        </div>

<!-- Add Item to Cart Form  NOT USED, PROBABLY TODO do <>
<form action="cart.php" method="get">
    <input type="hidden" name="action" value="add_to_cart">
    <label for="selected_product_id">Product ID:</label>
    <input type="text" id="selected_product_id" name="selected_product_id" required>
    <button type="submit">Add to Cart</button>
</form>
-->
<!-- Add to Cart Button
<form action="cart.php" method="GET">
    <input type="hidden" name="action" value="add_to_cart">
    <label for="selected_product_id">Product ID:</label>
    <input type="text" name="selected_product_id" required>
    <button type="submit">Add to Cart</button>
</form>
 -->
<!-- Remove from Cart Button
<form action="cart.php" method="GET">
    <input type="hidden" name="action" value="remove_from_cart">
    <label for="remove_product_id">Product ID to Remove:</label>
    <input type="text" name="remove_product_id" required>
    <button type="submit">Remove from Cart</button>
</form> -->