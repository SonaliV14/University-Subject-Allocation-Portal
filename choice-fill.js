document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');
    const saveBtn = document.getElementById('savebtn');
    const checkbox = document.getElementById('agreeCheckbox');
    
    saveBtn.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission
        
        const selects = document.querySelectorAll('select');
        let isError = false;
        
        // Check if any select element is not selected
        selects.forEach(select => {
            if (select.value === 'select') {
                showError(select, 'Please choose a subject');
                isError = true;
            } else {
                removeError(select);
            }
        });
        
        // Check if checkbox is checked
        if (!checkbox.checked) {
            alert('Please check the self-decalaration');
            isError = true;
        }
        
        // If no error, submit the form
        if (!isError) {
            form.submit();
        }
    });
    
    // Add event listeners to select elements to remove error on selection
    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            removeError(select);
        });
    });
    
    // Function to show error message
    function showError(element, message) {
        const errorDiv = document.createElement('div');
        errorDiv.classList.add('error-message');
        errorDiv.textContent = message;
        
        const errorContainer = element.nextElementSibling; // Get the next sibling which is the error container
        errorContainer.appendChild(errorDiv);
    }
    
    // Function to remove error message
    function removeError(element) {
        const errorContainer = element.nextElementSibling; // Get the next sibling which is the error container
        const errorDiv = errorContainer.querySelector('.error-message');
        
        if (errorDiv) {
            errorDiv.remove();
        }
    }
});
