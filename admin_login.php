<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - University System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            <!-- Display error messages if there are any -->
            <?php 
                if (isset($_SESSION['error'])) {
                    echo "<p style='color:red; text-align:center;'>" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']);
                }
            ?>
            <!-- Admin Login Form -->
            <form method="POST" action="admin_login_backend.php">
                <div class="input-group">
                    <label for="admin_id">Admin ID</label>
                    <input type="text" id="admin_id" name="admin_id" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>

                <!-- Link to student login -->
                <p class="signup-link">
                    Student? <a href="login.php">Login here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
