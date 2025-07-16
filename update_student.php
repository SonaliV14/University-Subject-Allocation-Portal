<?php
require_once "config.php";

$enroll = $_GET['enroll'];
$data = json_decode(file_get_contents('php://input'), true);

// Prepare an update statement
$sql_update = "UPDATE student_details SET firstname=?, lastname=?, 
                -- Add other student details here
                WHERE enroll=?";
$stmt_update = mysqli_prepare($conn, $sql_update);
mysqli_stmt_bind_param($stmt_update, "sss", $data['firstname'], $data['lastname'], 
                // Add other student details here
                $enroll);

// Execute the update statement
if (mysqli_stmt_execute($stmt_update)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

mysqli_stmt_close($stmt_update);
mysqli_close($conn);
?>