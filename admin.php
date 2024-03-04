<?php
// Include database connection parameters
include 'database.php';
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-container {
            text-align: center;
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

    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>User ID</th>
                    <th>Issue Type</th>
                    <th>AC ID</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Connect to the database
                $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // SQL query to retrieve data from the admin-user table
                $sql = "SELECT issue, num, descp FROM `user-admin`";

                $result = mysqli_query($conn, $sql);

                // Check if there are rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["issue"] . "</td>";
                        echo "<td>" . $row["num"] . "</td>";
                        echo "<td>" . $row["descp"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "0 results";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
        <div class="button-container">
            <button onclick="window.location.href='admin_logout.php'">Logout</button>
        </div>
    </div>

    <script>
        function updateStatus(status, ticketId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    location.reload();
                }
            };
            xhr.send("status=" + status + "&ticket_id=" + ticketId);
        }
    </script>
</body>
</html>
