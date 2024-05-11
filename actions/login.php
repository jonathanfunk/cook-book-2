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
    $password = $_POST['password'];
    $username = sanitize_input($username);

    // Attempt login
    $login_result = $user->login($username, $password);
    
    if ($login_result === true) {
        // Login successful, redirect to home page
        header("Location: ../index.php");
        exit();
    } else {
        // Login failed, redirect back to login page with specific error message
        $_SESSION['login_error'] = $login_result;
        header("Location: ../login.php");
        exit();
    }
}
?>