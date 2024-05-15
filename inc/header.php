<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($meta_title) ? $meta_title : "Cook Book"; ?></title>
  <meta name="description"
    content="<?php echo isset($meta_description) ? $meta_description : "Welcome to our Cook Book"; ?>">
  <!-- Add Bootstrap CSS link here -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Add your custom CSS file here -->
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">Cook Book</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="recipes.php">Recipes</a></li>
          <?php
                if(!isset($_SESSION)) 
                { 
                    session_start(); 
                }
                if (isset($_SESSION['user_id'])) {
                    // User is logged in, display logout link
                    echo '<li class="nav-item"><a class="nav-link" href="add_recipe.php">Add Recipe</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="actions/logout.php">Logout</a></li>';
                } else {
                    // User is not logged in, display login/register links
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
                }
                ?>
        </ul>
      </div>
    </div>
  </nav>