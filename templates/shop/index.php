<?php

// Include necessary files
//  require_once 'config.php';
//  require_once 'includes/database.php';
//  require_once 'controllers/vendorshop_controller.php';

//  do <>
//  testing
//  echo "the user role now is : " . $_SESSION['user_role'];
//  end tesing

//  do <>
//  $user_role = $_SESSION['user_role'];

?>


<?php

//  TODO $product_vendorId is being definitely set up in header. Do u need here as well o are you importing it with the header???
// Check if product_vendor_id is set in the URL
/*
if (isset($_GET['product_vendor_id'])) {
    // Sanitize the input to prevent potential security issues
    $product_vendorId = filter_var($_GET['product_vendor_id'], FILTER_SANITIZE_NUMBER_INT);
} else {
    // If not set, set $product_vendorId to null or any default value
    $product_vendorId = null;
}
*/
?>

<main class="container mt-3"> <!-- Bootstrap container class added -->
    <?php if ($user_role === 'buyer') { ?>
        <h1>Welcome, <?php    echo $user_name;    ?>!</h1>
        <div  class="row" class="product-list">
            <?php     // Display buyer-specific products
            foreach ($products as $product) {     ?>
                <div class="col-md-6">
                    <?php   if ($product_vendorId !== null) {   //  TODO:   $product_vendorId seems to be always null???    
                        //  but careful, $product_vendorId is also a shop's name..!!!   ?>
                        <?php if ($product_vendorId == $product['vendor_id']) { ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="product-card-buyer">
                                        <h2>kondition one</h2>
                                        <h2><?= $product['product_name']; ?></h2>
                                        <p><?= $product['description']; ?></p>
                                        <p>Price: $<?= $product['price']; ?></p>
                                        <button class="btn btn-primary"><a href="../cart/cart.php?action=add_to_cart&selected_product_id=<?= $product['product_id']; ?>">Add to Cart</a></button>
                                    </div>
                                </div>
                            </div>
                            <!-- <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Visit Vendor's Shop</a></p> -->
                        <?php }     //  ends    if ($product_vendorId == $product['vector_id']) {?>
                    <?php } else { ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="product-card-buyer">
                                    <h2>kondition two</h2>
                                        <h2><?= $product['product_name']; ?></h2>
                                        <p><?= $product['description']; ?></p>
                                        <p>Price: $<?= $product['price']; ?></p>
                                        <button><a href="templates/cart/cart.php?action=add_to_cart&selected_product_id=<?= $product['product_id']; ?>">Add to Cart</a></button>
                                    
                                    <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Visit Vendor's Shop</a></p>
                                </div>
                            </div>
                        </div>    
                    <?php    }  //  ends if else if ($product_vendorId !== null) {   ?>
                </div> 
            <?php    }  //  ends foreach    ?>
        </div>
    <?php } elseif ($user_role === 'vendor') {      //  ends if ($user_role === 'buyer') {  ?>
        <h1>Welcome, <?php    echo $user_name;    ?>!</h1>
        <div class="row">
            <div class="vendor-dashboard">
                <!-- Display vendor-specific dashboard or content -->
                <p>Vendor-specific content goes here.</p>
            
                <?php foreach ($products as $product) { ?>
                    <div class="col-md-6">
                        <?php   if ($product_vendorId !== null) { ?>
                            <?php if ($product_vendorId == $product['vendor_id']) { ?>
                                <?php if ($product['vendor_id'] === $vendorId) { ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="product-card-vendor">
                                                <h2>first kondition</h2>
                                                <h2><?= $product['product_name']; ?></h2>
                                                    <p><?= $product['description']; ?></p>
                                                    <p>Price: $<?= $product['price']; ?></p>
                                                    <button>Edit</button>
                                                    <button><a href='../../templates/shop/edit.php?product_id=<?=    $product['product_id']; ?>'>Try Edit</a></button>
                                                    <button>Delete</button>
                                                    <button><a href='../../templates/shop/delete.php?product_id=<?=    $product['product_id']; ?>'>Try delete</a></button>
                                                <!--    <p><a href="templates/vendor/index.php?product_vendor_id=<?= $vendorId; ?>">Go To Your Shop</a></p> -->
                                            </div>  <!--    end product-card-vendor -->
                                        </div>
                                    </div>
                                <?php }     //  end if ($product['vendor_id'] === $vendorId) {  ?>
                                <?php if ($product['vendor_id'] !== $vendorId) { ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="product-card-vendor">
                                                <h2>second kondition</h2>
                                                <h2><?= $product['product_name']; ?></h2>
                                                    <p><?= $product['description']; ?></p>
                                                    <p>Price: $<?= $product['price']; ?></p>
                                                    <button class="btn btn-primary"><a href="../../templates/cart/cart.php?action=add_to_cart&selected_product_id=<?= $product['product_id']; ?>">Add to Cart</a></button>
                                                    <!--    <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Visit Vendor's Shop</a></p> -->
                                            </div>
                                        </div>
                                    </div>
                                <?php }     //  end if ($product['vendor_id'] !== $vendorId) {  ?>
                            </div>
                        <?php }     //  end if ($product_vendorId == $product['vendor_id']) { ?>
                    </div>
                <?php } else {  //  else for   if ($product_vendorId !== null) { ?>
                    <?php if ($product['vendor_id'] === $vendorId) { ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="product-card-vendor">
                                    <h2>third kondition</h2>
                                    <h2><?= $product['product_name']; ?></h2>
                                        <p><?= $product['description']; ?></p>
                                        <p>Price: $<?= $product['price']; ?></p>
                                        <button>Edit</button>
                                        <button><a href='../../templates/shop/edit.php?product_id=<?=    $product['product_id']; ?>'>Try Edit</a></button>
                                            <button>Delete</button>
                                            <button><a href='../../templates/shop/delete.php?product_id=<?=    $product['product_id']; ?>'>Try delete</a></button>
                                        <p><a href="templates/vendor/index.php?product_vendor_id=<?= $vendorId; ?>">Go To Your Shop</a></p>
                                </div>
                            </div>
                        </div>
                    <?php }     //  end if ($product['vendor_id'] === $vendorId) {  ?>
                <?php if ($product['vendor_id'] !== $vendorId) { ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="product-card-vendor">
                                <h2>fourth kondition</h2>
                                <h2><?= $product['product_name']; ?></h2>
                                        <p><?= $product['description']; ?></p>
                                        <p>Price: $<?= $product['price']; ?></p>
                                        <button><a href="../../templates/cart/cart.php?action=add_to_cart&selected_product_id=<?= $product['product_id']; ?>">Add to Cart</a></button>
                                        <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Visit Vendor's Shop</a></p>
                            </div>
                        </div>
                    </div>
                <?php }  ?>
            <?php     }   //  ende   if ($product_vendorId !== null) { ?>
            </div>    <!--    ends col-md-6"    -->
            <?php    }  //  ends foreach    ?>
    </div>  <!--    ends class="vendor-dashboard"    -->
    </div>  <!--    ends class="row"    -->
<?php } elseif ($user_role === 'admin') { //  end user role === $vendor ?>    
    <h1>Welcome, <?php    echo $user_name;    ?>!</h1>
    <div class="row">
        <div class="admin-dashboard">
            <!-- Display admin-specific dashboard or content -->
            <p>Admin-specific content goes here.</p>
        
            <?php foreach ($products as $product) { ?>
                <div class="col-md-6">
                    <?php   if ($product_vendorId !== null) { ?>
                        <?php if ($product_vendorId == $product['vendor_id']) { ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="product-card-admin">
                                        <h2>first kondition</h2>
                                        <h2><?= $product['product_name']; ?></h2>
                                                <p><?= $product['description']; ?></p>
                                                <p>Price: $<?= $product['price']; ?></p>
                                                <button>Edit</button>
                                                <button><a href='../../templates/shop/edit.php?product_id=<?=    $product['product_id']; ?>'>Try Edit</a></button>
                                                <button>Delete</button>
                                                <button><a href='../../templates/shop/delete.php?product_id=<?=    $product['product_id']; ?>'>Try delete</a></button>
                                                <!--    <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Check Vendor's Shop</a></p> -->
                                    </div>
                                </div>
                            </div>
                        <?php }     //  ends    if ($product_vendorId == $product['vendor_id']) {?>
                    <?php } else { ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="product-card-admin">
                                <h2>second condition</h2>
                                    <h2><?= $product['product_name']; ?></h2>
                                        <p><?= $product['description']; ?></p>
                                        <p>Price: $<?= $product['price']; ?></p>
                                        <button>Edit</button>
                                        <button><a href='templates/shop/edit.php?product_id=<?=    $product['product_id']; ?>'>Try Edit</a></button>
                                        <button>Delete</button>
                                        <button><a href='templates/shop/delete.php?product_id=<?=    $product['product_id']; ?>'>Try delete</a></button>
                                        <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Check Vendor's Shop</a></p>
                                </div>
                            </div>
                        </div>
                    <?php   }   //  ends if else if ($product_vendorId !== null) {      ?>
                </div>  <!-- end class=col-md-6  --> 
                <?php }       //  ends foreach    ?>
            </div>  <!-- end class=admin-dashboard   --> 
            </div> <!-- end class=row   -->
        <?php } else {  //  end user_role === admin ?>
            <!-- Default content for non-logged-in users --><!-- 
            <h1>Welcome, Visitor!</h1>
            <p>Content for visitors or unauthenticated users goes here.</p>
            <div class="product-card-random">
                    <h2>Product Name</h2>
                    <p>Description of the product for buyers.</p>
                    <p>Price: $19.99</p>
                    <button>Add to Cart</button>
                </div> -->
            <h1>Welcome, Random Visitor!</h1>
            <div class="product-list">
                <?php
                /*
                // Include necessary files
                require_once '../../config.php';
                require_once '../../includes/database.php';
                require_once '../../controllers/vendorshop_controller.php';

                //  TODO not necessary, do <>
                // Fetch products for the buyer
                $products = get_products();
                */
                
                // Display buyer-specific products
                foreach ($products as $product) {
                    ?>
                    <div class="col-md-6">
                        <?php   if ($product_vendorId !== null) {
                            //  means user is in somebodys shop??? ?>
                            <?php if ($product_vendorId == $product['vendor_id']) { ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="product-card-buyer">
                                            <h2>case one</h2>
                                                <h2><?= $product['product_name']; ?></h2>
                                            <p><?= $product['description']; ?></p>
                                            <p>Price: $<?= $product['price']; ?></p>
                                            <button><a href="../cart/cart.php?action=add_to_cart&selected_product_id=<?= $product['product_id']; ?>">Add to Cart</a></button>
                                            <!--    <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Visit Vendor's Shop</a></p> -->
                                        </div>
                                    </div>
                                </div>
                            <?php }     //  ends    if ($product_vendorId == $product['vendor_id']) {?>
                        <?php } else { ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="product-card-buyer">
                                        <h2>case two</h2>
                                        <h2><?= $product['product_name']; ?></h2>
                                        <p><?= $product['description']; ?></p>
                                        <p>Price: $<?= $product['price']; ?></p>
                                        <button><a href="templates/cart/cart.php?action=add_to_cart&selected_product_id=<?= $product['product_id']; ?>">Add to Cart</a></button>
                                        <p><a href="templates/vendor/index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Visit Vendor's Shop</a></p>
                                        <!--    <p><a href="index.php?product_vendor_id=<?= $product['vendor_id']; ?>">Visit Vendor's Shop</a></p> -->
                                    </div>
                                </div>
                            </div>
                        <?php    }  //  ends if else if ($product_vendorId !== null) {   ?>
                    </div>
                <?php    }      //  ends foreach    ?>
                
            </div>    
        
        <?php }      //  ends user role == random_visitor    ?>

</main>