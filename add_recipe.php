<?php include 'inc/header.php';?>
<?php 
  // Check if the user is logged in
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }
?>
<section class="section bg-light flex-grow-1">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow form-card">
          <div class="card-body">
            <h1>Add New Recipe</h1>
            <form action="actions/add_recipe.php" method="POST" enctype="multipart/form-data">
              <div class="mb-3 form-floating">
                <input type="text" class="form-control" id="title" name="title" placeholder="Chicken Nuggets" required>
                <label for="title">Title</label>
              </div>
              <div class="mb-3 form-floating">
                <textarea class="form-control" id="description" name="description" rows="3"
                  placeholder="Recipe description" required></textarea>
                <label for="description">Description</label>
              </div>
              <div class="mb-3">
                <label class="form-label" for="ingredients">Ingredients</label>
                <div id="ingredientInputs">
                  <input type="text" class="form-control mb-2" name="ingredient[]" required>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="addIngredient">Add Ingredient</button>
              </div>
              <div class="mb-3 form-floating">
                <textarea class="form-control" id="instructions" name="instructions" rows="5"
                  placeholder="Set of instructions" required></textarea>
                <label for="instructions">Instructions</label>
              </div>
              <div class="mb-3 form-floating">
                <select class="form-control" id="category" name="category" required>
                  <option value="">Select Category</option>
                  <option value="Breakfast">Breakfast</option>
                  <option value="Lunch">Lunch</option>
                  <option value="Dinner">Dinner</option>
                  <option value="Dessert">Dessert</option>
                </select>
                <label for="category">Category</label>
              </div>
              <div class="mb-3">
                <label class="form-label" for="image">Recipe Image</label>
                <input type="file" class="form-control" id="image" name="image">
              </div>
              <button type="submit" class="btn btn-primary">Publish Recipe</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php $footer_scripts = '<script src="js/ingredient-inputs.js"></script>';?>
<?php include 'inc/footer.php';?>