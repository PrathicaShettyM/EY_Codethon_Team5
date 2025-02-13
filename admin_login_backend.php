<?php
session_start();

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'university_db';

// Create a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form inputs
    $professor_id = $_POST['admin_id'];  // Admin ID field used as professor_id
    $input_password = $_POST['password'];

    // SQL query to check if the professor exists in the department table
    $sql = "SELECT * FROM department WHERE professor_id = ?";

    // Prepare the statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $professor_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if professor exists
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Check if password matches
            if (password_verify($input_password, $admin['password'])) {
                // Successful login, set session variables
                $_SESSION['admin_id'] = $admin['professor_id'];
                $_SESSION['admin_name'] = $admin['professor_name'];
                $_SESSION['is_admin'] = true;
                
                header("Location: admin_dashboard.php"); // Redirect to admin dashboard
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password.";
            }
        } else {
            $_SESSION['error'] = "Incorrect Admin ID.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "An error occurred.";
    }
}

// Close the database connection
$conn->close();

// Redirect back to login page in case of failure
header("Location: admin_login.php");
exit();
?>
