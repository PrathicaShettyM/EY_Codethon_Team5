<?php
// fetch_balance.php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // default username for MySQL
$password = ""; // default password for MySQL
$dbname = "bank"; // replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's username from session
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  // Query to get account number and balance from the accounts table
  $query = "SELECT accounts.balance 
            FROM users 
            INNER JOIN accounts ON users.account_number = accounts.account_number 
            WHERE users.username = ?";
  
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();
  }

  // Close the connection
  $conn->close();
}
?>
