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
    $usn = $_POST['usn'];
    $input_password = $_POST['password'];

    // SQL query to check if the student exists
    $sql = "SELECT * FROM student WHERE usn = ?";

    // Prepare the statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $usn);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if student exists
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();

            // Check if password matches
            if (password_verify($input_password, $student['password'])) {
                // Successful login, set session variables
                $_SESSION['usn'] = $student['usn'];
                $_SESSION['student_name'] = $student['student_name'];
                
                header("Location: student_dashboard.php"); // Redirect to student dashboard
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password.";
            }
        } else {
            $_SESSION['error'] = "Incorrect USN.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "An error occurred.";
    }
}

// Close the database connection
$conn->close();

// Redirect back to login page in case of failure
header("Location: login.php");
exit();
?>
