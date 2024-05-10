<?php
class Recipe {
    private $conn;
    
    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }
    
    public function addRecipe($title, $description, $ingredients, $instructions, $user_id) {
        // Sanitize input
        $title = sanitize_input($title);
        $description = sanitize_input($description);
        $ingredients = sanitize_input($ingredients);
        $instructions = sanitize_input($instructions);
        
        // Insert recipe into database
        $sql = "INSERT INTO recipes (title, description, ingredients, instructions, user_id) VALUES ('$title', '$description', '$ingredients', '$instructions', '$user_id')";
        if ($this->conn->query($sql) === TRUE) {
            return true; // Recipe added successfully
        } else {
            return false; // Adding recipe failed
        }
    }
    
    // Add functions for editRecipe, deleteRecipe, and other CRUD operations
}
?>