<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Preferences</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            height: 200%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>The preferences made by students are listed below-</h2>
    <table>
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Enrollment No.</th>
                <th>Full Name</th>
                <th>Minor Preference 1</th>
                <th>Minor Preference 2</th>
                <th>Generic Preference 1</th>
                <th>Generic Preference 2</th>
                <th>VAC 1</th>
                <th>VAC 2</th>
                <th>VOC 1</th>
                <th>VOC 2</th>
            </tr>
        </thead>
        <tbody>
        <?php
require_once "config.php";

// Fetch subject choices from the database
$sql = "SELECT subjects.*, student_details.firstname, student_details.lastname FROM subjects
        LEFT JOIN student_details ON subjects.enrollment_no = student_details.enroll";
$result = $conn->query($sql);


if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

if ($result->num_rows > 0) {
    $serial_no = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$serial_no."</td>";
        echo "<td>" . $row["enrollment_no"] . "</td>";
        echo "<td>" . $row["firstname"] . " " . $row["lastname"] . "</td>";
        echo "<td>" . $row["Minor_pref_1"] . "</td>";
        echo "<td>" . $row["Minor_pref_2"] . "</td>";
        echo "<td>" . $row["Generic_pref_1"] . "</td>";
        echo "<td>" . $row["Generic_pref_2"] . "</td>";
        echo "<td>" . $row["VAC_1"] . "</td>";
        echo "<td>" . $row["VAC_2"] . "</td>";
        echo "<td>" . $row["VOC_1"] . "</td>";
        echo "<td>" . $row["VOC_2"] . "</td>";
        echo "</tr>";
        $serial_no++;
    }
} else {
    echo "<tr><td colspan='10'>No subject choices found.</td></tr>";
}

$conn->close();
?>

        </tbody>
    </table>
</body>
</html>
