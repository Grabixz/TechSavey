// This is the function that opens/closes the dropdown menu for categories in the navigation bar
function dropdownFunc() {
  var dropdown = document.getElementById("MyDropdown");
  if (dropdown) {
    dropdown.classList.toggle("show");
  }
}

// This event listener waits for the DOM to finish loading before executing its callback function
document.addEventListener("DOMContentLoaded", function() {
  // This event handler listens for clicks anywhere in the window
  window.onclick = function(event) {
    // If the clicked element is not the category button, then it closes any open dropdown menus
    if (!event.target.matches(".nav-butcategory")) {
      var dropdowns = document.getElementsByClassName("nav-dropinfo");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };
});

//This function gathers the buttons value and stores it in the localstorage for categories
function setButtonValue(value) {
  localStorage.setItem('buttonValue', value);
}

//This function is to retrieve the value of the cookie
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

//This function is to check if a cookie is present or not for the account
function checkaccCookie() {
  let userID = getCookie("userID");
  if (userID != undefined) {
    window.location.href = "account.php";
  } else {
    window.location.href = "lspage.php";
  }
}

//This function is to check if a cookie is present or not for the cart
function checkcartCookie(){
  let userID = getCookie("userID");
  if (userID != undefined) {
      window.location.href = "cartpage.php";
  } else {
      window.location.href = "lspage.php";
  }
}

//This is to delete the cookie when the user logs out
function deleteCookie(name) {
  document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
}