<?php
// Connect to the database
$db = new mysqli('localhost', 'root', '', 'bank');

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    exit();
}

// Get the username from session
$username = $_SESSION['username'];

// Prepare query to get account number of the logged-in user
$query = "SELECT account_number FROM users WHERE username = ?";
if ($stmt = $db->prepare($query)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if account number is found
    if ($row = $result->fetch_assoc()) {
        $account_number = $row['account_number'];
        
        // Fetch transactions for the user's account
        $trans_query = "SELECT * FROM transaction WHERE Account_Number = ?";
        if ($trans_stmt = $db->prepare($trans_query)) {
            $trans_stmt->bind_param("i", $account_number);
            $trans_stmt->execute();
            $transactions = $trans_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $trans_stmt->close();
        } else {
            echo "Error preparing transaction query.";
            exit();
        }
    } else {
        $transactions = [];
    }
    $stmt->close();
} else {
    echo "Error preparing user query.";
    exit();
}

// Close database connection
$db->close();
?>
