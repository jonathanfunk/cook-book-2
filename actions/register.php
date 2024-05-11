<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');
require_once('../classes/User.php');

// Instantiate User object
$user = new User($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username is already in use
    if ($user->isUsernameTaken($username)) {
        header("Location: ../register.php?error=username_taken");
        exit();
    }

    // Check if email is already in use
    if ($user->isEmailTaken($email)) {
        header("Location: ../register.php?error=email_taken");
        exit();
    }

    // Attempt to register user
    if ($user->register($username, $email, $password)) {
        // Registration successful, now log in the user
        if ($user->login($username, $password)) {
            // Login successful, set session and redirect to homepage
            $_SESSION['user_id'] = $user->getUserIdByUsername($username);
            header("Location: ../index.php");
            exit();
        } else {
            // Login failed, handle error
            echo "Error: Unable to log in the user after registration.";
            exit();
        }
    } else {
        // Registration failed, handle error
        echo "Error: Unable to register the user.";
        exit();
    }
}
?>