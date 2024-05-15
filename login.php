<?php
session_start();
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : "";
unset($_SESSION['login_error']); // Clear error after displaying
?>
<?php
$meta_title = "Login | Cook Book";
$meta_description = "Log in to your account on our Cook Book to access your favorite recipes and more.";
?>
<?php include 'inc/header.php';?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php
                        // Display error message if login fails
                        if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                            echo '<div class="alert alert-danger" role="alert">Invalid username or password.</div>';
                        }
                        ?>
          <form action="actions/login.php" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc/footer.php';?>