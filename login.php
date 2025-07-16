<?php
require_once "config.php";

$email = $password = "";
$email_err = $password_err = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST["emailLogin"]);
    $password = trim($_POST["passwordLogin"]);

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, email, password, enrollment_no FROM users WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $enrollment_no);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["enrollment_no"] = $enrollment_no; // Store enrollment number in session

                            // Redirect user to dashboard
                            header("location: dashboard.html");
                            exit;
                        } else {
                            // Password is not valid
                            header("location: first_page.php?login_error=Invalid Login Id/Password");
                            exit;
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    echo "No account found with that email.";
                }
            } else {
                header("location: first_page.php?login_error=No account found with that email");
                    exit;
            }}
             else {
                header("location: first_page.php?login_error=Oops! Something went wrong. Please try again later.");
                exit;
            }

            // Close statement
            mysqli_stmt_close($stmt);
        
    }

    // Close connection
    mysqli_close($conn);
}
?>