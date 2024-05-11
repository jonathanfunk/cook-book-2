<?php include 'inc/header.php';?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Recipe</div>
        <div class="card-body">
          <form action="actions/add_recipe.php" method="post">
            <div class="form-group">
              <label for="title">Recipe Title</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="ingredients">Ingredients</label>
              <textarea class="form-control" id="ingredients" name="ingredients" rows="5" required></textarea>
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
                <!-- Add more categories as needed -->
              </select>
            </div>
            <!-- Add more fields as needed -->
            <button type="submit" class="btn btn-primary">Add Recipe</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc/footer.php';?>