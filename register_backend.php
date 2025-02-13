<?php
// Start session
session_start();

// Database connection settings
$host = 'localhost'; // Database host
$username = 'root'; // Database username (default is root for XAMPP)
$password = ''; // Database password (empty for XAMPP)
$dbname = 'university_db'; // The database name

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input values
    $usn = trim($_POST['usn']);
    $name = trim($_POST['name']);
    $raw_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($raw_password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }

    // Check if USN already exists
    $check_query = "SELECT * FROM student WHERE usn = ?";
    if ($stmt = $conn->prepare($check_query)) {
        $stmt->bind_param('s', $usn);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['error'] = "USN already exists!";
            header("Location: register.php");
            exit();
        }
        $stmt->close();
    }

    // Hash the password for security
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Insert new user into the student table
    $insert_query = "INSERT INTO student (usn, student_name, password) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($insert_query)) {
        $stmt->bind_param('sss', $usn, $name, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Error in registration. Try again!";
            header("Location: register.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Database error!";
        header("Location: register.php");
        exit();
    }
}

// Close database connection
$conn->close();
?>
