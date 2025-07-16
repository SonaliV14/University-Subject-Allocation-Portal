//for sliding login/signup buttons
function showSignup(){
    document.getElementById("signUp").style.display = "flex";
    document.getElementById("login").style.display = "none";
    document.getElementById("btns2").style.backgroundColor = "white";
    document.getElementById("btns1").style.backgroundColor = "#525953";
}
function showLogin(){
    document.getElementById("signUp").style.display = "none";
    document.getElementById("login").style.display = "flex";
    document.getElementById("btns1").style.backgroundColor = "white";
    document.getElementById("btns2").style.backgroundColor = "#525953";
}

//form validation for signup form

function validateForm() {
    var email = document.getElementById("emailSignup").value;
    var enrollment = document.getElementById("enrollSignup").value;
    var password = document.getElementById("passwordSignup").value;
    var emptyFieldsMessage = document.getElementById('emptyFieldsMessage');
    
    // Reset previous error messages
    emptyFieldsMessage.textContent = '';

    // Check if any field is empty
    if (email === "" || enrollment === "" || password === "") {
        emptyFieldsMessage.textContent = 'One or more fields are empty.';
        return false;
    }
     // Check enrollment number format
    var enrollmentRegex = /^[A-Z]{2}\d{4}$/;
    if (!enrollmentRegex.test(enrollment)) {
    emptyFieldsMessage.textContent = 'Enrollment number format is incorrect.';
    return false;
    }

    return true;
    }

    //form validation for login form

    function validateForm2() {
        var log_email = document.getElementById("emailLogin").value;
        var log_password = document.getElementById("passwordLogin").value;
        var emptyFieldsMessage2 = document.getElementById("emptyFieldsMessage2");
        
        // Reset previous error messages
        emptyFieldsMessage2.textContent = '';
    
        // Check if any field is empty
        if (log_email === "" || log_password === "") {
            emptyFieldsMessage2.textContent = 'One or more fields are empty.';
            return false;
        }

        return true;
    }

    // Reset form values and clear error messages on page refresh
    window.onload = function() {
    document.getElementById("signupForm").reset();
    document.getElementById("loginForm").reset();
    document.getElementById("emptyFieldsMessage").textContent = "";
    document.getElementById("emptyFieldsMessage2").textContent = "";
    document.getElementById("successMessage").textContent = "";
    document.getElementById("successMessage2").textContent = "";
    document.getElementById("loginErrorMessage").textContent = "";
}