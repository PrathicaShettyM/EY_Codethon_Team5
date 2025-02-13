<?php
// Start the session to store login information
session_start();

// Database connection parameters
$host = 'localhost'; // Your database host (e.g., localhost)
$username = 'root'; // Your database username
$password = ''; // Your database password (default is empty for XAMPP)
$dbname = 'university_db'; // The database you're connecting to

// Create a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form inputs (usn and password)
    $usn = $_POST['usn'];
    $input_password = $_POST['password'];

    // SQL query to check if the student with the given usn exists
    $sql = "SELECT * FROM student WHERE usn = ?";

    // Prepare and bind the SQL statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $usn); // 's' means the parameter is a string
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a record with the given usn exists
        if ($result->num_rows > 0) {
            // Fetch the student data
            $student = $result->fetch_assoc();

            // Check if the input password matches the stored password
            if (password_verify($input_password, $student['password'])) {
                // Successful login, set session variables
                $_SESSION['usn'] = $student['usn'];
                $_SESSION['student_name'] = $student['student_name'];
                header("Location: welcome.php"); // Redirect to welcome page
                exit();
            } else {
                // Incorrect password
                $_SESSION['error'] = "Incorrect password.";
            }
        } else {
            // Incorrect username
            $_SESSION['error'] = "Incorrect username.";
        }
        $stmt->close();
    } else {
        // Error in the query preparation
        $_SESSION['error'] = "An error occurred.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - University System</title>
  <link rel="stylesheet" href="style.css"> <!-- Your updated CSS file -->
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
      <form method="POST" action="login.php">
        <div class="input-group">
          <label for="usn">USN</label>
          <input type="text" id="usn" name="usn" required style="text-align: left;"> <!-- Left-align text -->
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required style="text-align: left;"> <!-- Left-align text -->
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
