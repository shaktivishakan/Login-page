<?php

$hostName = "localhost";
$dbName = "register";
$username = "root";
$password = "";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$hostName;dbname=$dbName", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Echo a success message
    echo "Connected successfully";
} catch(PDOException $e) {
    // If connection fails, display an error message
    echo "Connection failed: " . $e->getMessage();
}

?>
