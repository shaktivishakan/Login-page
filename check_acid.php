<?php
// Include database connection parameters
include 'database.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'issues' parameter is set
    if (isset($_POST['issues'])) {
        // Sanitize input data
        $issues = $_POST['issues'];
        
        try {
            // Prepare SQL statement to delete the row from the user-admin table
            $stmt = $conn->prepare("DELETE FROM `user-admin` WHERE issues = :issues");
            // Bind parameters
            $stmt->bindParam(':issues', $issues);
            // Execute the statement
            if ($stmt->execute()) {
                // Row deleted successfully
                echo "Row deleted successfully";
            } else {
                // Error deleting row
                echo "Error deleting row";
            }
        } catch (PDOException $e) {
            // Error handling
            echo "Error: " . $e->getMessage();
        }
    } else {
        // 'issues' parameter is missing
        echo "Missing 'issues' parameter";
    }
} else {
    // Invalid request method
    echo "Invalid request method";
}
?>
