<?php
require_once "config.php";

// Fetch enrollment number based on the logged-in user's session
session_start();
$enroll = $_SESSION['enrollment_no'];

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['savebtn'])){

    // Retrieve form data
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $dob = $_POST['dob'];
    $fathername = trim($_POST['fathername']);
    $applno = trim($_POST['applno']);

    $facultyno = trim($_POST['facultyno']);
    $faculty = trim($_POST['faculty']);
    $course = trim($_POST['course']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $hostel = isset($_POST['yes_no']) ? $_POST['yes_no'] : "No";
    $hostelname = isset($_POST['hostelname']) ? trim($_POST['hostelname']) : "";
    $country = trim($_POST['country']);
    $address = trim($_POST['address']);

    // Insert the student details into the database
    $sql_insert = "INSERT INTO student_details (enroll, firstname, lastname, dob, fathername, applno, facultyno, faculty, course, email, phone, hostel, hostelname, country, address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    if ($stmt_insert) {
        mysqli_stmt_bind_param($stmt_insert, "sssssssssssssss", $enroll, $firstname, $lastname, $dob, $fathername, $applno, $facultyno, $faculty, $course, $email, $phone, $hostel, $hostelname, $country, $address);
        if (mysqli_stmt_execute($stmt_insert)) {
            // Redirect to another page after successful insertion
            header("location: upload-docs.html");
            exit; // Exit to prevent further execution
        } else {
            echo "Something went wrong... cannot redirect!";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt_insert);
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
</head>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="international-telephone-input.css" />
<script src="international-telephone-input.js"></script>
<script src="student-details.js"></script>
<style>

    body{
        font-family: "Poppins", sans-serif;
        min-height: 1000px;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
    }
    
    input[type=text],[type=radio],[type=email],[type=date],[type=tel],select{
        padding: 3px;
    }
    
    label{
    display:inline-block;
    width:200px;
    margin-right:30px;
    text-align:justify;
    }
    
    .grid{
    border:none;
    width:800px;
    margin:0px auto;
    line-height: 1.96;
    }
    
    .checkbox{
    text-align: justify;
    font-size: small;
    margin: 0;
    }
    
    .check:hover{
     cursor: pointer;
    }
    .check{
    display: inline;
    }
    
    .btnclass{
    text-align: right;
    }
    
    .lowerbtn {
      background-color: dodgerblue;
      border: none;
      color: black;
      padding: 10px;
      text-align: center;
      border-radius: 4px;
      font-size: 16px;
      margin: 4px 2px;
      transition: 0.3s;
    }
    
    .lowerbtn:hover {
      background-color: #3e8e41;
      color: white;
      cursor: pointer;
    }

    .error {
        color: red;
        font-size: 12px;
    }

</style>
    <body>
        <div class="container">
            <div class="header">
                <h2 id="heading">Please fill the following details:</h2>
            </div>
            <br>
            <div class="grid">
                <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="section">
                        <label for="firstname">First Name</label>
                            <input class="input" id="firstname" type="text" name="firstname">
                            <span class="error" id="firstname-error"></span>
                    </div>
                    <div class="section">
                        <label for="lastname">Last Name</label>
                            <input class="input" id="lastname" type="text" name="lastname">
                            <span class="error" id="lastname-error"></span>
                    </div>
                    <div class="section">
                        <label for="dob">Date of Birth</label>
                            <input class="input" id="dob" type="date" name="dob">
                            <span class="error" id="dob-error"></span>
                    </div>
                    <div class="section">
                        <label for="fathername">Father's Name</label>
                            <input class="input" id="fathername" type="text" name="fathername">
                            <span class="error" id="fathername-error"></span>
                    </div>
                    <div class="section">
                        <label for="applno">Application Number</label>
                        <input class="input" id="applno" type="text" placeholder="e.g. 123456" name="applno">
                        <span class="error" id="applno-error"></span>
                    </div>
                    <div class="section">
                        <label for="enroll">Enrollment Number</label>
                            <input class="input" id="enroll" type="text" placeholder="e.g. ABCD1234" name="enroll" value="<?php echo htmlspecialchars($enroll); ?>" readonly>
                            <span class="error" id="enroll-error"></span>
                    </div>
                    <div class="section">
                        <label for="facultyno">Faculty Roll Number</label>
                            <input class="input" id="facultyno" type="text" placeholder="e.g. 23XXXXX123" name="facultyno">
                            <span class="error" id="facultyno-error"></span>
                    </div>
                    <div class="section">
                        <label for="faculty">Faculty</label>
                            <select class="input" id="faculty" name="faculty">
                                <option value="select">Select</option>
                                <option value="F/O Science">Faculty of Science</option>
                                <option value="F/O Social Science">Faculty of Social Science</option>
                                <option value="F/O Commerce">Faculty of Commerce</option>
                                <option value="F/O Arts">Faculty of Arts</option>
                                <option value="F/O Theology">Faculty of Theology</option>
                            </select>
                            <span class="error" id="faculty-error"></span>
                    </div>
                    <div class="section">
                        <label for="course">Course</label>
                            <select class="input" id="course" name="course">
                                <option value="select">Select</option>
                                <option value="B.Sc.(Computer Applications)">B.Sc.(Computer Applications)</option>
                                <option value="B.Sc.(Mathematics)">B.Sc.(Mathematics)</option>
                                <option value="B.Sc.(Chemistry)">B.Sc.(Chemistry)</option>
                                <option value="B.Sc.(Physics)">B.Sc.(Physics)</option>
                                <option value="B.Sc.(Zoology)">B.Sc.(Zoology)</option>
                                <option value="B.Sc.(Botany)">B.Sc.(Botany)</option>
                                <option value="B.Sc.(Statistics)">B.Sc.(Statistics)</option>
                                <option value="B.A.(History)">B.A.(History)</option>
                                <option value="B.A.(English)">B.A.(English)</option>
                                <option value="B.A(Sunni Theology)">B.A(Sunni Theology)</option>
                                <option value="B.A(Shia theology)">B.A(Shia theology)</option>
                                <option value="B.A.(Hindi)">B.A.(Hindi)</option>
                                <option value="B.A(Economics)">B.A(Economics)</option>
                                <option value="B.Com. (Hons.)">B.Com. (Hons.)</option>
                                <option value="B.B.A.(Hons.)">B.B.A.(Hons.)</option>
                                <option value="B.Sc.(Geology)">B.Sc.(Geology)</option>
                                <option value="B.Sc.(Geography)">B.Sc.(Geography)</option>
                            </select> 
                            <span class="error" id="course-error"></span>   
                    </div>
                    <div class="section">
                        <label for="email">Email Id</label>
                            <input class="input" id="email" type="email" name="email">
                            <span class="error" id="email-error"></span>
                    </div>
                    <div class="section">
                        <label for="phone">Phone number</label>
                            <input class="input" id="phone" type="tel" name="phone">
                            <span class="error" id="phone-error"></span>
                    </div>
                    <div class="section">
                        <label for="hostel">Hostel Accommodation?</label>
                        <input type="radio" id="yes" name="yes_no" value="yes">Yes
                        <input type="radio" id="no" name="yes_no" value="no">No
                        <span class="error" id="hostel-error"></span>
                    </div>
                    <div class="section">
                        <label for="hostelname">Hostel (If Yes) </label>
                            <input class="input" id="hostelname" type="text" name="hostelname">
                    </div>
                    <div class="section">
                        <label for="country">Country</label>
                            <input class="input" id="country" type="text" name="country">
                            <span class="error" id="country-error"></span>
                    </div>
                    <div class="section">
                        <label for="address">Address</label>
                            <textarea id="address" row="10" cols="30" name="address"></textarea>
                            <span class="error" id="address-error"></span>
                    </div>
                    <br>
                    <span id="success-message" style="color: green;"></span>
                    <div class="checkbox">
                        <input type="checkbox" class="check" name="checkbox" id="agreeCheckbox">
                        <p class="check">I agree that all the above details provided by me are correct as per the documents.</p>
                    </div>
                    <br>
                    <div class="btnclass">
                        <button type="submit" id="savebtn" name="savebtn" class="lowerbtn">Save</button>
                        <button type="reset" id="resetbtn" class="lowerbtn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>
