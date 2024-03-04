<?php
// Include database connection parameters
include 'database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $issueType = $_POST['issue_type'];
    $acID = $_POST['ac_id'];
    $description = $_POST['description'];

    // Prepare SQL statement to insert data into the database table
    $sql = "INSERT INTO `user-admin` (issues, num, descp) VALUES (?, ?, ?)";

    // Prepare and bind parameters to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $issueType, $acID, $description);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Issue submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

