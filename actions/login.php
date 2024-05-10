<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');
require_once('../classes/User.php');

// Instantiate User object
$user = new User($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_xPOST['username'];
    $password = $_POST['password'];

    // Sanitize input
    $username = sanitize_input($username);
    $password = sanitize_input($password);

    // Attempt login
    if ($user->login($username, $password)) {
        // Login successful, redirect to home page
        header("Location: ../index.php");
        exit();
    } else {
        // Login failed, redirect back to login page with error message
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: ../login.php");
        exit();
    }
}
?>