<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');
require_once('../classes/Recipe.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Instantiate Recipe object
$recipe = new Recipe($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $user_id = $_SESSION['user_id'];

    if ($recipe->addRecipe($title, $description, $ingredients, $instructions, $user_id)) {
        // Recipe added successfully, redirect to homepage
        header("Location: ../index.php");
        exit();
    } else {
        // Adding recipe failed
        echo "Failed to add recipe.";
    }
}
?>