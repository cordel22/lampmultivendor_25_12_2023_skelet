<?php
/*  TODO asi do <>
// Include configuration and common functions
require_once '../config.php';
require_once '../includes/database.php';
  TODO asi do <>    */

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
//  Im putting this into productdisplay_controller.php
// Function to get paginated products
function get_products($page = 1, $perPage = 10) {
    // Implement your logic to fetch products from the database based on pagination
    // Example: SELECT * FROM products LIMIT $perPage OFFSET ($page - 1) * $perPage
    // Return an array of products
    global $conn;
   
    try {
        $offset = ($page - 1) * $perPage;

        $query = "SELECT * FROM products LIMIT :perPage OFFSET :offset";
        $statement = $conn->prepare($query);
        $statement->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the results as an associative array
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}
*/

// Function to add a product to the database
function add_product($newProductDetails) {
    global $conn;

    try {
        // Check if the user is logged in and has the necessary privileges (e.g., vendor)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'vendor') {
            // User is not logged in as a vendor, handle accordingly (e.g., redirect to unauthorized page)
            return false;
        }

        // Add your logic to insert the new product into the database
        // ...

         // Extract product details
         $productName = $newProductDetails['product_name'];
         $description = $newProductDetails['description'];
         $price = $newProductDetails['price'];
         $stock = $newProductDetails['stock'];
         // $categoryId = $newProductDetails['category_id']; // Assuming you have a category_id in your form
 
         // Get the vendor ID from the session
         $vendorId = $_SESSION['vendor_id'];

         // Prepare and execute the query to insert the new product into the database
        $query = "INSERT INTO products (product_name, description, price, stock, category_id, vendor_id) 
        VALUES (:productName, :description, :price, :stock, :categoryId, :vendorId)";

        $statement = $conn->prepare($query);
        $statement->bindParam(':productName', $productName, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':price', $price, PDO::PARAM_STR);
        $statement->bindParam(':stock', $stock, PDO::PARAM_INT);
        $statement->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $statement->bindParam(':vendorId', $vendorId, PDO::PARAM_INT);

        $result = $statement->execute();

        // Assuming the insertion was successful, you can return true
        return true;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

//  TODO get producct details is not strictly vendor specific, move to a more general controller file?
// Function to get details of a specific product
function get_product_details($productId) {
    global $conn;

    try {
        // Prepare and execute the query to fetch the product details
        $query = "SELECT * FROM products WHERE product_id = :productId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result as an associative array
        $productDetails = $statement->fetch(PDO::FETCH_ASSOC);

        return $productDetails;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/* redundant, we get the details at login_process already
// Function to get details of the vendor's shop
function getShopDetails($userId) {
    global $conn;

    try {
        // Prepare and execute the query to fetch the shop details for the given user_id
        $query = "SELECT * FROM vendors WHERE user_id = :userId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result as an associative array
        $shopDetails = $statement->fetch(PDO::FETCH_ASSOC);

        return $shopDetails;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

*/




// Function to add a product to the cart
function add_to_cart($productId) {
    global $conn;

    try {
        // Check if the product exists
        $query = "SELECT * FROM products WHERE product_id = :productId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        $statement->execute();

        $product = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            // Product not found
            return false;
        }

        // Check if the cart session variable is set, if not, initialize it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart, update the quantity
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            // If not, add the product to the cart
            $_SESSION['cart'][$productId] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => 1,
            ];
        }

        return true;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to add a comment to a product
function add_comment($productId, $comment) {
    global $conn;

    try {
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            // User is not logged in, handle accordingly (e.g., redirect to login page)
            return false;
        }

        // Prepare and execute the query to insert the comment into the database
        $query = "INSERT INTO comments (user_id, product_id, comment) VALUES (:userId, :productId, :comment)";
        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
        $statement->execute();

        // Check if the comment was successfully added
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            // Comment not added, handle accordingly
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to edit a product (for the vendor)
function edit_product($productId, $newDetails) {
    global $conn;

    // Debugging output
    
    echo "Debug: Product ID in edit_product - ";
    var_dump($productId);

    echo "Debug: New Details in edit_product - ";
    var_dump($newDetails);

    echo "Debug: SESSION in edit_product - ";
    var_dump($_SESSION);
    /**/

    try {
        // Check if the user is logged in and has the necessary privileges (e.g., vendor)
        /*
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'vendor' || $_SESSION['user_role'] !== 'admin') {
            // User is not logged in as a vendor, handle accordingly (e.g., redirect to unauthorized page)
            return false;
        }
        */

        // Prepare and execute the query to update the product details in the database
        $query = "UPDATE products SET product_name = :productName, description = :description, price = :price, stock = :stock WHERE product_id = :productId AND vendor_id = :vendorId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':productName', $newDetails['product_name'], PDO::PARAM_STR);
        $statement->bindParam(':description', $newDetails['description'], PDO::PARAM_STR);
        $statement->bindParam(':price', $newDetails['price'], PDO::PARAM_STR);
        $statement->bindParam(':stock', $newDetails['stock'], PDO::PARAM_INT);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        //  $statement->bindParam(':vendorId', $_SESSION['vendor_id'], PDO::PARAM_INT);
        $statement->bindParam(':vendorId', $newDetails['vendor_id'], PDO::PARAM_INT);
        $statement->execute();

        // Check if the product was successfully updated
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            // Product not updated, handle accordingly
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to delete a product (for the vendor)
function delete_product($productId) {
    global $conn;

    try {
        // Check if the user is logged in and has the necessary privileges (e.g., vendor)
        
        if (!(isset($_SESSION['user_id']) || $_SESSION['user_role'] == 'vendor' || $_SESSION['user_role'] !== 'admin')) {
            // User is not logged in as a vendor, handle accordingly (e.g., redirect to unauthorized page)
            return false;
        }
        

        // Prepare and execute the query to delete the product from the database
        //  $query = "DELETE FROM products WHERE product_id = :productId AND vendor_id = :vendorId";
        $query = "DELETE FROM products WHERE product_id = :productId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        //  $statement->bindParam(':vendorId', $_SESSION['vendor_id'], PDO::PARAM_INT);
        $statement->execute();

        // Check if the product was successfully deleted
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            // Product not deleted, handle accordingly
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to add a comment to a product (for the vendor)
function add_vendor_comment($productId, $comment) {
    global $conn;

    try {
        // Check if the user is logged in and has the necessary privileges (e.g., vendor)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'vendor') {
            // User is not logged in as a vendor, handle accordingly (e.g., redirect to unauthorized page)
            return false;
        }

        // Prepare and execute the query to add the vendor's comment to the database
        $query = "INSERT INTO comments (user_id, product_id, comment) VALUES (:userId, :productId, :comment)";
        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
        $statement->execute();

        // Check if the comment was successfully added
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            // Comment not added, handle accordingly
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to delete a comment (for the vendor)
function delete_vendor_comment($commentId) {
    global $conn;

    try {
        // Check if the user is logged in and has the necessary privileges (e.g., vendor)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'vendor') {
            // User is not logged in as a vendor, handle accordingly (e.g., redirect to unauthorized page)
            return false;
        }

        // Prepare and execute the query to delete the vendor's comment from the database
        $query = "DELETE FROM comments WHERE comment_id = :commentId AND user_id = :userId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->execute();

        // Check if the comment was successfully deleted
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            // Comment not deleted, handle accordingly
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to add a comment to a product (for the admin)
function add_admin_comment($productId, $comment) {
    global $conn;

    try {
        // Check if the user is logged in and has the necessary privileges (e.g., admin)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            // User is not logged in as an admin, handle accordingly (e.g., redirect to unauthorized page)
            return false;
        }

        // Prepare and execute the query to add the admin's comment to the database
        $query = "INSERT INTO admin_comments (user_id, product_id, comment) VALUES (:userId, :productId, :comment)";
        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
        $statement->execute();

        // Check if the comment was successfully added
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            // Comment not added, handle accordingly
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to delete a comment (for the admin)
function delete_admin_comment($commentId) {
    global $conn;

    try {
        // Check if the user is logged in and has the necessary privileges (e.g., admin)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            // User is not logged in as an admin, handle accordingly (e.g., redirect to unauthorized page)
            return false;
        }

        // Prepare and execute the query to delete the admin's comment from the database
        $query = "DELETE FROM admin_comments WHERE comment_id = :commentId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->execute();

        // Check if the comment was successfully deleted
        if ($statement->rowCount() > 0) {
            return true;
        } else {
            // Comment not deleted, handle accordingly
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Add more functions as needed based on your application requirements

?>