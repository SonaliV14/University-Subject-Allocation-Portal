<?php
// Include config file
require_once "config.php";

$loginID = $password = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $loginID = htmlspecialchars(trim($_POST["loginId"]));
    $password = htmlspecialchars(trim($_POST["passwordLogin"]));

    // Validate credentials
    if (empty($loginID) || empty($password)) {
        echo "Login ID and password are required!";
    } else {
        $sql = "SELECT id, password FROM admin_details WHERE loginID = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_loginID);
            $param_loginID = $loginID;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, redirect to admin dashboard
                            header("location: admin-dashboard.html");
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            echo "Invalid password!";
                        }
                    }
                } else {
                    // Display an error message if loginID doesn't exist
                    echo "Invalid login ID!";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="first_page.css">
</head>
<style>
    .error-mssg{
        font-size: smaller;
        display: none;
        color: red;
        margin: 0 0 0 0;
    }
</style>
<body>
    <div class="upper">
        <img class="logo" src="amulogo.png" alt="University Logo">
        <div class="headings">
            <h1 id="heading1">Aligarh Muslim University</h1>
            <h2 id="heading2">Subject Allocation Portal</h2>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="nav">
                <button class="btn btn1" id="btns1" onclick="showLogin()">Login</button>
                <button class="btn btn2" id="btns2" onclick="showSignup()">Sign Up</button>
            </div>
            <div class="main">
                <div id="login" class="loginClass">
                    <form id="admin-login-form" action="" method="post">
                      <div class="login-head">
                        <input type="text" id="loginId" name="loginId" placeholder="Login ID" required>
                        <span class="error-mssg"></span> <!-- Add this line for error message -->
                        <br>
                        <input type="password" id="passwordLogin" name="passwordLogin" placeholder="Password">
                        <span class="error-mssg"></span> <!-- Add this line for error message -->
                      </div>
                    <button class="loginBtn" type="submit">LOGIN</button><br>
                    </form>
                    <a href="first_page.php">Go back to Student Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('admin-login-form');
        const loginIdInput = document.getElementById('loginId');
        const passwordInput = document.getElementById('passwordLogin');
    
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
    
            // Reset error messages
            resetErrors();
    
            // Check for empty fields
            if (loginIdInput.value.trim() === '') {
                showError(loginIdInput, 'Login ID is required');
                return;
            }
    
            if (passwordInput.value.trim() === '') {
                showError(passwordInput, 'Password is required');
                return;
            }
    
            // Validate login ID format
            const loginIdPattern = /^\d{6}$/;
            if (!loginIdPattern.test(loginIdInput.value.trim())) {
                showError(loginIdInput, 'Inavlid Login ID format!');
                return;
            }
    
            // If all validations pass, redirect to admin-dashboard.html
            window.location.href = 'admin-dashboard.html';
        });
    
        // Function to show error message for specific input
        function showError(input, message) {
            const errorDiv = input.nextElementSibling;
            errorDiv.innerText = message;
            errorDiv.style.display = 'block';
        }
    
        // Function to reset error messages
        function resetErrors() {
            const errorMessages = document.querySelectorAll('.error-mssg');
            errorMessages.forEach(function(error) {
                error.style.display = 'none';
            });
        }
    });
    
</script>
</html>