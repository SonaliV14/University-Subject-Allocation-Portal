<?php
require_once "config.php";

$email = $new_password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST["email"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate new password
    if (strlen($new_password) < 6) {
        $password_err = "Password must be at least 6 characters long.";
    }

    // Validate confirm password
    if ($new_password !== $confirm_password) {
        $confirm_password_err = "Passwords do not match.";
    }

    // Check if the email exists in the database
    $sql = "SELECT id FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Update user's password
                $sql_update = "UPDATE users SET password = ? WHERE email = ?";
                if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
                    mysqli_stmt_bind_param($stmt_update, "ss", $param_password, $param_email);
                    $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $param_email = $email;

                    if (mysqli_stmt_execute($stmt_update)) {
                        echo "Password reset successfully.";
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }
            } else {
                $email_err = "No account found with that email.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgot-pswd.css">
</head>
<link href="first_page.css" rel="stylesheet">
<style>::afterbody {
    font-family: Arial, sans-serif;
    background-color: #f3f4f6;
    margin: 0;
    padding: 0;
}

.container {
    width: 100%;
    max-width: 400px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color:#333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: green;
}

.error-message {
    color: red;
    margin-bottom: 10px;
    font-size: 14px;
}
.go-back {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: black;
}

.go-back:hover {
    color: #0056b3;
}

.success-message {
    text-align: center;
    margin-top: 10px;
    color: green; /* Apply green color */
    display: none; /* Initially hide the message */
}
</style>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgot-pswd.php" method="post">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            <button type="submit" name="reset-password">Reset Password</button>
            <p class="success-message" id="successMessage">Password reset successfully.</p>
        </form>
        <a href="first_page.php" class="go-back">Go Back to Login</a>
    </div>
</body>
</html>
