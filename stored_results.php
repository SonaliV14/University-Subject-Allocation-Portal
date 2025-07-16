<?php
// Include config.php for database connection
include_once 'config.php';

// Step 1: Retrieve Data
// Fetch students sorted by rank
$sql = "SELECT * FROM rank_list ORDER BY rank ASC";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

// Step 2: Allocate Subjects and Store Results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applno = $row['applno'];

        // Fetch student preferences from subjects table
        $sql_subjects = "SELECT * FROM subjects WHERE enrollment_no IN (SELECT enroll FROM student_details WHERE applno = '$applno')";
        $result_subjects = $conn->query($sql_subjects);

        if ($result_subjects === false) {
            die("Error executing query: " . $conn->error);
        }

        if ($result_subjects->num_rows > 0) {
            $row_subjects = $result_subjects->fetch_assoc();

            // Allocate subjects based on preferences and available seats
            $allocated_minor_subject = allocateSubject($row_subjects['Minor_pref_1'], $row_subjects['Minor_pref_2'], 'allocated_minor_subject');
            $allocated_generic_subject = allocateSubject($row_subjects['Generic_pref_1'], $row_subjects['Generic_pref_2'], 'allocated_generic_subject');
            $allocated_vocational_subjects = allocateSubjects([$row_subjects['VOC_1'], $row_subjects['VOC_2']], 2, 'allocated_vocational_subjects');
            $allocated_vac_subjects = allocateSubjects([$row_subjects['VAC_1'], $row_subjects['VAC_2']], 2, 'allocated_vac_subjects');

            // Insert the data into the results table only if the enrollment number doesn't already exist
            $sql_insert = "INSERT INTO results (applno, enrollment_no, allocated_minor_subject, allocated_generic_subject, allocated_voc_subject_1, allocated_voc_subject_2, allocated_vac_subject_1, allocated_vac_subject_2) 
               SELECT '$applno', '".$row_subjects['enrollment_no']."', '$allocated_minor_subject', '$allocated_generic_subject', '".$allocated_vocational_subjects[0]."', '".$allocated_vocational_subjects[1]."', '".$allocated_vac_subjects[0]."', '".$allocated_vac_subjects[1]."'
               FROM dual 
               WHERE NOT EXISTS (
                   SELECT enrollment_no FROM results WHERE enrollment_no = '".$row_subjects['enrollment_no']."'
               ) LIMIT 1";


            if ($conn->query($sql_insert) === false) {
                die("Error inserting data into results table: " . $conn->error);
            }
        } else {
            echo "No preferences found for student with application number '$applno'.<br>";
        }
    }
} else {
    echo "No students found in the rank list.<br>";
}

// Function to allocate subjects based on preferences and available seats
function allocateSubject($pref1, $pref2, $column_name) {
    // Allocate the first preference if available, otherwise allocate the second preference
    return (!empty($pref1)) ? $pref1 : $pref2;
}

// Function to allocate multiple subjects based on preferences and available seats
function allocateSubjects($preferences, $count, $column_name) {
    global $conn;
    $allocated_subjects = [];
    foreach ($preferences as $preference) {
        if (!empty($preference)) {
            // Determine the appropriate table based on the column name
            switch ($column_name) {
                case 'allocated_vocational_subjects':
                    $table_name = 'seat_matrix_voc';
                    break;
                case 'allocated_minor_subject':
                    $table_name = 'seat_matrix_minor';
                    break;
                case 'allocated_generic_subject':
                    $table_name = 'seat_matrix_generic';
                    break;
                case 'allocated_vac_subjects':
                    $table_name = 'seat_matrix_vac';
                    break;
                default:
                    $table_name = ''; // Set to an empty string for error handling
            }
            // Fetch the max seats for the subject from the respective table
            $sql_max_seats = "SELECT max_seats FROM $table_name WHERE subject = '$preference'";
            $result_max_seats = $conn->query($sql_max_seats);
            if ($result_max_seats->num_rows > 0) {
                $row_max_seats = $result_max_seats->fetch_assoc();
                $allocated_subjects[] = $preference;
                // Check if the number of allocated subjects exceeds the count
                if (count($allocated_subjects) == $count) {
                    break;
                }
            }
        }
    }
    // Ensure that the array contains at least $count elements
    while (count($allocated_subjects) < $count) {
        $allocated_subjects[] = ''; // Add empty elements if necessary
    }
    return $allocated_subjects;
}

// After allocating subjects, update the round1 column in each seat_matrix table
$update_round1_query = "UPDATE seat_matrix_minor SET round1 = max_seats - (SELECT COUNT(*) FROM results WHERE allocated_minor_subject = seat_matrix_minor.subject)";
$conn->query($update_round1_query);

$update_round1_query = "UPDATE seat_matrix_generic SET round1 = max_seats - (SELECT COUNT(*) FROM results WHERE allocated_generic_subject = seat_matrix_generic.subject)";
$conn->query($update_round1_query);

$update_round1_query = "UPDATE seat_matrix_voc SET round1 = max_seats - (SELECT COUNT(*) FROM results WHERE allocated_voc_subject_1 = seat_matrix_voc.subject OR allocated_voc_subject_2 = seat_matrix_voc.subject)";
$conn->query($update_round1_query);

$update_round1_query = "UPDATE seat_matrix_vac SET round1 = max_seats - (SELECT COUNT(*) FROM results WHERE allocated_vac_subject_1 = seat_matrix_vac.subject OR allocated_vac_subject_2 = seat_matrix_vac.subject)";
$conn->query($update_round1_query);

?>
