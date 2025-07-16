let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");
closeBtn.addEventListener("click", () => {
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});
searchBtn.addEventListener("click", () => {
  // Sidebar open when you click on the search icon
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});
// following are the code to change sidebar button(optional)
function menuBtnChange() {
  if (sidebar.classList.contains("open")) {
    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the icons class
  } else {
    closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the icons class
  }
}

//function to open the page of respective icon
function openPage(pageUrl) {
  document.getElementById('pageContent').src = pageUrl;
}

//function to start loader during logout
function startLoaderAndRedirect() {
      // Show loader immediately
      document.getElementById('loading-spinner').style.display = 'block';

      // Redirect to first_page after 2 seconds
      setTimeout(function() {
        window.location.href = 'first_page.php';
      }, 2000);
    }

function cancelLogout() {
  // Hide the confirmation modal
  document.getElementById('confirmation-modal').style.display = 'none';
}

function showConfirmation() {
  // Display the confirmation modal
  document.getElementById('confirmation-modal').style.display = 'block';
}

// Listen for the back button click event
window.addEventListener('popstate', function(event) {
  // Show the confirmation modal when the user clicks the back button
  if (event.state && event.state.fromDashboard) {
      showConfirmation();
  }
});


 // Function to adjust the height of the iframe based on its content
 function adjustIframeHeight() {
  var iframe = document.getElementById('pageContent');
  if (iframe) {
      iframe.onload = function() {
          var height = iframe.contentWindow.document.body.scrollHeight;
          iframe.style.height = height + 'px';
      };
  }
}

// Call the adjustIframeHeight function when the iframe content is loaded
window.onload = adjustIframeHeight;