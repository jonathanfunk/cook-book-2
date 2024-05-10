<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');
require_once('../classes/User.php');

// Instantiate User object
$user = new User($conn);

$errors = array(); // Array to store error messages

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    if (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    // Check if username already exists
    if ($user->usernameExists($username)) {
        $errors['username'] = "Username already exists. Please choose a different username.";
    }

    // Check if email already exists
    if ($user->emailExists($email)) {
        $errors['email'] = "Email already exists. Please use a different email address.";
    }

    if (empty($errors)) {
        // Sanitize input
        $username = sanitize_input($username);
        $email = sanitize_input($email);
        $password = hash_password(sanitize_input($password));

        // Insert user into database
        if ($user->register($username, $email, $password)) {
            // Registration successful, redirect to login page
            header("Location: ../login.php");
            exit();
        } else {
            $errors['general'] = "Failed to register user.";
        }
    }
}

// Pass errors to the registration form
$_SESSION['register_errors'] = $errors;
header("Location: ../register.php"); // Redirect back to the registration form
exit();
?>