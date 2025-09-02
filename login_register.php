<?php
session_start();
require_once 'config.php';

// ===== SIGNUP =====
if (isset($_POST['register'])) {
    $first_name    = $_POST['first_name'];
    $last_name     = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email         = $_POST['email'];
    $username      = $_POST['username'];
    $password      = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check email
    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered';
        $_SESSION['active_form'] = 'register';
    }
    // Check mobile number
    elseif ($checkMobile = $conn->query("SELECT mobile_number FROM users WHERE mobile_number = '$mobile_number'") and $checkMobile->num_rows > 0) {
        $_SESSION['register_error'] = 'Mobile number is already registered';
        $_SESSION['active_form'] = 'register';
    }
    // Check username
    elseif ($checkUsername = $conn->query("SELECT username FROM users WHERE username = '$username'") and $checkUsername->num_rows > 0) {
        $_SESSION['register_error'] = 'Username already exists, please use a different username';
        $_SESSION['active_form'] = 'register';
    }
    // Insert user
    else {
        $conn->query("INSERT INTO users (first_name, last_name, mobile_number, email, username, password) 
                      VALUES ('$first_name','$last_name','$mobile_number','$email','$username','$password')");
        header("Location: index.html");
        exit();
    }
}

// ===== LOGIN =====
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['first_name'] . " " . $user['last_name'];
            $_SESSION['username'] = $user['username'];

            if ($user['role'] === 'admin') {
                header("Location: admin_page.php");
            } else {
                header("Location: user_page.php");
            }
            exit();
        }
    }

    // Wrong login
    $_SESSION['login_error'] = 'Incorrect username or password';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}
?>
