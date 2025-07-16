<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <!-- Include any necessary stylesheets -->
    <style>
        *{
            font-family: 'Montserrat', sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
            width: calc(80% / 3);
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2> List of students who have registerd on the portal-</h2>
    <table>
        <thead>
            <tr>
                <th>Enrollment Number</th>
                <th>Email</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "config.php";

            // Database connection
            $servername = "localhost";
            $username = "root"; // Your MySQL username
            $password = ""; // Your MySQL password
            $dbname = "login";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch user data
            $sql_fetch_users = "SELECT email, enrollment_no, time FROM users";
            $result_users = $conn->query($sql_fetch_users);

            // Display user data
            while ($row_users = $result_users->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row_users['enrollment_no']}</td>";
                echo "<td>{$row_users['email']}</td>";
                echo "<td>{$row_users['time']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Include any necessary scripts -->
</body>
</html>
