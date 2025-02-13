<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - University System</title>
  <link rel="stylesheet" href="style.css"> <!-- Your CSS file -->
</head>
<body class="login-body">
  <div class="login-container">
    <div class="login-box">
      <h2>Login</h2>

      <!-- Display error messages if there are any -->
      <?php 
        if (isset($_SESSION['error'])) {
          echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
        }
      ?>

      <!-- Login Form -->
      <form method="POST" action="login_backend.php">
        <div class="input-group">
          <label for="usn">USN</label>
          <input type="text" id="usn" name="usn" required style="text-align: left;">
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required style="text-align: left;">
        </div>

        <button type="submit" class="login-btn">Login</button>

        <!-- Signup link -->
        <p class="signup-link">
          Don't have an account? <a href="register.php">Sign up here</a>
        </p>

        <!-- Admin login link -->
        <p class="signup-link">
          Admin? <a href="admin_login.php">Login here</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
