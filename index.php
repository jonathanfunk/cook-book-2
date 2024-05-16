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
<section class="hero min-vh-100 d-flex flex-column justify-content-center">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 d-flex flex-column align-items-start gap-4">
        <h1>Explore Culinary Delights with Our Recipe App</h1>
        <p>Get Inspired with Our Wide Range of Recipes.</p>
        <div class="hero-buttons d-flex justify-content-center">
          <a href='recipes.php' class="btn btn-primary me-2">Review Recipes</a>
          <a href='register.php' class="btn btn-outline-primary">Sign Up</a>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 section-title">
        <h3>Categories</h3>
        <h2>Discover Your Favorite Cuisine</h2>
        <p>Browse our collection of recipes organized by category. Whether you're looking for quick and easy meals,
          healthy
          options, or indulgent treats, you'll find plenty of ideas here.
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card category">
          <div class="category-image"><img src="./images/Breakfast.webp" alt="Breakfast">
          </div>
          <div class="card-body">
            <h3>Breakfast</h3>
            <p>Start your day right with our delicious breakfast recipes. From hearty classics like pancakes and omelets
              to healthy smoothie bowls, we have something to suit every morning routine.</p>
            <a href="recipes.php?category=Breakfast" class="btn btn-small btn-primary">See Options</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card category">
          <div class="category-image"><img src="./images/Lunch.webp" alt="Lunch">
          </div>
          <div class="card-body">
            <h3>Lunch</h3>
            <p>Elevate your midday meal with our selection of lunch recipes. From satisfying salads and sandwiches to
              flavorful soups and wraps, we have quick and easy options for every taste.</p>
            <a href="recipes.php?category=Lunch" class="btn btn-small btn-primary">See Options</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card category">
          <div class="category-image"><img src="./images/Dinner.webp" alt="Dinner">
          </div>
          <div class="card-body">
            <h3>Dinner</h3>
            <p>Make dinner time special with our range of dinner recipes. From comforting casseroles and hearty stews to
              elegant mains and sides, we have dishes to inspire your evening meals.</p>
            <a href="recipes.php?category=Dinner" class="btn btn-small btn-primary">See Options</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card category">
          <div class="category-image"><img src="./images/Dessert.webp" alt="Dessert">
          </div>
          <div class="card-body">
            <h3>Dessert</h3>
            <p>Treat yourself to something sweet with our irresistible dessert recipes. From decadent cakes and cookies
              to refreshing fruit salads and frozen treats, we have indulgent desserts for every craving.</p>
            <a href="recipes.php?category=Dessert" class="btn btn-small btn-primary">See Options</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 section-title">
        <h3>New Arrivals</h3>
        <h2>Fresh From the Kitchen</h2>
        <p>Explore the freshest additions to our recipe library and find your next favorite dish.
        </p>
      </div>
    </div>
    <div class="row">
      <?php foreach ($recipes as $recipe) : ?>
      <div class="col-md-4 mb-4">
        <div class="card recipe-card shadow-sm">
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
          <div class="recipe-image">
            <a href="recipe.php?slug=<?php echo $recipe['slug']; ?>">
              <img src="<?php echo $transformed_url; ?>" class="card-img-top" alt="<?php echo $recipe['title']; ?>">
            </a>
          </div>
          <?php else : ?>
          <!-- Placeholder image if no image is available -->
          <div class="recipe-image">
            <a href="recipe.php?slug=<?php echo $recipe['slug']; ?>">
              <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Placeholder Image">
            </a>
          </div>
          <?php endif; ?>
          <div class="card-body">
            <p><?php echo $author_name; ?> | <?php echo date('F j, Y', strtotime($recipe['created_at'])); ?> |
              <?php echo $recipe['category']; ?></p>
            <a href="recipe.php?slug=<?php echo $recipe['slug']; ?>">
              <h3 class=" card-title"><?php echo $recipe['title']; ?></h3>
            </a>
            <p class="card-text"><?php echo $recipe['description']; ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section bg-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 section-title">
        <h2 class="text-white">Join Our Community!</h2>
        <p class="text-white">Register now to access exclusive recipes and cooking tips.
        </p>
        <a href="register.php" class="btn btn-light">Register Now</a>
      </div>
    </div>
  </div>
</section>
<?php include 'inc/footer.php';?>