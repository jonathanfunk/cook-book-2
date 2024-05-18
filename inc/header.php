<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($meta_title) ? $meta_title : "Cook Book"; ?></title>
  <meta name="description"
    content="<?php echo isset($meta_description) ? $meta_description : "Welcome to our Cook Book"; ?>">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./css/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow py-4">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="./images/cook-book-logo.svg" alt="Cook Book Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="recipes.php">Recipes</a></li>
          <?php
            if(!isset($_SESSION)) {
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