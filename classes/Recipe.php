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
    
  public function addRecipe($title, $description, $ingredients, $instructions, $user_id, $category, $image_url) {
    // Sanitize input
    $title = mysqli_real_escape_string($this->conn, $title);
    $description = mysqli_real_escape_string($this->conn, $description);
    $ingredients = mysqli_real_escape_string($this->conn, $ingredients);
    $instructions = mysqli_real_escape_string($this->conn, $instructions);
    $category = mysqli_real_escape_string($this->conn, $category);
    $image_url = mysqli_real_escape_string($this->conn, $image_url);
    
    // Generate slug
    $slug = $this->generateSlug($title);

    // Insert recipe into database
    $sql = "INSERT INTO recipes (title, description, ingredients, instructions, user_id, category, slug, image_url) VALUES ('$title', '$description', '$ingredients', '$instructions', '$user_id', '$category', '$slug', '$image_url')";
    
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
    
  public function updateRecipe($recipe_id, $title, $description, $ingredients, $instructions, $category, $slug, $image_url) {
    // Sanitize inputs
    $title = sanitize_input($title);
    $description = sanitize_input($description);
    $ingredients = sanitize_input($ingredients);
    $instructions = sanitize_input($instructions);
    $category = sanitize_input($category);
    $slug = sanitize_input($slug);
    $image_url = sanitize_input($image_url);

    // Update recipe in the database
    $sql = "UPDATE recipes SET title='$title', description='$description', ingredients='$ingredients', instructions='$instructions', category='$category', slug='$slug', image_url='$image_url' WHERE id='$recipe_id'";
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
  // Method to get all recipes from the database
  public function getAllRecipes($offset = 0, $limit = null, $category = null, $sort = 'newest') {
    $sql = "SELECT * FROM recipes";
    if ($category) {
        $sql .= " WHERE category = '$category'";
    }
    $sql .= " ORDER BY created_at ";
    if ($sort == 'newest') {
        $sql .= "DESC";
    } else {
        $sql .= "ASC";
    }
    if ($limit) {
        $sql .= " LIMIT $offset, $limit";
    }
    $result = $this->conn->query($sql);
    $recipes = [];
    while ($row = $result->fetch_assoc()) {
        $recipes[] = $row;
    }
    return $recipes;
  }

  // Get filtered recipes
    public function getFilteredRecipes($category, $sort, $limit, $offset) {
        $sql = "SELECT * FROM recipes";

        // Add filters
        if ($category) {
            $sql .= " WHERE category = '$category'";
        }
        // Add sorting
        if ($sort === 'newest') {
            $sql .= " ORDER BY created_at DESC";
        } elseif ($sort === 'oldest') {
            $sql .= " ORDER BY created_at ASC";
        }

        // Add limit and offset for pagination
        $sql .= " LIMIT $limit OFFSET $offset";

        // Execute query
        $result = $this->conn->query($sql);

        // Fetch recipes
        $recipes = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $recipes[] = $row;
            }
        }

        return $recipes;
    }

  public function countRecipes() {
    $sql = "SELECT COUNT(*) AS total_recipes FROM recipes";
    $result = $this->conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_recipes'];
  }

  public function countFilteredRecipes($category, $sort) {
    $sql = "SELECT COUNT(*) as total FROM recipes";

    // Add filters
    if ($category) {
        $sql .= " WHERE category = '$category'";
    }

    // Execute query
    $result = $this->conn->query($sql);

    // Fetch total count
    $total = 0;
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
    }

    return $total;
}
}
?>