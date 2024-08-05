document.addEventListener("DOMContentLoaded", function () {
  // Opening and closing Modal
  // Get the modal
  var loginModal = document.getElementById("login-modal");
  var signupModal = document.getElementById("signup-modal");
  // Get the buttons
  var loginButton = document.getElementById("login-button");
  var signupButton = document.getElementById("signup-button");
  // Get <span> that closes modal
  var closeLogin = document.getElementById("close-login");
  var closeSignup = document.getElementById("close-signup");

  loginButton.onclick = function () {
    loginModal.style.display = "block";
  };

  signupButton.onclick = function () {
    signupModal.style.display = "block";
  };

  closeLogin.onclick = function () {
    loginModal.style.display = "none";
  };

  closeSignup.onclick = function () {
    signupModal.style.display = "none";
  };

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == loginModal) {
      loginModal.style.display = "none";
    }
    if (event.target == signupModal) {
      signupModal.style.display = "none";
    }
  };

  //Form submit
  //  Signup form
  var signupForm = document.getElementById("signup-form");
  var signupMessage = document.getElementById("signup-message");
  var userButton = document.getElementById("user-button");

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
          loginMessage.innerHTML = "Signup successful!";
          loginButton.style.display = "none";
          signupButton.style.display = "none";
          userButton.style.display = "block";
        } else {
          loginMessage.innerHTML = "Signup failed: " + data.message;
        }
      })
      .catch((error) => {
        loginMessage.innerHTML = "An error occured: " + error.message;
      });
  });
});
