<?php
session_start();
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : "";
unset($_SESSION['login_error']); // Clear error after displaying
?>

<?php include 'inc/header.php';?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php if ($login_error): ?>
          <div class="alert alert-danger"><?php echo $login_error; ?></div>
          <?php endif; ?>
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