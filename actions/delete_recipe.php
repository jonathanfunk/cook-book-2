<?php
session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');
require_once('../classes/Recipe.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check if recipe ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid request.";
    exit();
}

// Instantiate Recipe object
$recipe = new Recipe($conn);

// Delete recipe
$recipe_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($recipe->deleteRecipe($recipe_id, $user_id)) {
    // Recipe deleted successfully
    header("Location: ../index.php");
    exit();
} else {
    // Deletion failed
    echo "Failed to delete recipe.";
    exit();
}
?>