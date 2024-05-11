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
        // Login successful, retrieve user ID from the database
        $user_id = $user->getUserIdByUsername($username); // Assuming you have a method to retrieve user ID by username
        if ($user_id) {
            $_SESSION['user_id'] = $user_id;
            header("Location: ../index.php");
            exit();
        } else {
            // User ID not found, handle error
            echo "Error: Unable to retrieve user ID.";
            exit();
        }
    } else {
        // Login failed, redirect back to login page with error message
        header("Location: ../login.php?error=invalid");
        exit();
    }
}
?>