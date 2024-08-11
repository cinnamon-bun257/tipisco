// Get the modal
var loginModal = document.getElementById("login-modal");
var signupModal = document.getElementById("signup-modal");

function makeVisible(element) {
  element.style.display = "block";
}

function makeInvisible(element) {
  element.style.display = "none";
}

function loginButtonPressed() {
  makeVisible(loginModal);
}

function signupButtonPressed() {
  makeVisible(signupModal);
}

function closeModal() {
  makeInvisible(signupModal);
  makeInvisible(loginModal);
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == loginModal || event.target == signupModal) {
    closeModal();
  }
};

//Form submit
//  Signup form
var signupForm = document.getElementById("signup-form");
var signupMessage = document.getElementById("signup-message");
var userButton = document.getElementById("user-button");
// Get the buttons
var loginButton = document.getElementById("login-button");
var signupButton = document.getElementById("signup-button");
function submitSignup() {
  var formData = new FormData(signupForm);
  fetch("signup.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        signupForm.style.display = "none";
        signupMessage.innerHTML = "Signup successful!";
        loginButton.style.display = "none";
        signupButton.style.display = "none";
        userButton.style.display = "block";
      } else {
        signupMessage.innerHTML = "Signup failed: " + data.message;
      }
    })
    .catch((error) => {
      signupMessage.innerHTML = "An error occured: " + error.message;
    });
}

//LoginForm
var loginForm = document.getElementById("login-form");
var loginMessage = document.getElementById("login-message");

function submitLogin() {
  var formData = new FormData(loginForm);

  fetch("login.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        loginForm.style.display = "none";
        loginMessage.innerHTML = "Login successful!";
        loginButton.style.display = "none";
        signupButton.style.display = "none";
        userButton.style.display = "block";
      } else {
        loginMessage.innerHTML = "Login failed: " + data.message;
      }
    })
    .catch((error) => {
      loginMessage.innerHTML = "An error occured: " + error.message;
    });
}

function userHovered() {
  var userImg = document.getElementById("user-button");
  if (userImg.style.display == "block") return;
  // get elements
  var logoutButton = document.getElementById("logout-button");
  var accountButton = document.getElementById("account-button");
  //shrink user button

  userImg.style.margin = "10% 25%";
}

function userNotHovered() {
  var userImg = document.getElementById("user-button");
  if (userImg.style.display == "block") return;
  // get elements
  var logoutButton = document.getElementById("logout-button");
  var accountButton = document.getElementById("account-button");
  //shrink user button

  userImg.style.margin = "25% 25%";
  logoutButton.style.display = "block";
}
