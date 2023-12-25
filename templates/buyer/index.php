<?php
// Include configuration and database connection
require_once '../../config.php';
require_once '../../includes/database.php';

//  TODO delete from here
// Start the session    here
session_start();
//  TODO reconsider to here

// Fetch and display products from the database
// You'll need to implement your own logic to fetch and display products

?>



<!--
TODO delete from here

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    
</head>
<body>

TODO delete to here
-->

<?php include '../../includes/header.php'; ?>

<main>
    <h1>Welcome, Buyer!</h1>

    <!-- Display products here -->
    <!-- You'll need to implement your own logic to fetch and display products -->

    <div class="product-list">
        <!-- Sample product card -->
        <div class="product-card">
            <h2>Product Name</h2>
            <p>Description of the product.</p>
            <p>Price: $19.99</p>
            <button>Add to Cart</button>
        </div>
        <!-- Repeat similar structure for other products -->
    </div>
</main>

<?php include '../../includes/footer.php'; ?>

</body>
</html>