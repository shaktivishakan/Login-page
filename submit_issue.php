<?php
// Include database connection parameters
include 'database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $issueType = $_POST['issue_type'];
    $acID = $_POST['ac_id'];
    $email = $_POST['email']; // Retrieve the email
    $description = $_POST['description'];

    try {
        // Prepare SQL statement to insert data into the database table
        $sql = "INSERT INTO `user-admin` (issues, num, email, descp) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        // Bind parameters to avoid SQL injection
        $stmt->bindParam(1, $issueType);
        $stmt->bindParam(2, $acID);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $description);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Issue submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } catch (PDOException $e) {
        // Handle PDO exception
        echo "Error: " . $e->getMessage();
    }
    
    // Close the statement and connection
    $stmt = null;
    $conn = null;
}
?>
