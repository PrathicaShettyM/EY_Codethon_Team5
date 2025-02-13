<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - University System</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <div class="login-box">
      <h2>Register</h2>

      <!-- Display error messages -->
      <?php 
        if (isset($_SESSION['error'])) {
          echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
        }
      ?>

      <!-- Registration Form -->
      <form method="POST" action="register_backend.php">
        <div class="input-group">
          <label for="usn">USN</label>
          <input type="text" id="usn" name="usn" required>
        </div>

        <div class="input-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="input-group">
          <label for="confirm_password">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit" class="login-btn">Register</button>

        <!-- Redirect to login -->
        <p class="signup-link">
          Already have an account? <a href="login.php">Login here</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
