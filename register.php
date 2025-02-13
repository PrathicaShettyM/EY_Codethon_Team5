<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Banking System</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <div class="login-box">
      <h2>Create Your Account</h2>
      <form method="post" action="accountregister.php"> <!-- Changed action to pass data -->

        <?php include('errors.php'); ?>

        <div class="input-group">
          <label>Username</label>
          <input type="text" name="username" required style="text-align: left;">
        </div>

        <div class="input-group">
          <label>Password</label>
          <input type="password" name="password_1" required style="text-align: left;">
        </div>

        <div class="input-group">
          <label>Confirm Password</label>
          <input type="password" name="password_2" required style="text-align: left;">
        </div>

        <button type="submit" class="login-btn" name="next_step">Next</button> <!-- Button renamed -->

        <p class="signup-link">
          Already have an account? <a href="login.php">Sign in here</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>
