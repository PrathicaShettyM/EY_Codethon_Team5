<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "bank");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define SQL injection patterns (improved)
$sql_patterns = [
    "/(\bUNION\b.*\bSELECT\b)/i",  // Detect UNION SELECT
    "/(\bSELECT\b.\bFROM\b.--)/i",  // SELECT with comment attempt
    "/(\bOR\b\s*['\"0-9].=.['\"0-9])/i",  // Logical OR statements
    "/(;.*\bDROP\b|\bALTER\b|\bINSERT\b|\bDELETE\b)/i",  // Dropping, altering, inserting, deleting
    "/('.*--)/i",  // Inline comment after input
    "/(\bAND\b\s*['\"0-9].=.['\"0-9])/i",  // Logical AND statements
    "/(['\"].OR.['\"]).*=/i",  // OR inside quotes
    "/(['\"]).(=|LIKE).(['\"])/i" // Dangerous comparisons
];

// Get user input
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Gather client details
$ip_address = $_SERVER['REMOTE_ADDR'];  // Get user's IP address
$user_agent = $_SERVER['HTTP_USER_AGENT'];  // Get browser info
$date_time = date("Y-m-d H:i:s");  // Current date & time

// Check for SQL injection patterns
foreach ($sql_patterns as $pattern) {
    if (preg_match($pattern, $username) || preg_match($pattern, $password)) {
        // Log the attempt
        $log_data = "[{$date_time}] SQL Injection Attempt: IP: {$ip_address}, Username: {$username}, Browser: {$user_agent}\n";
        
        file_put_contents("sql_injection_log.txt", $log_data, FILE_APPEND);

        // Block login & show error
        $_SESSION['error'] = "SQL Injection detected! Suspicious input.";
        header("Location: login.php");
        exit();
    }
}

// If input is safe, pass it to server.php
$_SESSION['safe_username'] = $username;
$_SESSION['safe_password'] = $password;
header("Location: server.php");
exit();
?>