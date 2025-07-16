<?php
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <!-- Include any necessary stylesheets -->
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
        *{
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif'
        }

        body{
            overflow-y: auto;
        }

        .table-container {
            width: 100%;
            max-height: 80vh;
            overflow: auto;
        }

        table {
            border-collapse: collapse;
            width: 110% ; /* Set width to auto to allow horizontal scrolling */
            font-size: 15px;
            margin: 0 auto;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
            width: calc(140% / 15); /* Equal-width columns: 15 columns */
        }

        th {
            background-color: #f2f2f2;
        }

        .editable {
            background-color: #f3f3f3;
        }

        .edit-save-btn {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Below is the detailed information of students-</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Enrollment No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Father's Name</th>
                    <th>Application Number</th>
                    <th>Faculty Roll Number</th>
                    <th>Faculty</th>
                    <th>Course</th>
                    <th>E-mail</th>
                    <th>Phone Number</th>
                    <th>Hostel Accomodation</th>
                    <th>Hostel Name</th>
                    <th>Country</th>
                    <th>Address</th>
                    <!-- Add columns for uploaded documents -->
                    <th>Photo</th>
                    <th>Signature</th>
                    <th>Admission Card</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch student details along with uploaded documents
                $sql_fetch_students = "SELECT s.*, d.photo, d.signature, d.admission_card FROM student_details s LEFT JOIN documents d ON s.enroll = d.enrollment_no";
                $result_students = $conn->query($sql_fetch_students);
                $sno = 1;
                // Display student details in table rows
                while ($row_students = $result_students->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$sno</td>";
                    echo "<td>{$row_students['enroll']}</td>";
                    echo "<td>{$row_students['firstname']}</td>";
                    echo "<td>{$row_students['lastname']}</td>";
                    echo "<td>{$row_students['dob']}</td>";
                    echo "<td>{$row_students['fathername']}</td>";
                    echo "<td>{$row_students['applno']}</td>";
                    echo "<td>{$row_students['facultyno']}</td>";
                    echo "<td>{$row_students['faculty']}</td>";
                    echo "<td>{$row_students['course']}</td>";
                    echo "<td>{$row_students['email']}</td>";
                    echo "<td>{$row_students['phone']}</td>";
                    echo "<td>{$row_students['hostel']}</td>";
                    echo "<td>{$row_students['hostelname']}</td>";
                    echo "<td>{$row_students['country']}</td>";
                    echo "<td>{$row_students['address']}</td>";
                    // Display links to uploaded documents if available
                    echo "<td><a href='{$row_students['photo']}' target='_blank'>Photo</a></td>";
                    echo "<td><a href='{$row_students['signature']}' target='_blank'>Signature</a></td>";
                    echo "<td><a href='{$row_students['admission_card']}' target='_blank'>Admission Card</a></td>";
                    echo "</tr>";
                    $sno++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>