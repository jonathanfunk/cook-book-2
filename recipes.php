<?php
session_start();
require_once('includes/db.php');
require_once('includes/functions.php');
require_once('classes/Recipe.php');
$meta_title = "Recipes | Cook Book";
$meta_description = " Explore our collection of delicious recipes ranging from appetizers to desserts.";
include 'inc/header.php'; // Include header

// Fetch all recipes from the database
$recipe = new Recipe($conn);

// Pagination
$items_per_page = 6;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// Get total number of recipes
$total_recipes = $recipe->countRecipes();

// Get filter and sort parameters
$category = isset($_GET['category']) ? $_GET['category'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Fetch recipes based on filter and sort parameters
$recipes = $recipe->getAllRecipes($offset, $items_per_page, $category, $sort);

// Calculate total pages
$total_pages = ceil($total_recipes / $items_per_page);

?>

<!-- Page Content -->
<section class="section bg-light">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mb-4">All Recipes</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form action="recipes.php" method="GET">
          <div class="row">
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <select id="category" name="category" class="form-select">
                  <option value="" <?php if(isset($_GET['category']) && $_GET['category'] == '') echo 'selected'; ?>>All
                    Categories</option>
                  <option value="Breakfast"
                    <?php if(isset($_GET['category']) && $_GET['category'] == 'Breakfast') echo 'selected'; ?>>Breakfast
                  </option>
                  <option value="Lunch"
                    <?php if(isset($_GET['category']) && $_GET['category'] == 'Lunch') echo 'selected'; ?>>Lunch
                  </option>
                  <option value="Dinner"
                    <?php if(isset($_GET['category']) && $_GET['category'] == 'Dinner') echo 'selected'; ?>>Dinner
                  </option>
                  <option value="Dessert"
                    <?php if(isset($_GET['category']) && $_GET['category'] == 'Dessert') echo 'selected'; ?>>Dessert
                  </option>
                </select>
                <label for="category" class="form-label">Filter by Category:</label>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="form-floating">
                <select id="sort" name="sort" class="form-select">
                  <option value="newest"
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'newest') echo 'selected'; ?>>Newest</option>
                  <option value="oldest"
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'oldest') echo 'selected'; ?>>Oldest</option>
                </select>
                <label for="sort" class="form-label">Sort by:</label>
              </div>
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-end justify-content-end">
              <button type="submit" class="btn btn-primary h-100">Apply Filters</button>
            </div>
          </div>
        </form>
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
    <!-- Pagination links -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <!-- Previous Page Link -->
        <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''; ?>">
          <a class="page-link"
            href="recipes.php?page=<?php echo $current_page - 1; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : ''; ?>"
            aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <!-- Pagination Links -->
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
          <a class="page-link"
            href="recipes.php?page=<?php echo $i; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : ''; ?>"><?php echo $i; ?></a>
        </li>
        <?php endfor; ?>

        <!-- Next Page Link -->
        <li class="page-item <?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>">
          <a class="page-link"
            href="recipes.php?page=<?php echo $current_page + 1; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : ''; ?>"
            aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</section>

<?php include 'inc/footer.php'; // Include footer ?>