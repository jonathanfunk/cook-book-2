<?php
use Cloudinary\Api\Upload\UploadApi;

session_start();
require_once('../includes/db.php');
require_once('../includes/functions.php');
require_once('../classes/Recipe.php');
require_once('../includes/cloudinary.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Instantiate Recipe object
$recipe = new Recipe($conn);

// Fetch recipe details by slug
$slug = $_GET['slug'];
$recipe_details = $recipe->getRecipeBySlug($slug);


// Check if recipe exists
if (!$recipe_details) {
    // Recipe not found
    echo "Recipe not found.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $recipe_id = $_POST['recipe_id'];
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $ingredients = implode("|", $_POST['ingredient']); // Convert array to comma-separated string
    $instructions = sanitize_input($_POST['instructions']);
    $category = sanitize_input($_POST['category']);

    $image_url = $recipe_details['image_url'];;
    if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
      $response = (new UploadApi())->upload($_FILES['image']['tmp_name']);
      $image_url = $response['secure_url'];
    }

    // Validate category
    $valid_categories = array("Breakfast", "Lunch", "Dinner", "Dessert");
    if (!in_array($category, $valid_categories)) {
        echo "Invalid category.";
        exit();
    }

    // Generate new slug from the updated title
    $updated_slug = $recipe->generateSlug($title);

    // Update recipe in the database
    if ($recipe->updateRecipe($recipe_id, $title, $description, $ingredients, $instructions, $category, $updated_slug, $image_url)) {
        // Recipe updated successfully, redirect user to the recipe details page
        header("Location: ../recipe.php?slug=" . urlencode($updated_slug));
        exit();
    } else {
        // Updating recipe failed, display error message
        echo "Error: Unable to update recipe.";
        exit();
    }
}
?>