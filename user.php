<?php
session_start();
// Include database connection parameters
include 'database.php';

// Check if AC ID already exists in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ac_id = $_POST['ac_id'];
    $query = "SELECT * FROM `user-admin` WHERE num = :ac_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':ac_id', $ac_id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('AC ID already entered');</script>";
    } else {
        // AC ID does not exist, proceed with form submission
        // Add your form submission code here
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report AC Issue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px; /* Increased width to accommodate the history */
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        textarea,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        #email{
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 150px; /* Adjust height as needed */
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Style for the complaint history */
        .complaint-history {
            margin-top: 50px;
        }

        .complaint-history h3 {
            margin-bottom: 10px;
        }

        .complaint-history ul {
            list-style-type: none;
            padding: 0;
        }

        .complaint-history li {
            margin-bottom: 10px;
        }

    </style>
     <script>
        // AJAX call to check if AC ID exists
function checkAcId(acId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'check_acid.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status == 200) {
            // Check the response from the server
            if (xhr.responseText == 'exists') {
                alert('AC ID already in checking');
            } else if (xhr.responseText == 'not_exists') {
                // AC ID is not in the database, continue with form submission
                document.getElementById('report-form').submit();
            } else {
                alert('Error occurred');
            }
        } else {
            alert('Request failed. Please try again.');
        }
    };
    xhr.send('ac_id=' + acId);
}

    </script>
</head>
<body>
    <div class="container">
        <h2>Report AC Issue</h2>
        <form action="submit_issue.php" method="post">
            <label for="issue_type">Issue Type:</label>
            <select id="issue_type" name="issue_type" required>
                <option value="">Select Issue Type</option>
                <option value="Not Cooling">Not Cooling</option>
                <option value="Noisy Operation">Noisy Operation</option>
                <option value="Leaking Water">Leaking Water</option>
                <option value="other">Other problem</option>
                <!-- Add more options as needed -->
            </select>
            <label for="ac_id">AC ID Number:</label>
            <input type="text" id="ac_id" name="ac_id" placeholder="Enter AC ID Number" required>
            <!-- Call JavaScript function on blur event to check AC ID -->
            <input type="text" onblur="checkACID()" style="display: none;">
            <!-- Add an input field for email below the AC ID input -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Describe the issue..." required></textarea>
            <button type="submit">Submit Issue</button>
        </form>

        

    </div>
</body>
</html>
