<?php
// Database connection parameters
$host = 'localhost'; // Your database host
$username = 'root';  // Your database username
$password = '';      // Your database password (usually empty for local dev environments)
$dbname = 'university_db'; // The name of your database

// Create a connection to the MySQL database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If there is a connection error, display the error and stop the script
    die("Connection failed: " . $conn->connect_error);
}
?>
