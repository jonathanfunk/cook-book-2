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

// Instantiate Recipe object
$recipe = new Recipe($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize input
  $title = sanitize_input($_POST['title']);
  $description = sanitize_input($_POST['description']);
  $ingredients = sanitize_input($_POST['ingredients']);
  $instructions = sanitize_input($_POST['instructions']);
  $category = sanitize_input($_POST['category']);

  // Validate category
  $valid_categories = array("Breakfast", "Lunch", "Dinner", "Dessert");
  if (!in_array($category, $valid_categories)) {
      echo "Invalid category.";
      exit();
  }

  // Add recipe to the database
  if ($recipe->addRecipe($title, $description, $ingredients, $instructions, $_SESSION['user_id'], $category)) {
      // Recipe added successfully, get the slug of the newly created recipe
      $new_recipe_slug = $recipe->generateSlug($title);

      // Redirect user to the new recipe page
      header("Location: ../recipe.php?slug=$new_recipe_slug");
      exit();
  } else {
      // Adding recipe failed, display error message
      echo "Error: Unable to add recipe.";
      exit();
  }
}
?>