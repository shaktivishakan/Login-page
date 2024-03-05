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
                    <th>Issue Type</th>
                    <th>AC ID</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to the database
                include 'database.php';

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // SQL query to retrieve data from the admin-user table
                $sql = "SELECT issues, num, descp, status FROM `user-admin`";
                $result = mysqli_query($conn, $sql);

                // Check if there are rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["issues"] . "</td>";
                        echo "<td>" . $row["num"] . "</td>";
                        echo "<td>" . $row["descp"] . "</td>";
                        // Add dropdown box for Status column
                        echo "<td>";
                        echo "<select id='status_" . $row["issues"] . "'>";
                        echo "<option value='In-Progress' " . ($row["status"] == 'In-Progress' ? 'selected' : '') . ">In-Progress</option>";
                        echo "<option value='Hold' " . ($row["status"] == 'Hold' ? 'selected' : '') . ">Hold</option>";
                        echo "<option value='Completed' " . ($row["status"] == 'Completed' ? 'selected' : '') . ">Completed</option>"; // Added Completed option
                        echo "<option value='Cancel' " . ($row["status"] == 'Cancel' ? 'selected' : '') . ">Cancel</option>";
                        echo "</select>";
                        
                        echo "</td>";
                        // Add input field for Remarks column
                        echo "<td>";
                        echo "<input type='text' id='remarks_" . $row['issues'] . "' placeholder='Enter remarks'>";
                        echo "</td>";
                        // Add "Modify" button
                        echo "<td>";
                        echo "<button onclick=\"modifyStatus('" . $row["issues"] . "')\">Modify</button>";
                        echo "</td>";
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
        function modifyStatus(issues) {
            var status = document.getElementById('status_' + issues).value;
            var remarks = document.getElementById('remarks_' + issues).value;

            // Check if status is "Cancel"
            if (status === 'Cancel') {
                if (confirm("Are you sure you want to cancel this issue?")) {
                    // AJAX call to delete the row from the database
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'delete_row.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status == 200) {
                            // Handle success response
                            console.log(xhr.responseText);
                            // Optionally, you can reload the page after deleting the row
                            // location.reload();
                        } else {
                            // Handle error response
                            console.error(xhr.statusText);
                        }
                    };
                    xhr.send('issues=' + issues);
                }
            } else {
                // If status is not "Cancel", proceed with updating status
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_status.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // Handle success response
                        console.log(xhr.responseText);
                        // Optionally, you can reload the page after updating the status
                        // location.reload();
                    } else {
                        // Handle error response
                        console.error(xhr.statusText);
                    }
                };
                xhr.send('issues=' + issues + '&status=' + status + '&remarks=' + remarks);
            }
        }
    </script>
</body>
</html>
