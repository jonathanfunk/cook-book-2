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

// Handle form submission or link click
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $recipe_id = $_GET['recipe_id']; // Assuming recipe_id is passed via URL

    // Assuming you have a function to check if the recipe belongs to the logged-in user
    if ($recipe->deleteRecipe($recipe_id)) {
        // Recipe deleted successfully, redirect to homepage
        header("Location: ../index.php");
        exit();
    } else {
        // Deleting recipe failed
        echo "Failed to delete recipe.";
    }
}
?>