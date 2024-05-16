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
<section class="section bg-light flex-grow-1">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow form-card">
          <div class="card-body">
            <h1>Register</h1>
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
              <div class="mb-3 form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="Jon" required>
                <label for="username">Username</label>
              </div>
              <div class="mb-3 form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                  required>
                <label for="email">Email</label>
                <div class="form-text">Set up your avatar through <a href="https://gravatar.com/"
                    target="_blank">Gravatar</a> using the same email address you used to register here.</div>
              </div>
              <div class="mb-3 form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="***" required>
                <label for="password">Password</label>
              </div>
              <button type="submit" class="btn w-100 btn-primary">Sign Up and Start Cooking</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'inc/footer.php';?>