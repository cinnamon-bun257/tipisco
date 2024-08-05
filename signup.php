<?php 
session_start();
require 'config.php';

$response = [];

if($_SERVER["REQUEST-METHOD"]="POST"){
    $newname = mysqli_real_escape_string($conn, $_POST["name"]);
    $newfirstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $newusername = mysqli_real_escape_string($conn, $_POST["newusername"]);
    $newemail = mysqli_real_escape_string($conn, $_POST["newemail"]);
    $newpassword = password_hash($_POST["newpassword"], PASSWORD_BCRYPT);

    //check whether username already exists
    $sql = "SELECT * FROM users WHERE username='$newusername'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $response['success']= false;
        $response['message']= "Username already exists";
        echo json_encode($response);
        exit;
    }

    // check whether email is already in the database
    $sql = "SELECT * FROM users WHERE email='$newemail'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $response["success"]= false;
        $response["message"]= "Email already exists!";
        echo json_encode($response);
        exit;
    }

    // save user data in the database
    $sql = "INSERT INTO users (name, firstname, username, password, email) VALUES ('$newname', '$newfirstname', '$newusername', '$newpassword', '$newemail')";

    if(mysqli_query($conn, $sql)){
        $response["success"] = true;
        $response["message"] = "Signup successful!";
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['username'] = $newusername;
        $_SESSION['loggedin'] = true;
    }
    else{
        $response["success"] = false;
        $response["message"] = "Error: " . mysqli_error($conn);
    }
}
else{
    $response["success"] = false;
    $response["message"] = "Error: wrong request method";
}
echo json_encode($response);