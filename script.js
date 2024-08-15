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

//Array ( [get] => fixtures [parameters] => Array ( [team] => 160 [from] => 2024-08-15 [to] => 2025-06-30 [season] => 2024 ) [errors] => Array ( ) [results] => 35 [paging] => Array ( [current] => 1 [total] => 1 ) [response] => Array ( [0] => Array ( [fixture] => Array ( [id] => 1202389 [referee] => [timezone] => UTC [date] => 2024-08-17T13:30:00+00:00 [timestamp] => 1723901400 [periods] => Array ( [first] => [second] => ) [venue] => Array ( [id] => 735 [name] => Bremer Brücke [city] => Osnabrück ) [status] => Array ( [long] => Not Started [short] => NS [elapsed] => ) ) [league] => Array ( [id] => 81 [name] => DFB Pokal [country] => Germany [logo] => https://media.api-sports.io/football/leagues/81.png [flag] => https://media.api-sports.io/flags/de.svg [season] => 2024 [round] => 1st Round ) [teams] => Array ( [home] => Array ( [id] => 1324 [name] => VfL Osnabruck [logo] => https://media.api-sports.io/football/teams/1324.png [winner] => ) [away] => Array ( [id] => 160 [name] => SC Freiburg [logo] => https://media.api-sports.io/football/teams/160.png [winner] => ) ) [goals] => Array ( [home] => [away] => ) [score] => Array ( [halftime] => Array ( [home] => [away] => ) [fulltime] => Array ( [home] => [away] => ) [extratime] => Array ( [home] => [away] => ) [penalty] => Array ( [home] => [away] => ) ) ) [1] => Array ( [fixture] => Array ( [id] => 1223979 [referee] => [timezone] => UTC [date] => 2024-08-24T13:30:00+00:00 [timestamp] => 1724506200 [periods] => Array ( [first] => [second] => ) [venue] => Array ( [id] => 12717 [name] => Europa-Park Stadion [city] => Freiburg im Breisgau ) [status] => Array ( [long] => Not Started [short] => NS [elapsed] => ) ) [league] => Array ( [id] => 78 [name] => Bundesliga [country] => Germany [logo] => https://media.api-sports.io/football/leagues/78.png [flag] => https://media.api-sports.io/flags/de.svg [season] => 2024 [round] => Regular Season - 1 ) [teams] => Array ( [home] => Array ( [id] => 160 [name] => SC Freiburg [logo] => https://media.api-sports.io/football/teams/160.png [winner] => ) [away] => Array ( [id] => 172 [name] => VfB Stuttgart [logo] => https://media.api-sports.io/football/teams/172.png [winner] => ) ) [goals] => Array ( [home] => [away] => ) [score] => Array ( [halftime] => Array ( [home] => [away] => ) [fulltime] => Array ( [home] => [away] => ) [extratime] => Array ( [home] => [away] => ) [penalty] => Array ( [home] => [away] => ) ) ) [2] => Array ( [fixture] => Array ( [id] => 1223986 [referee] => [timezone] => UTC [date] => 2024-09-01T15:30:00+00:00 [timestamp] => 1725204600 [periods] => Array ( [first] => [second] => ) [venue] => Array ( [id] => 700 [name] => Allianz Arena [city] => München ) [status] => Array ( [long] => Not Started [short] => NS [elapsed] => ) ) [league] => Array ( [id] => 78 [name] => Bundesliga [country] => Germany [logo] => https://media.api-sports.io/football/leagues/78.png [flag] => https://media.api-sports.io/flags/de.svg [season] => 2024 [round] => Regular Season - 2 ) [teams] => Array ( [home] => Array ( [id] => 157 [name] => Bayern Munich [logo] => https://media.api-sports.io/football/teams/157.png [winner] => ) [away] => Array ( [id] => 160 [name] => SC Freiburg [logo] => https://media.api-sports.io/football/teams/160.png [winner] => ) ) [goals] => Array ( [home] => [away] => ) [score] => Array ( [halftime] => Array ( [home] => [away] => ) [fulltime] => Array ( [home] => [away] => ) [extratime] => Array ( [home] => [away] => ) [penalty] => Array ( [home] => [away] => ) ) ) ) ) )
