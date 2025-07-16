<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: first_page.php");
    exit;
}

require_once "config.php";

$enrollment_no = $_SESSION["enrollment_no"];

// Check if the user already has documents uploaded
$sql_check = "SELECT enrollment_no FROM documents WHERE enrollment_no = ?";
$stmt_check = mysqli_prepare($conn, $sql_check);
if ($stmt_check) {
    mysqli_stmt_bind_param($stmt_check, "s", $enrollment_no);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);
    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        // User already has documents uploaded, so prevent them from uploading new ones
        echo "Your documents are already submitted. You can't change them now!";
        exit;
    }
    mysqli_stmt_close($stmt_check);
}

// Check if all required files are uploaded
if(isset($_FILES['photo']) && isset($_FILES['sign']) && isset($_FILES['admsncard'])){
    $photo = $_FILES['photo'];
    $sign = $_FILES['sign'];
    $admsncard = $_FILES['admsncard'];

    // Check if files are uploaded without errors
    if($photo['error'] === 0 && $sign['error'] === 0 && $admsncard['error'] === 0){
        $photo_name = $photo['name'];
        $sign_name = $sign['name'];
        $admsncard_name = $admsncard['name'];

        // Move uploaded files to a directory
        $photo_destination = 'uploads/' . $photo_name;
        $sign_destination = 'uploads/' . $sign_name;
        $admsncard_destination = 'uploads/' . $admsncard_name;

        move_uploaded_file($photo['tmp_name'], $photo_destination);
        move_uploaded_file($sign['tmp_name'], $sign_destination);
        move_uploaded_file($admsncard['tmp_name'], $admsncard_destination);

        // Insert into documents table
        $sql = "INSERT INTO documents (enrollment_no, photo, signature, admission_card) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $enrollment_no, $photo_destination, $sign_destination, $admsncard_destination);

            if (mysqli_stmt_execute($stmt)) {
                echo "Documents uploaded successfully.";
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                 echo "Your documents are uploaded successfully !";
                exit;
            } else {
                echo "Error uploading documents.";
            }
        } else {
            echo "Error preparing statement.";
        }
    } else {
        echo "Error uploading files.";
    }
} else {
    echo "Please upload all required files.";
}
?>
