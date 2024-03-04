<?php
// Include database connection parameters
session_start();
include 'database.php';
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
            <input type="text" id="ac_id" name="ac_id" placeholder="Enter AC ID Number">
            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Describe the issue..." required></textarea>
            <button type="submit">Submit Issue</button>
        </form>

        <!-- Complaint History Section -->
        <div class="complaint-history">
            <h3>Complaint History</h3>
            <ul>
            <?php
                // Check if user_id is set in the session
                if (isset($_SESSION['user_id'])) {
                    // Retrieve user's complaints from the database
                    $db = new mysqli($hostName, $dbUser, $dbPassword, $dbName);
                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    }

                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT * FROM issues WHERE user_id = $user_id";
                    $result = $db->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><strong>Issue Type:</strong> " . $row['issue_type'] . " - <strong>Status:</strong> " . $row['status'] . "</li>";
                        }
                    } else {
                        echo "<li>No complaints found.</li>";
                    }

                    $db->close();
                } else {
                    echo "<li>User not logged in.</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Admin Status Update Section -->
        <div class="admin-status">
            <h3>Admin Status Update</h3>
            <?php
            // Check if user_id is set in the session
            if (isset($_SESSION['user_id'])) {
                // Retrieve the latest status update by the admin
                $db = new mysqli($hostName, $dbUser, $dbPassword, $dbName);
                if ($db->connect_error) {
                    die("Connection failed: " . $db->connect_error);
                }

                $user_id = $_SESSION['user_id'];
                $query = "SELECT status FROM issues WHERE user_id = $user_id ORDER BY id DESC LIMIT 1";
                $result = $db->query($query);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p><strong>Status:</strong> " . $row['status'] . "</p>";
                } else {
                    echo "<p>No status update yet.</p>";
                }

                $db->close();
            } else {
                echo "<p>User not logged in.</p>";
            }
            ?>

        </div>
    </div>
</body>
</html>
