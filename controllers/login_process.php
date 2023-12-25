<?php

/*  replaced by getShopDetails
function getShopName($userId) {
    global $conn;

    try {
        // Prepare and execute the query to get the shop_name for the given user_id
        $query = "SELECT shop_name FROM vendors WHERE user_id = :userId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        //  test
        echo 'vycuc shop_name from db' . $result['shop_name'];
        //  end test

        if ($result) {
            // Return the shop_name if found
            return $result['shop_name'];
        } else {
            // Return a default value or handle the case when shop_name is not found
            return 'DefaultShopName'; // Replace with your default value or logic
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        // Return a default value or handle the error case
        return 'DefaultShopName'; // Replace with your default value or logic
    }
}
*/

function getShopDetails($userId) {
    global $conn;

    try {
        // Prepare and execute the query to get the shop_details for the given user_id
        $query = "SELECT * FROM vendors WHERE user_id = :userId";
        $statement = $conn->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch the result
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Return the shop details if found
            return $result;
        } else {
            // Return a default value or handle the case when shop details are not found
            return 'DefaultShopName'; // Replace with your default value or logic
        }
    } catch (PDOException $e) {
        // Handle the exception (log it, display an error message, etc.)
        // For now, let's just echo the error message
        echo "Error: " . $e->getMessage();
        // Return a default value or handle the error case
        return 'DefaultShopName'; // Replace with your default value or logic
    }
}


function loginProcess() {
    global $conn;

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Perform login validation
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Placeholder validation, you should check against your database
            // Modify this query based on your user table structure
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Check if the user exists
            if ($stmt->rowCount() > 0) {
                // Set user role and redirect to the appropriate dashboard
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];
                
                // If the user is a vendor, retrieve and set the shop_name
                if ($user['role'] === 'vendor') {
                    $shopDetails = getShopDetails($user['user_id']); // Implement this function in vendorshop_controller.php I wrote it here above
                    $_SESSION['vendor_id'] = $shopDetails['vendor_id'];
                    $_SESSION['shop_name'] = $shopDetails['shop_name'];
                    $_SESSION['shop_description'] = $shopDetails['shop_description'];
                    // Add other shop details as needed
                }
                //  header('Location: ' . BASE_URL . '/templates/' . $_SESSION['user_role'] . '/index.php');
                header('Location: ' . BASE_URL . '/index.php');
                exit();
            } else {
                // Invalid credentials, show an error message
                $error_message = 'Invalid username or password';
            }



        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Login failed: " . $e->getMessage();
    }
}

?>