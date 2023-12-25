<?php
// Database configuration (replace with your actual database credentials)
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "testdb"; // Replace with your MySQL database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set the character set to UTF-8
    $conn->exec("SET NAMES 'utf8'");

    //  test connectivity
    //  echo "Connected successfully";
    //  end test connectivity
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>