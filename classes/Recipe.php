<?php
class Recipe {
    private $conn;
    
    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }
    
    public function addRecipe($title, $description, $ingredients, $instructions, $user_id, $category) {
      // Sanitize input
      $title = mysqli_real_escape_string($this->conn, $title);
      $description = mysqli_real_escape_string($this->conn, $description);
      $ingredients = mysqli_real_escape_string($this->conn, $ingredients);
      $instructions = mysqli_real_escape_string($this->conn, $instructions);
      $category = mysqli_real_escape_string($this->conn, $category);

      // Insert recipe into database
      $sql = "INSERT INTO recipes (title, description, ingredients, instructions, user_id, category) VALUES ('$title', '$description', '$ingredients', '$instructions', '$user_id', '$category')";
      
      if ($this->conn->query($sql) === TRUE) {
          return true; // Recipe added successfully
      } else {
          // Adding recipe failed
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
    
    public function deleteRecipe($recipe_id) {
        // Delete recipe from database
        $sql = "DELETE FROM recipes WHERE id='$recipe_id'";
        if ($this->conn->query($sql) === TRUE) {
            return true; // Recipe deleted successfully
        } else {
            return false; // Deleting recipe failed
        }
    }
}
?>