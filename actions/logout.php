<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');
require_once('../classes/User.php');

// Instantiate User object
$user = new User($conn);

// Logout user
$user->logout();

// Redirect to homepage
header("Location: ../index.php");
exit();
?>