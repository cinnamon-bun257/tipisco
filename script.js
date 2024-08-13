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

signupForm.addEventListener("submit", function (event) {
  event.preventDefault();
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
});

//LoginForm
var loginForm = document.getElementById("login-form");
var loginMessage = document.getElementById("login-message");

loginForm.addEventListener("submit", function (event) {
  event.preventDefault();
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
});

function userHovered() {
  var userImg = document.getElementById("user-button");
  if (userImg.style.display == "block") {
    // get elements
    var logoutButton = document.getElementById("logout-button");
    var accountButton = document.getElementById("switch-account");
    //shrink user button
    // userImg.classList.add("hovered");
    userImg.style.width = "35%";
    userImg.style.margin = "7.5% 32.5%";
    logoutButton.classList.remove("hidden");
    accountButton.classList.remove("hidden");
  }
}

function userNotHovered() {
  var userImg = document.getElementById("user-button");
  if (userImg.style.display == "block") {
    // get elements
    var logoutButton = document.getElementById("logout-button");
    var accountButton = document.getElementById("switch-account");
    //shrink user button

    userImg.style.width = "50%";
    userImg.style.margin = "25% 25%";
    logoutButton.classList.add("hidden");
    accountButton.classList.add("hidden");
  }
}

function logout() {
  window.location.href = "logout.php";
}

function bodyHeaderPressed(divname, odiv1, odiv2) {
  var div = document.getElementById(divname);
  if (div.classList.contains("expand")) {
    unexpand(divname, odiv1, odiv2);
  } else {
    expand(divname, odiv1, odiv2);
  }
}

function expand(divname, smalldiv1, smalldiv2) {
  var expandDiv = document.getElementById(divname);
  var smallDiv1 = document.getElementById(smalldiv1);
  var smallDiv2 = document.getElementById(smalldiv2);
  expandDiv.classList.add("expand");
  smallDiv1.classList.add("hide");
  smallDiv2.classList.add("hide");
}

function unexpand(divname, smalldiv1, smalldiv2) {
  var expandDiv = document.getElementById(divname);
  var smallDiv1 = document.getElementById(smalldiv1);
  var smallDiv2 = document.getElementById(smalldiv2);
  expandDiv.classList.remove("expand");
  smallDiv1.classList.remove("hide");
  smallDiv2.classList.remove("hide");
}
