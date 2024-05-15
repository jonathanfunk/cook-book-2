<?php
session_start();
require_once('includes/db.php');
require_once('includes/functions.php');
require_once('classes/Recipe.php');
include 'inc/header.php'; // Include header

// Fetch all recipes from the database
$recipe = new Recipe($conn);
$recipes = $recipe->getAllRecipes();

?>

<!-- Page Content -->
<div class="container mt-5">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mb-4">All Recipes</h2>
    </div>
  </div>
  <div class="row">
    <?php foreach ($recipes as $recipe) : ?>
    <div class="col-md-4 mb-4">
      <div class="card">
        <?php if (!empty($recipe['image_url'])) : ?>
        <?php 
          // Original image URL from the database
          $image_url = $recipe['image_url'];
          // Transformation parameters
          $transformation = 'c_fill,h_200,w_350'; // Landscape ratio and automatic subject detection
          // Add transformation to the image URL
          $transformed_url = preg_replace('/(upload\/)/', '$1' . $transformation . '/', $image_url);
        ?>
        <img src="<?php echo $transformed_url; ?>" class="card-img-top" alt="<?php echo $recipe['title']; ?>">
        <?php else : ?>
        <!-- Placeholder image if no image is available -->
        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Placeholder Image">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?php echo $recipe['title']; ?></h5>
          <p class="card-text"><?php echo $recipe['description']; ?></p>
          <a href="recipe.php?slug=<?php echo $recipe['slug']; ?>" class="btn btn-primary">View Recipe</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include 'inc/footer.php'; // Include footer ?>