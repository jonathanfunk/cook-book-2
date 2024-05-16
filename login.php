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
<section class="section bg-light flex-grow-1">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow form-card">
          <div class="card-body">
            <h1>Login</h1>
            <?php
                        // Display error message if login fails
                        if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                            echo '<div class="alert alert-danger" role="alert">Invalid username or password.</div>';
                        }
                        ?>
            <form action="actions/login.php" method="post">
              <div class="mb-3 form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="Jon" required>
                <label for="username">Username</label>
              </div>
              <div class="mb-3 form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="***" required>
                <label for="password">Password</label>
              </div>
              <button type="submit" class="btn w-100 btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'inc/footer.php';?>