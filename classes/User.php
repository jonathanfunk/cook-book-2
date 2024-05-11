<?php
class User {
    private $conn;
    
    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }
    
    public function register($username, $email, $password) {
      // Sanitize input
      $username = sanitize_input($username);
      $email = sanitize_input($email);
      $password = hash_password($password); // No need to sanitize hashed password
  
      // Insert user into database using prepared statements to prevent SQL injection
      $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("sss", $username, $email, $password);
      if ($stmt->execute()) {
          return true; // Registration successful
      } else {
          return false; // Registration failed
      }
  }
  
    
  public function login($username, $password) {
    // Sanitize input
    $username = sanitize_input($username);
    $password = sanitize_input($password);

    // Fetch user data from database using prepared statement
    $sql = "SELECT id, password FROM users WHERE username=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();
        $hashed_password = $user_data['password'];
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session
            $_SESSION['user_id'] = $user_data['id'];
            return true; // Login successful
        } else {
            // Incorrect password
            return "Invalid password.";
        }
    } else {
        // Username does not exist
        return "Invalid username.";
    }
}


    
    public function logout() {
        session_unset();
        session_destroy();
    }
    public function usernameExists($username) {
      $username = sanitize_input($username);
      $sql = "SELECT COUNT(*) AS count FROM users WHERE username = ?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      echo "Username count: " . $row['count']; // Debug output
      return $row['count'] > 0; // Returns true if username exists, false otherwise
  }
  
  public function emailExists($email) {
      $email = sanitize_input($email);
      $sql = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      echo "Email count: " . $row['count']; // Debug output
      return $row['count'] > 0; // Returns true if email exists, false otherwise
  }
  
  
}
?>