<?php
session_start();
$errors = isset($_SESSION['register_errors']) ? $_SESSION['register_errors'] : array();
unset($_SESSION['register_errors']); // Clear errors after displaying

// Function to check if an error message exists for a specific field
function display_error($field) {
    global $errors;
    return isset($errors[$field]) ? '<span class="text-danger">' . $errors[$field] . '</span>' : '';
}
?>
<?php
  $meta_title = "Register | Cook Book";
  $meta_description = "Register for an account on our Cook Book to start sharing your favorite recipes and connecting with other food enthusiasts.";
?>
<?php include 'inc/header.php';?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Register</div>
        <div class="card-body">
          <?php
            // Display error message if username or email is taken
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'username_taken') {
                    echo '<div class="alert alert-danger" role="alert">Username already in use.</div>';
                } elseif ($_GET['error'] == 'email_taken') {
                    echo '<div class="alert alert-danger" role="alert">Email already in use.</div>';
                }
            }
          ?>
          <form action="actions/register.php" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc/footer.php';?>