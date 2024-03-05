<?php
// Include database connection parameters
include 'database.php';

// Check if the 'issues' parameter is set
if (isset($_POST['issues'])) {
    // Sanitize the input
    $issues = mysqli_real_escape_string($conn, $_POST['issues']);

    // SQL query to delete the row corresponding to the selected issue
    $sql = "DELETE FROM `user-admin` WHERE issues = '$issues'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "Row deleted successfully";
    } else {
        echo "Error deleting row: " . mysqli_error($conn);
    }
} else {
    // If 'issues' parameter is not set, display an error message
    echo "Issues parameter is not set";
}

// Close the database connection
mysqli_close($conn);
?>
