<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Banking System</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <div class="login-box">
      <h2>Login</h2>

      <!-- Display SQL Injection Error -->
      <?php 
        if (isset($_SESSION['error'])) {
          echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
        }
      ?>

      <form method="post" action="sql_injection_detector.php">
        <div class="input-group">
          <label>Username</label>
          <input type="text" name="username" required style="text-align: left;"> <!-- Left-align text -->
        </div>

        <div class="input-group">
          <label>Password</label>
          <input type="password" name="password" required style="text-align: left;"> <!-- Left-align text -->
        </div>

        <button type="submit" class="login-btn" name="login_user">Login</button>

        <p class="signup-link">
          Don't have an account? <a href="register.php">Sign up here</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
