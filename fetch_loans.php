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
        
        // Fetch loans for the user's account using account_number
        $loan_query = "
            SELECT * 
            FROM loans 
            WHERE Customer_ID = (
                SELECT Customer_ID 
                FROM accounts 
                WHERE Account_Number = ?
            )
        ";
        
        if ($loan_stmt = $db->prepare($loan_query)) {
            $loan_stmt->bind_param("i", $account_number);
            $loan_stmt->execute();
            $loan_data = $loan_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $loan_stmt->close();
        } else {
            echo "Error preparing loan query.";
            exit();
        }
    } else {
        $loan_data = [];
    }
    $stmt->close();
} else {
    echo "Error preparing user query.";
    exit();
}

// Close database connection
$db->close();
?>
