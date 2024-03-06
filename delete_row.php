<?php
// Include database connection parameters
include 'database.php';

// Check if the 'issues' parameter is set
if (isset($_POST['issues'])) {
    // Sanitize the input
    $issues = $_POST['issues'];

    try {
        // Prepare SQL statement to delete the row corresponding to the selected issue
        $stmt = $conn->prepare("DELETE FROM `user-admin` WHERE issues = :issues");
        // Bind parameters
        $stmt->bindParam(':issues', $issues);
        // Execute the statement
        if ($stmt->execute()) {
            echo "Row deleted successfully";
        } else {
            echo "Error deleting row";
        }
    } catch (PDOException $e) {
        // Error handling
        echo "Error: " . $e->getMessage();
    }
} else {
    // If 'issues' parameter is not set, display an error message
    echo "Issues parameter is not set";
}

// Close the database connection
$conn = null;
?>
