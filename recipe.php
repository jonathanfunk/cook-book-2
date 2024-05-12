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
$instructions = str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $recipe_details['instructions']);
$category = $recipe_details['category'];

// Original image URL from the database
$image_url = $recipe_details['image_url'];
// Transformation parameters
$transformation = 'ar_16:9,c_crop'; // Landscape ratio and automatic subject detection
// Add transformation to the image URL
$transformed_url = preg_replace('/(upload\/)/', '$1' . $transformation . '/', $image_url);

?>
<?php include 'inc/header.php';?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><?php echo $title; ?></div>
        <div class="card-body">
          <!-- Display image -->
          <?php if (!empty($recipe_details['image_url'])) : ?>
          <img src="<?php echo $transformed_url; ?>" class="img-fluid w-100 mb-3"
            alt="<?php echo $recipe_details['title']; ?>">
          <?php endif; ?>
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
          <div class="row mt-3">
            <div class="col-md-6">
              <a href="edit_recipe.php?slug=<?php echo $slug; ?>" class="btn btn-primary btn-block">Edit Recipe</a>
            </div>
            <div class="col-md-6">
              <form action="actions/delete_recipe.php?id=<?php echo $recipe_details['id']; ?>" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                <button type="submit" class="btn btn-danger btn-block">Delete Recipe</button>
              </form>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc/footer.php';?>