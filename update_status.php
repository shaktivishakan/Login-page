<?php
// Include database connection parameters
include 'database.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required parameters are set
    if (isset($_POST['issues'], $_POST['status'])) {
        // Sanitize input data
        $issues = $_POST['issues'];
        $status = $_POST['status'];

        try {
            // Check if remarks are provided
            if (isset($_POST['remarks'])) {
                $remarks = $_POST['remarks'];
                // Update the status and remarks in the database
                $sql = "UPDATE `user-admin` SET status = ?, remarks = ? WHERE issues = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$status, $remarks, $issues]);
            } else {
                // Update only the status in the database
                $sql = "UPDATE `user-admin` SET status = ? WHERE issues = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$status, $issues]);
            }

            // Check if the query was successful
            if ($stmt->rowCount() > 0) {
                // Status updated successfully
                echo "Status updated successfully";
            } else {
                // No rows affected, issue may not exist
                echo "No rows affected, issue may not exist";
            }
        } catch (PDOException $e) {
            // Handle PDO exception
            echo "Error updating status: " . $e->getMessage();
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
