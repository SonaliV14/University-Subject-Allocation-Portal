<?php
// Start session
session_start();

// Include config.php for database connection
include_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['enrollment_no'])) {
    // If not logged in, redirect to the login page
    header("Location: first_page.php");
    exit;
}

// Retrieve the enrollment number of the logged-in student
$student_enrollment_no = $_SESSION['enrollment_no'];

// Query the results table to get the allocated subjects for the student's enrollment number
$sql_results = "SELECT * FROM results WHERE enrollment_no = '$student_enrollment_no'";
$result_results = $conn->query($sql_results);

if ($result_results->num_rows > 0) {
    // Display the allocated subjects for the student's enrollment number
    echo "<h2>Allocated Subjects for Your Enrollment Number: $student_enrollment_no</h2>";
    echo "<ul>";
    while ($row_results = $result_results->fetch_assoc()) {
        echo "<li>Minor Subject: " . $row_results['allocated_minor_subject'] . " (Preference: " . getPreference($student_enrollment_no, $row_results['allocated_minor_subject']) . ")</li>";
        echo "<li>Generic Subject: " . $row_results['allocated_generic_subject'] . " (Preference: " . getPreference($student_enrollment_no, $row_results['allocated_generic_subject']) . ")</li>";
        echo "<li>Vocational Subjects: " . $row_results['allocated_voc_subject_1'] . ", " . $row_results['allocated_voc_subject_2'] . "</li>";
        echo "<li>Value-Added Subjects: " . $row_results['allocated_vac_subject_1'] . ", " . $row_results['allocated_vac_subject_2'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No allocated subjects found for your enrollment number: $student_enrollment_no";
}

// Function to get the preference (1 or 2) for a subject allocated to the student
function getPreference($enrollment_no, $subject) {
    global $conn;
    // Query the subjects table to get the preference for the subject allocated to the student
    $sql_preference = "SELECT Minor_pref_1, Minor_pref_2, Generic_pref_1, Generic_pref_2 FROM subjects WHERE enrollment_no = '$enrollment_no'";
    $result_preference = $conn->query($sql_preference);
    if ($result_preference->num_rows > 0) {
        $row_preference = $result_preference->fetch_assoc();
        // Check if the subject matches the student's preference 1 or preference 2 for Minor or Generic subjects
        if ($subject == $row_preference['Minor_pref_1']) {
            return "Preference 1";
        } elseif ($subject == $row_preference['Minor_pref_2']) {
            return "Preference 2";
        } elseif ($subject == $row_preference['Generic_pref_1']) {
            return "Preference 1";
        } elseif ($subject == $row_preference['Generic_pref_2']) {
            return "Preference 2";
        } else {
            return "Not found in preferences";
        }
    } else {
        return "Preferences not found";
    }
}

// Close connection
$conn->close();
?>
