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
        $password = hash_password(sanitize_input($password));
        
        // Insert user into database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($this->conn->query($sql) === TRUE) {
            return true; // Registration successful
        } else {
            return false; // Registration failed
        }
    }
    
    public function login($username, $password) {
        // Sanitize input
        $username = sanitize_input($username);
        $password = sanitize_input($password);
        
        // Fetch user data from database
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows == 1) {
            $user_data = $result->fetch_assoc();
            if (verify_password($password, $user_data['password'])) {
                // Password is correct, set session
                $_SESSION['user_id'] = $user_data['id'];
                return true; // Login successful
            }
        }
        return false; // Login failed
    }
    
    public function logout() {
        session_unset();
        session_destroy();
    }
    public function getUserIdByUsername($username) {
      // Retrieve user ID from the database
      $sql = "SELECT id FROM users WHERE username = '$username'";
      $result = $this->conn->query($sql);
      if ($result && $result->num_rows > 0) {
          $row = $result->fetch_assoc();
          return $row['id'];
      } else {
          return false; // User ID not found
      }
  }
}
?>