<?php
session_start();
require_once('includes/db.php');
require_once('includes/functions.php');
require_once('classes/Recipe.php');
$recipe = new Recipe($conn);
$items_per_page = 3;
$recipes = $recipe->getAllRecipes(0, $items_per_page);
$meta_title = "Cook Book";
$meta_description = "Find delicious recipes for every meal on our Cook Book.";
?>
<?php include 'inc/header.php';?>
<!-- Main Content -->
<section class="hero">
  <div class="container">
    <div class="hero-content">
      <h1>Welcome to Our Recipe App</h1>
      <p>Discover delicious recipes for every occasion.</p>
      <a href="register.php" class="btn btn-primary">Register Now</a>
    </div>
  </div>
</section>
<section class="recipes-by-category">
  <div class="container">
    <h2>Recipes by Category</h2>
    <div class="row">
      <!-- Display recipes by category -->
    </div>
  </div>
</section>
<section class="latest-recipes">
  <div class="container">
    <h2>Latest Recipes</h2>
    <div class="row">
      <?php foreach ($recipes as $recipe) : ?>
      <div class="col-md-4 mb-4">
        <div class="card">
          <?php 
          // Display author information
          $user_id = $recipe['user_id'];
          $user_query = "SELECT username, email FROM users WHERE id = ?";
          $user_statement = $conn->prepare($user_query);
          $user_statement->bind_param("i", $user_id); // "i" indicates integer type for user_id
          $user_statement->execute();
          $user_result = $user_statement->get_result();
          $user_details = $user_result->fetch_assoc();
          $author_name = $user_details['username'];
          $author_email = $user_details['email'];
          $user_statement->close();
        ?>
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
            <p><?php echo $author_name; ?> | <?php echo date('F j, Y', strtotime($recipe['created_at'])); ?> |
              <?php echo $recipe['category']; ?></p>
            <h5 class="card-title"><?php echo $recipe['title']; ?></h5>
            <p class="card-text"><?php echo $recipe['description']; ?></p>
            <a href="recipe.php?slug=<?php echo $recipe['slug']; ?>" class="btn btn-primary">View Recipe</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="cta">
  <div class="container">
    <h2>Join Our Community!</h2>
    <p>Register now to access exclusive recipes and cooking tips.</p>
    <a href="register.php" class="btn btn-primary">Register Now</a>
  </div>
</section>
<?php include 'inc/footer.php';?>