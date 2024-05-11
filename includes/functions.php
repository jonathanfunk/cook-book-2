<?php
// Function to sanitize user input
function sanitize_input($input) {
  global $conn;
  // Check if the input is an array (like $_POST)
  if (is_array($input)) {
      foreach ($input as $key => $value) {
          $input[$key] = sanitize_input($value); // Recursively sanitize each element
      }
      return $input;
  }
  // For non-array input (like passwords), apply escaping and sanitization
  return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($input))));
}

// Function to hash passwords
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify password
function verify_password($password, $hashed_password) {
    return password_verify($password, $hashed_password);
}
?>