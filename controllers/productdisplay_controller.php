<?php

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Retrieve products using the vendorshop_controller function
if (!isset($products)) {
    $products = get_products();
}



//  careful!, this might rplace most of the following funx
//  careful about the pagination limit
//  useful in cart, but wrote anther func because of pagintion
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




//  TODO get producct details is not strictly vendor specific, move to a more general controller file?

//  Its not being used anyway, coomment it out
//  it says its used i templates/product_display, maybe comment that out as well
/*
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

*/

// Function to get the vendor ID of a specific product
function get_product_vendorId($product) {
    global $conn;

    try {
        // Prepare and execute the query to fetch the vendor ID of the product
        $query = "SELECT vendor_id FROM products WHERE product_id = :productId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':productId', $product['product_id'], PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result as an associative array
        $vendorId = $statement->fetch(PDO::FETCH_COLUMN);

        return $vendorId;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return null;
    }
}

// Function to get details of products creted by specific vendor
function get_vendor_products_details($vendorId) {
    global $conn;

    try {
        // Prepare and execute the query to fetch the vendor's products details
        $query = "SELECT * FROM products WHERE vendor_id = :vendorId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':vendorId', $vendorId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result as an associative array
        $vendorProductsDetails = $statement->fetch(PDO::FETCH_ASSOC);

        return $vendorProductsDetails;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Function to get details of all products
function get_all_products_details() {
    global $conn;

    try {
        // Prepare and execute the query to fetch all products details
        $query = "SELECT * FROM products";
        $statement = $conn->prepare($query);
        //  $statement->bindParam(':vendorId', $vendorId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result as an associative array
        $allProductsDetails = $statement->fetch(PDO::FETCH_ASSOC);

        return $allProductsDetails;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return false;
    }
}



// Function to get product IDs based on user role
function get_product_ids_by_user_role($userId, $userRole) {
    global $conn;

    try {
        // If the user is a vendor, get product IDs for that vendor
        if ($userRole === 'vendor') {
            $query = "SELECT product_id FROM products WHERE vendor_id IN (SELECT vendor_id FROM vendors WHERE user_id = $userId)";
        } else {
            // If the user is a buyer or has a different role, get all product IDs
            $query = "SELECT product_id FROM products";
        }

        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result as an associative array
        $productIds = $statement->fetchAll(PDO::FETCH_COLUMN);

        return $productIds;
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        return [];
    }
}


?>