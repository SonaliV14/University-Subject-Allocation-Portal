document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('form').addEventListener('submit', function (event) {
        // Reset error messages
        var errorElements = document.getElementsByClassName('error');
        for (var i = 0; i < errorElements.length; i++) {
            errorElements[i].innerText = '';
        }

        // Validate form fields
        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var dob = document.getElementById('dob').value;
        var fathername = document.getElementById('fathername').value;
        var applno = document.getElementById('applno').value;
        var enroll = document.getElementById('enroll').value;
        var facultyno = document.getElementById('facultyno').value;
        var faculty = document.getElementById('faculty').value;
        var course = document.getElementById('course').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        var agreeCheckbox = document.getElementById('agreeCheckbox').checked;

        var isValid = true;

        if (firstname === '') {
            document.getElementById('firstname-error').innerText = 'First Name is required';
            isValid = false;
        }

        if (lastname === '') {
            document.getElementById('lastname-error').innerText = 'Last Name is required';
            isValid = false;
        }

        if (dob === '') {
            document.getElementById('dob-error').innerText = 'Date of Birth is required';
            isValid = false;
        }

        if (fathername === '') {
            document.getElementById('fathername-error').innerText = "Father's Name is required";
            isValid = false;
        }

        if (applno === '') {
            document.getElementById('applno-error').innerText = 'Application Number is required';
            isValid = false;
        } else if (!/^\d{6}$/.test(applno)) {
            document.getElementById('applno-error').innerText = 'Application Number should be in the format 123456';
            isValid = false;
        }


        if (enroll === '') {
            document.getElementById('enroll-error').innerText = 'Enrollment Number is required';
            isValid = false;
        } else if (!/^[A-Z]{2}\d{4}$/.test(enroll)) {
            document.getElementById('enroll-error').innerText = 'Enrollment Number should be in the format XX1234';
            isValid = false;
        }

        if (facultyno === '') {
            document.getElementById('facultyno-error').innerText = 'Faculty Roll Number is required';
            isValid = false;
        } else if (!/^\d{2}[A-Z]{5}\d{3}$/.test(facultyno)) {
            document.getElementById('facultyno-error').innerText = 'Faculty Roll Number should be in the format 23XXXXX123';
            isValid = false;
        }

        if (faculty === 'select') {
            document.getElementById('faculty-error').innerText = 'Please select a Faculty';
            isValid = false;
        }

        if (course === 'select') {
            document.getElementById('course-error').innerText = 'Please select a Course';
            isValid = false;
        }

        if (email === '') {
            document.getElementById('email-error').innerText = 'Email Id is required';
            isValid = false;
        }

        if (phone === '') {
            document.getElementById('phone-error').innerText = 'Phone number is required';
            isValid = false;
        }

        if (!agreeCheckbox) {
            alert('Please agree to the terms and conditions');
            isValid = false;
        }

        // If form is not valid, prevent submission
        if (!isValid) {
            event.preventDefault();
        }
    });
});
