<?php

session_start();
require_once('includes/db.php');
require_once('includes/functions.php');
require_once('classes/Recipe.php');

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

// Prepopulate form fields with current recipe details
$recipe_id = $recipe_details['id'];
$title = $recipe_details['title'];
$description = $recipe_details['description'];
$ingredients = $recipe_details['ingredients'];
$instructions = stripcslashes($recipe_details['instructions']);
$category = $recipe_details['category'];
?>

<?php include 'inc/header.php';?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Edit Recipe</div>
        <div class="card-body">
          <form action="actions/edit_recipe.php?slug=<?php echo $slug; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"
                required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
              <label for="ingredients">Ingredients</label>
              <div id="ingredientInputs">
                <?php
                $ingredient_list = explode(",", $ingredients);
                foreach ($ingredient_list as $ingredient) {
                ?>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" name="ingredient[]" value="<?php echo $ingredient; ?>"
                    required>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-ingredient">Remove</button>
                  </div>
                </div>
                <?php
                }
                ?>
              </div>
              <button type="button" class="btn btn-primary btn-sm" id="addIngredient">Add Ingredient</button>
            </div>
            <div class="form-group">
              <label for="instructions">Instructions</label>
              <textarea class="form-control" id="instructions" name="instructions" rows="5"
                required><?php echo $instructions ?></textarea>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="Breakfast" <?php if($category == "Breakfast") echo "selected"; ?>>Breakfast</option>
                <option value="Lunch" <?php if($category == "Lunch") echo "selected"; ?>>Lunch</option>
                <option value="Dinner" <?php if($category == "Dinner") echo "selected"; ?>>Dinner</option>
                <option value="Dessert" <?php if($category == "Dessert") echo "selected"; ?>>Dessert</option>
              </select>
            </div>
            <div class="form-group">
              <label for="image">Recipe Image</label>
              <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Update Recipe</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $footer_scripts = '<script src="js/ingredient-inputs.js"></script>';?>
<?php include 'inc/footer.php';?>