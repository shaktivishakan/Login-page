<?php
// Include database connection parameters
include 'database.php';

// Check if AC ID is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the AC ID from the POST request
    $ac_id = $_POST['ac_id'];

    // Prepare SQL statement to check if AC ID exists
    $query = "SELECT * FROM `user-admin` WHERE num = '$ac_id'";
    $result = $conn->query($query);

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // AC ID exists in the database, send response
        echo 'exists';
    } else {
        // AC ID does not exist in the database
        echo 'not_exists';
    }
} else {
    // If AC ID is not sent via POST, return an error message
    echo 'error';
}
?>
