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

    if ($user->login($username, $password)) {
        // Login successful, redirect to homepage
        header("Location: ../index.php");
        exit();
    } else {
        // Login failed
        echo "Invalid username or password.";
    }
}
?>