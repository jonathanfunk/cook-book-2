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
    $recipe_id = $_POST['recipe_id']; // Assuming recipe_id is passed from form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    // Assuming you have a function to check if the recipe belongs to the logged-in user
    if ($recipe->editRecipe($recipe_id, $title, $description, $ingredients, $instructions)) {
        // Recipe updated successfully, redirect to homepage or recipe detail page
        header("Location: ../index.php");
        exit();
    } else {
        // Updating recipe failed
        echo "Failed to update recipe.";
    }
}
?>