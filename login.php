<?php 
session_start();
require 'config.php';

// Set response header to JSON
header('Content-Type: application/json');

// Initialize response array
$response = [
    "success" => false,
    "message" => "An unknown error occurred."
];

// ini_set('display_errors', 0);
// ini_set('log_errors', 1);
// ini_set('error_log', 'error.log');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = mysqli_real_escape_string($conn, $_POST['email/username']);
    $password = $_POST['password'];

    $sql= "SELECT * FROM users WHERE username = '$usernameOrEmail'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        $sql= "SELECT * FROM  users WHERE email = '$usernameOrEmail'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $response["success"] = false;
            $response["message"] = "Username/Email doesn't exist";
            echo json_encode( $response );
            exit;
        }else {
            // User found by email, handle login
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['uid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['loggedin'] = true;
                $response["success"] = true;
                $response["message"] = "Login successful!";
            } else {
                $response["success"] = false;
                $response["message"] = "Invalid password.";
            }
        }
    } else {
        // User found by username, handle login
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['uid'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['loggedin'] = true;
            $response["success"] = true;
            $response["message"] = "Login successful!";
        } else {
            $response["success"] = false;
            $response["message"] = "Invalid password.";
        }
    }
}
echo json_encode( $response );