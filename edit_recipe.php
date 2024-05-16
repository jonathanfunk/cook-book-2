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
<section class="section bg-light flex-grow-1">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow form-card">
          <div class="card-body">
            <h1>Edit Recipe</h1>
            <form action="actions/edit_recipe.php?slug=<?php echo $slug; ?>" method="POST"
              enctype="multipart/form-data">
              <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
              <div class="mb-3 form-floating">
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>"
                  placeholder="Chicken Nuggets" required>
                <label for="title">Title</label>
              </div>
              <div class="mb-3 form-floating">
                <textarea class="form-control" id="description" name="description" rows="3"
                  placeholder="Recipe description" required><?php echo $description; ?></textarea>
                <label for="description">Description</label>
              </div>
              <div class="mb-3">
                <label class="form-label" for="ingredients">Ingredients</label>
                <div id="ingredientInputs">
                  <?php
                $ingredient_list = explode(",", $ingredients);
                foreach ($ingredient_list as $ingredient) {
                ?>
                  <div class="input-group mb-2">
                    <input type="text" class="form-control" name="ingredient[]" value="<?php echo $ingredient; ?>"
                      required>
                    <div class="input-group-append">
                      <button type="button" class="btn btn-sm btn-danger remove-ingredient">Remove</button>
                    </div>
                  </div>
                  <?php
                }
                ?>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="addIngredient">Add Ingredient</button>
              </div>
              <div class="mb-3 form-floating">
                <textarea class="form-control" id="instructions" name="instructions" rows="5"
                  placeholder="Set of instructions"><?php echo $instructions ?></textarea>
                <label for="instructions">Instructions</label>
              </div>
              <div class="mb-3 form-floating">
                <select class="form-control" id="category" name="category" required>
                  <option value="">Select Category</option>
                  <option value="Breakfast" <?php if($category == "Breakfast") echo "selected"; ?>>Breakfast</option>
                  <option value="Lunch" <?php if($category == "Lunch") echo "selected"; ?>>Lunch</option>
                  <option value="Dinner" <?php if($category == "Dinner") echo "selected"; ?>>Dinner</option>
                  <option value="Dessert" <?php if($category == "Dessert") echo "selected"; ?>>Dessert</option>
                </select>
                <label for="category">Category</label>
              </div>
              <div class="mb-3">
                <label class="form-label" for="image">Recipe Image</label>
                <input type="file" class="form-control" id="image" name="image">
              </div>
              <button type="submit" class="btn btn-primary">Update Recipe</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $footer_scripts = '<script src="js/ingredient-inputs.js"></script>';?>
<?php include 'inc/footer.php';?>