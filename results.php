<?php
// Start session
session_start();

// Include config.php for database connection
include_once 'config.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Subject Allocation</title>";
echo "<style>";
echo "table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }

    button[name='send_results'] {
        background-color: #4CAF50; 
        color: white; 
        padding: 10px 20px; 
        border: none;  
        border-radius: 4px;
        cursor: pointer; 
        margin-top: 20px; 
    }

    button[name='send_results']:hover {
        background-color: #45a049;
    }";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h2>Subject Allocation</h2>";

// Include stored_results.php to handle the allocation and storage of results
include 'stored_results.php';

// Display the table headers
echo "<table>";
echo "<tr><th>Serial No.</th><th>Enrollment No.</th><th>Application No.</th><th>Allocated Minor Subject</th><th>Allocated Generic Subject</th><th>Allocated Vocational Subjects</th><th>Allocated Value-Added Subjects</th></tr>";

// Retrieve and display data from the results table
$sql_display = "SELECT * FROM results";
$result_display = $conn->query($sql_display);

if ($result_display->num_rows > 0) {
    $serial_no = 1;
    while($row_display = $result_display->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$serial_no."</td>";
        echo "<td>".$row_display['enrollment_no']."</td>";
        echo "<td>".$row_display['applno']."</td>";
        echo "<td>".$row_display['allocated_minor_subject']."</td>";
        echo "<td>".$row_display['allocated_generic_subject']."</td>";
        echo "<td>".$row_display['allocated_voc_subject_1'].", ".$row_display['allocated_voc_subject_2']."</td>";
        echo "<td>".$row_display['allocated_vac_subject_1'].", ".$row_display['allocated_vac_subject_2']."</td>";
        echo "</tr>";
        $serial_no++;
    }
} else {
    echo "No results found.";
}

echo "</table>";

// Process sending results to the student's dashboard
if (isset($_POST['send_results'])) {
    // Query to update results_sent flag for all students
    $sql_update_flag = "UPDATE results SET results_sent = TRUE";
    if ($conn->query($sql_update_flag) === TRUE) {
        echo "<p style='color: green;'>Results sent successfully.</p>";
    } else {
        echo "Error updating database: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!-- Add the "Send Results" button -->
<form action="results.php" method="post">
<input type="hidden" name="admin_access" value="true">
    <button type="submit" name="send_results">Send Results</button>
</form>

</body>
</html>