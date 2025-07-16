<?php
require_once "config.php";

$emailSignup = $passwordSignup = $enrollSignup = "";
$email_err = $enroll_err = "";
$login_error = isset($_GET['login_error']) ? $_GET['login_error'] : "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check for existing email
    $sql_email = "SELECT id FROM users WHERE email = ?";
    $stmt_email = mysqli_prepare($conn, $sql_email);
    if($stmt_email) {
        mysqli_stmt_bind_param($stmt_email, "s", $param_email);
        $param_email = trim($_POST['emailSignup']);

        if(mysqli_stmt_execute($stmt_email)) {
            mysqli_stmt_store_result($stmt_email);
            if(mysqli_stmt_num_rows($stmt_email) == 1) {
                $email_err = "This email is already taken"; 
                echo "<p style='color: red;'> This Email already exist !";
            } else {
                $emailSignup = trim($_POST['emailSignup']);
            }
        } else {
            echo "Something went wrong";
        }
    }
    mysqli_stmt_close($stmt_email);

    // Check for existing enrollment number
    $sql_enroll = "SELECT id FROM users WHERE enrollment_no = ?";
    $stmt_enroll = mysqli_prepare($conn, $sql_enroll);
    if($stmt_enroll) {
        mysqli_stmt_bind_param($stmt_enroll, "s", $param_enroll);
        $param_enroll = trim($_POST['enrollSignup']);

        if(mysqli_stmt_execute($stmt_enroll)) {
            mysqli_stmt_store_result($stmt_enroll);
            if(mysqli_stmt_num_rows($stmt_enroll) == 1) {
                $enroll_err = "This enrollment number is already taken";
                echo "<p style='color: red;'>Enrollment number already taken !"; 
            } else {
                $enrollSignup = trim($_POST['enrollSignup']);
            }
        } else {
            echo "Something went wrong";
        }
    }
    mysqli_stmt_close($stmt_enroll);

    // Check for password
    $passwordSignup = trim($_POST['passwordSignup']);

    // If there were no errors, go ahead and insert into the database
    if(empty($email_err) && empty($enroll_err)) {
        $sql = "INSERT INTO users (email, enrollment_no, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_enroll, $param_password);
            $param_email = $emailSignup;
            $param_enroll = $enrollSignup;
            $param_password = password_hash($passwordSignup, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {
                header("location: first_page.php");
            } else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
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
                    <form id="loginForm" action="login.php" method="post">
                      <div class="login-head">
                        <input type="email" id="emailLogin" name="emailLogin" placeholder="Email" required><br>
                        <input type="password" id="passwordLogin" name="passwordLogin" placeholder="Password">
                      </div>
                    <div class="enquire">
                        <a href="forgot-pswd.php">Forgot password?</a>
                    </div><br>

                    <p class="message" id="emptyFieldsMessage2" style="color: red;"></p>
                    <p class="message" id="successMessage2" style="color: green;"></p>
                    <p class="message" id="loginErrorMessage" style="color: red; text-align: center;"><?php echo htmlspecialchars($login_error); ?></p>

                    <button class="loginBtn" type="submit" onclick="validateForm2()">LOGIN</button><br>
                    </form>
                    <a href="admin-login.php">Click here for Administrator login</a>
                </div>

                <div id="signUp" class="signupClass">
                    <form id="signupForm" action="" method="post">
                        <input type="email" id="emailSignup" name="emailSignup" placeholder="Email" required><br>
                        <input type="text" id="enrollSignup" name="enrollSignup" placeholder="Enrollment number (e.g. AB1234)" required><br>
                        <input type="password" id="passwordSignup" name="passwordSignup" placeholder="Password" required><br><br>
                        <p class="message" id="emptyFieldsMessage" style="color: red;"></p>
                        <button type="submit" class="signBtn" name="signup-submit" onclick="validateForm()">CREATE ACCOUNT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="first_page.js"></script>
</body>
</html>
