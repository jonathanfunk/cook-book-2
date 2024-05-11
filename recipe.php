<?php
session_start();
require_once('includes/db.php');
require_once('includes/functions.php');
require_once('classes/Recipe.php');

// Check if recipe slug is provided
if (!isset($_GET['slug'])) {
    header("Location: index.php");
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
    $title = "Recipe Not Found";
    $description = "The recipe you are looking for does not exist.";
    $ingredients = "";
    $instructions = "";
    $category = "";

    include 'inc/header.php';
    ?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><?php echo $title; ?></div>
        <div class="card-body">
          <p><?php echo $description; ?></p>
          <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
    include 'inc/footer.php';
    exit();
}

// Display recipe details
$title = $recipe_details['title'];
$description = $recipe_details['description'];
$ingredients = $recipe_details['ingredients'];
$instructions = $recipe_details['instructions'];
$category = $recipe_details['category'];
// Add more details as needed
?>
<?php include 'inc/header.php';?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><?php echo $title; ?></div>
        <div class="card-body">
          <h5>Description:</h5>
          <p><?php echo $description; ?></p>
          <h5>Ingredients:</h5>
          <ul>
            <?php
              $ingredient_list = explode(",", $ingredients);
              foreach ($ingredient_list as $ingredient) {
                  echo "<li>$ingredient</li>";
              }
              ?>
          </ul>
          <h5>Instructions:</h5>
          <p><?php echo $instructions; ?></p>
          <h5>Category: <?php echo $category; ?></h5>
          <?php if ($_SESSION['user_id'] == $recipe_details['user_id']) { ?>
          <form action="actions/delete_recipe.php?id=<?php echo $recipe_details['id']; ?>" method="POST"
            onsubmit="return confirm('Are you sure you want to delete this recipe?');">
            <button type="submit" class="btn btn-danger">Delete Recipe</button>
          </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc/footer.php';?>