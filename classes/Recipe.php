<?php
class Recipe {
    private $conn;
    
    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function generateSlug($title) {
      // Generate slug from title
      return generateSlug($title);
  }
    
  public function addRecipe($title, $description, $ingredients, $instructions, $user_id, $category) {
    // Sanitize input
    $title = mysqli_real_escape_string($this->conn, $title);
    $description = mysqli_real_escape_string($this->conn, $description);
    $ingredients = mysqli_real_escape_string($this->conn, $ingredients);
    $instructions = mysqli_real_escape_string($this->conn, $instructions);
    $category = mysqli_real_escape_string($this->conn, $category);
    
    // Generate slug
    $slug = $this->generateSlug($title);

    // Insert recipe into database
    $sql = "INSERT INTO recipes (title, description, ingredients, instructions, user_id, category, slug) VALUES ('$title', '$description', '$ingredients', '$instructions', '$user_id', '$category', '$slug')";
    
    if ($this->conn->query($sql) === TRUE) {
        return true; // Recipe added successfully
    } else {
        // Adding recipe failed
        return false;
    }
  }
  public function getRecipeBySlug($slug) {
      $slug = mysqli_real_escape_string($this->conn, $slug);
      $sql = "SELECT * FROM recipes WHERE slug = '$slug'";
      $result = $this->conn->query($sql);
      if ($result && $result->num_rows > 0) {
          return $result->fetch_assoc();
      } else {
          return false;
      }
  }
    
    public function editRecipe($recipe_id, $title, $description, $ingredients, $instructions) {
        // Sanitize input
        $title = sanitize_input($title);
        $description = sanitize_input($description);
        $ingredients = sanitize_input($ingredients);
        $instructions = sanitize_input($instructions);
        
        // Update recipe in database
        $sql = "UPDATE recipes SET title='$title', description='$description', ingredients='$ingredients', instructions='$instructions' WHERE id='$recipe_id'";
        if ($this->conn->query($sql) === TRUE) {
            return true; // Recipe updated successfully
        } else {
            return false; // Updating recipe failed
        }
    }
    
    public function deleteRecipe($recipe_id, $user_id) {
      // Ensure the user owns the recipe before deletion
      $sql = "DELETE FROM recipes WHERE id = ? AND user_id = ?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("ii", $recipe_id, $user_id);
      
      if ($stmt->execute() === TRUE) {
          // Check if any row was affected
          if ($stmt->affected_rows > 0) {
              return true; // Recipe deleted successfully
          } else {
              return false; // Recipe not found or user doesn't own the recipe
          }
      } else {
          // Deletion failed
          return false;
      }
  }
}
?>