<?php
// Include database connection parameters
include 'database.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required parameters are set
    if (isset($_POST['issues'], $_POST['status'])) {
        // Sanitize input data
        $issues = mysqli_real_escape_string($conn, $_POST['issues']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        // Check if remarks are provided and sanitize them
        if(isset($_POST['remarks'])) {
            $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
            // Update the status and remarks in the database
            $sql = "UPDATE `user-admin` SET status = '$status', remarks = '$remarks' WHERE issues = '$issues'";
        } else {
            // Update only the status in the database
            $sql = "UPDATE `user-admin` SET status = '$status' WHERE issues = '$issues'";
        }

        if (mysqli_query($conn, $sql)) {
            // Status updated successfully
            echo "Status updated successfully";
        } else {
            // Error updating status
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        // Missing parameters
        echo "Missing parameters";
    }
} else {
    // Invalid request method
    echo "Invalid request method";
}
?>
