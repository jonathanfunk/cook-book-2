<?php include 'inc/header.php';?>
<?php 
  // Check if the user is logged in
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Recipe</div>
        <div class="card-body">
          <form action="actions/add_recipe.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="ingredients">Ingredients</label>
              <div id="ingredientInputs">
                <input type="text" class="form-control mb-2" name="ingredient[]" required>
              </div>
              <button type="button" class="btn btn-primary btn-sm" id="addIngredient">Add Ingredient</button>
            </div>
            <div class="form-group">
              <label for="instructions">Instructions</label>
              <textarea class="form-control" id="instructions" name="instructions" rows="5" required></textarea>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
                <option value="Dessert">Dessert</option>
              </select>
            </div>
            <div class="form-group">
              <label for="image">Recipe Image</label>
              <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $footer_scripts = '<script src="js/ingredient-inputs.js"></script>';?>
<?php include 'inc/footer.php';?>