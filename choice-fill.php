<?php
require_once "config.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: first_page.php");
    exit;
}

// Initialize variables
$success_message = "";

// Retrieve enrollment number from session
$enrollment_no = $_SESSION["enrollment_no"];

// Check if subject preferences are already submitted for this enrollment number
$sql_check = "SELECT * FROM subjects WHERE enrollment_no = ?";
if ($stmt_check = mysqli_prepare($conn, $sql_check)) {
    mysqli_stmt_bind_param($stmt_check, "s", $enrollment_no);
    if (mysqli_stmt_execute($stmt_check)) {
        mysqli_stmt_store_result($stmt_check);
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            // Subject preferences already submitted for this enrollment number
            $already_submitted_message = "Your choices are already submitted. The changes made by you will not get saved !.";
        }
    } else {
        echo "Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt_check);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"&& empty($already_submitted_message)) {
    // Prepare an SQL statement to insert or update subject choices
    $sql = "INSERT INTO subjects (enrollment_no, Minor_pref_1, Minor_pref_2, Generic_pref_1, Generic_pref_2, VAC_1, VAC_2, VOC_1, VOC_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssssss", $enrollment_no, $param_minor1, $param_minor2, $param_generic1, $param_generic2, $param_vac1, $param_vac2, $param_voc1, $param_voc2);

        // Set parameters
        $param_minor1 = $_POST["minor1"];
        $param_minor2 = $_POST["minor2"];
        $param_generic1 = $_POST["generic1"];
        $param_generic2 = $_POST["generic2"];
        $param_vac1 = $_POST["vac1"];
        $param_vac2 = $_POST["vac2"];
        $param_voc1 = $_POST["voc1"];
        $param_voc2 = $_POST["voc2"];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Your choices are saved successfully.";
        } else {
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Subject Selection</title>
   <style>
      body {
         font-family: Arial, sans-serif;
      }

      .container {
         display: flex;
         flex-direction: column;
         align-items: flex-start;
         margin-top: 50px;
         scroll-behavior: smooth;
      }

      select {
         margin-bottom: 20px;
         padding: 5px;
         font-size: 16px;
         margin-right: 50px;
      }

      .checkbox {
         text-align: justify;
         font-size: small;
         margin: 40px;
      }

      .check:hover {
         cursor: pointer;
      }

      .check {
         display: inline;
      }

      .btnclass {
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

      .error-container{
         position: relative;
      }
      .error-message {
         color: red;
         font-size: 14px;
         margin-top: 5px;
         position: absolute;
         bottom: -30px;
         left: -220px;
      }
      .success-message{
         color: green;
         font-size: medium;
         margin-left: 30px;
         margin-bottom: 10px;
      }
   </style>
</head>

<body>
   <div class="container">
      <form id ="subjectForm" action="#" method="post">
         <div class="section">
            <h3>Choose the Minor subject:</h3><br>
            <label for="minor1">Preference 1:</label>
            <select class="input" id="minor1" name="minor1">
               <option value="select">Select</option>
               <option value="Commerce">Commerce</option>
               <option value="Bio-Chemistry">Bio-Chemistry</option>
               <option value="Zoology">Zoology</option>
               <option value="Botany">Botany</option>
               <option value="Arabic">Arabic</option>
               <option value="English">English</option>
               <option value="Hindi">Hindi</option>
               <option value="Linguistics">Linguistics</option>
               <option value="Persian">Persian</option>
               <option value="Philosophy">Philosophy</option>
               <option value="Sanskrit">Sanskrit</option>
               <option value="Urdu">Urdu</option>
               <option value="Women Studies">Women Studies</option>
               <option value="Economics">Economics</option>
               <option value="Education">Education</option>
               <option value="History">History</option>
               <option value="Islamic Studies">Islamic Studies</option>
               <option value="Psycology">Psycology</option>
               <option value="Political Science">Political Science</option>
               <option value="Geography">Geography</option>
               <option value="History">History</option>
               <option value="Statistics">Statistics</option>
               <option value="Mathematics">Mathematics</option>
               <option value="Computer Applications">Computer Applications</option>
               <option value="Physics">Physics</option>
               <option value="Industrial Chemistry">Industrial Chemistry</option>
               <option value="Geology">Geology</option>
               <option value="Sociology">Sociology</option>
               <option value="Sunni Theology">Sunni Theology</option>
               <option value="Shia Theology">Shia Theology</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
            <label for="minor2">Preference 2:</label>
            <select class="input" id="minor2" name="minor2">
               <option value="select">Select</option>
               <option value="Commerce">Commerce</option>
               <option value="Bio-Chemistry">Bio-Chemistry</option>
               <option value="Zoology">Zoology</option>
               <option value="Botany">Botany</option>
               <option value="Arabic">Arabic</option>
               <option value="English">English</option>
               <option value="Hindi">Hindi</option>
               <option value="Linguistics">Linguistics</option>
               <option value="Persian">Persian</option>
               <option value="Philosophy">Philosophy</option>
               <option value="Sanskrit">Sanskrit</option>
               <option value="Urdu">Urdu</option>
               <option value="Women Studies">Women Studies</option>
               <option value="Economics">Economics</option>
               <option value="Education">Education</option>
               <option value="History">History</option>
               <option value="Islamic Studies">Islamic Studies</option>
               <option value="Psycology">Psycology</option>
               <option value="Political Science">Political Science</option>
               <option value="Geography">Geography</option>
               <option value="History">History</option>
               <option value="Statistics">Statistics</option>
               <option value="Mathematics">Mathematics</option>
               <option value="Computer Applications">Computer Applications</option>
               <option value="Physics">Physics</option>
               <option value="Industrial Chemistry">Industrial Chemistry</option>
               <option value="Geology">Geology</option>
               <option value="Sociology">Sociology</option>
               <option value="Sunni Theology">Sunni Theology</option>
               <option value="Shia Theology">Shia Theology</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
         </div>
         <div class="section">
            <h3>Choose the Generic subject:</h3><br>
            <label for="generic1">Preference 1:</label>
            <select class="input" id="generic1" name="generic1">
               <option value="select">Select</option>
               <option value="Commerce">Commerce</option>
               <option value="Bio-Chemistry">Bio-Chemistry</option>
               <option value="Zoology">Zoology</option>
               <option value="Botany">Botany</option>
               <option value="Arabic">Arabic</option>
               <option value="English">English</option>
               <option value="Hindi">Hindi</option>
               <option value="Linguistics">Linguistics</option>
               <option value="Persian">Persian</option>
               <option value="Philosophy">Philosophy</option>
               <option value="Sanskrit">Sanskrit</option>
               <option value="Urdu">Urdu</option>
               <option value="Women Studies">Women Studies</option>
               <option value="Economics">Economics</option>
               <option value="Education">Education</option>
               <option value="History">History</option>
               <option value="Islamic Studies">Islamic Studies</option>
               <option value="Psycology">Psycology</option>
               <option value="Political Science">Political Science</option>
               <option value="Geography">Geography</option>
               <option value="History">History</option>
               <option value="Statistics">Statistics</option>
               <option value="Mathematics">Mathematics</option>
               <option value="Computer Applications">Computer Applications</option>
               <option value="Physics">Physics</option>
               <option value="Industrial Chemistry">Industrial Chemistry</option>
               <option value="Geology">Geology</option>
               <option value="Sociology">Sociology</option>
               <option value="Sunni Theology">Sunni Theology</option>
               <option value="Shia Theology">Shia Theology</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
            <label for="generic2">Preference 2:</label>
            <select class="input" id="generic2" name="generic2">
               <option value="select">Select</option>
               <option value="Commerce">Commerce</option>
               <option value="Bio-Chemistry">Bio-Chemistry</option>
               <option value="Zoology">Zoology</option>
               <option value="Botany">Botany</option>
               <option value="Arabic">Arabic</option>
               <option value="English">English</option>
               <option value="Hindi">Hindi</option>
               <option value="Linguistics">Linguistics</option>
               <option value="Persian">Persian</option>
               <option value="Philosophy">Philosophy</option>
               <option value="Sanskrit">Sanskrit</option>
               <option value="Urdu">Urdu</option>
               <option value="Women Studies">Women Studies</option>
               <option value="Economics">Economics</option>
               <option value="Education">Education</option>
               <option value="History">History</option>
               <option value="Islamic Studies">Islamic Studies</option>
               <option value="Psycology">Psycology</option>
               <option value="Political Science">Political Science</option>
               <option value="Geography">Geography</option>
               <option value="History">History</option>
               <option value="Statistics">Statistics</option>
               <option value="Mathematics">Mathematics</option>
               <option value="Computer Applications">Computer Applications</option>
               <option value="Physics">Physics</option>
               <option value="Industrial Chemistry">Industrial Chemistry</option>
               <option value="Geology">Geology</option>
               <option value="Sociology">Sociology</option>
               <option value="Sunni Theology">Sunni Theology</option>
               <option value="Shia Theology">Shia Theology</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
         </div>
         <div class="section">
            <h3>Choose the VOC subjects:</h3><br>
            <label for="voc1">VOC I:</label>
            <select class="input" id="voc1" name="voc1">
               <option value="select">Select</option>
               <option value="Communication Skills and verbal Ability">Communication Skills and Verbal Ability</option>
               <option value="Noting and Drafting (English)">Noting and Drafting (English)</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
            <label for="voc2">VOC II:</label>
            <select class="input" id="voc2" name ="voc2">
               <option value="select">Select</option>
               <option value="Fundamentals of IT">Fundamentals of IT</option>
               <option value="ICT in Business">ICT in Business</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
         </div>
         <div class="section">
            <h3>Choose the VAC subjects:</h3><br>
            <label for="vac1">VAC I:</label>
            <select class="input" id="vac1" name="vac1">
               <option value="select">Select</option>
               <option value="Urdu">Urdu</option>
               <option value="Hindi">Hindi</option>
               <option value="MIL(Kashmiri)">MIL(Kashmiri)</option>
               <option value="MIL(Punjabi)">MIL(Punjabi)</option>
               <option value="MIL(Marathi)">MIL(Marathi)</option>
               <option value="MIL(Telugu)">MIL(Telugu)</option>
               <option value="MIL(Tamil)">MIL(Tamil)</option>
               <option value="MIL(Malyalam)">MIL(Malyalam)</option>
               <option value="MIL(Bengali)">MIL(Bengali)</option>
               <option value="Sunni Theology">Sunni Theology</option>
               <option value="Shia Theology">Shia Theology</option>
               <option value="Aligarh Movement">Aligarh Movement</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
            <label for="vac2">VAC II:</label>
            <select class="input" id="vac2" name="vac2">
               <option value="select">Select</option>
               <option value="Urdu">Urdu</option>
               <option value="Hindi">Hindi</option>
               <option value="MIL(Kashmiri)">MIL(Kashmiri)</option>
               <option value="MIL(Punjabi)">MIL(Punjabi)</option>
               <option value="MIL(Marathi)">MIL(Marathi)</option>
               <option value="MIL(Telugu)">MIL(Telugu)</option>
               <option value="MIL(Tamil)">MIL(Tamil)</option>
               <option value="MIL(Malyalam)">MIL(Malyalam)</option>
               <option value="MIL(Bengali)">MIL(Bengali)</option>
               <option value="Sunni Theology">Sunni Theology</option>
               <option value="Shia Theology">Shia Theology</option>
               <option value="Aligarh Movement">Aligarh Movement</option>
            </select>
            <span class="error-container"></span>  <!--Error container box-->
         </div>
         <?php if (!empty($success_message)) : ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($already_submitted_message)) : ?>
            <p class="success-message"><?php echo $already_submitted_message; ?></p>
        <?php endif; ?>
         <div class="checkbox" id="checkbox">
                <input type="checkbox" class="check" name="checkbox" id="agreeCheckbox">
                <p class="check">I, solemnly declare my unwavering commitment to the subjects I have chosen. I understand
                    and agree that the subjects I have chosen are final and cannot be edited further.</p>
               <span class="error-container"></span>  <!--Error container box-->
         </div>
         <div class="btnclass">
            <button type="submit" id="savebtn" name="savebtn" class="lowerbtn">Save</button>
            <button type="reset" id="resetbtn" class="lowerbtn">Reset</button>
         </div>
      </form>
   </div>

   <script src="choice-fill.js"></script>
</body>

</html>

