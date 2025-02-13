<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'bank');
if (!$db) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from customer_details.php
    $username = $_POST['username'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];
    $account_type = $_POST['account_type'];
    $open_date = $_POST['open_date'];
    $branch_id = $_POST['branch_id']; // Use branch_id passed from accountregister.php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Validate password
    if ($password_1 !== $password_2) {
        die("Passwords do not match.");
    }

    // Insert new customer into Customer table
    $query = "INSERT INTO Customer (Name, Email, DOB, Phone_Number, Address, Branch_ID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $dob, $phone_number, $address, $branch_id);
    mysqli_stmt_execute($stmt);
    $customer_id = mysqli_insert_id($db); // Retrieve generated Customer_ID
    mysqli_stmt_close($stmt);

    // Insert into accounts table with valid Customer_ID
    $query = "INSERT INTO accounts (Account_Type, Open_Date, Balance, Branch_ID, Customer_ID) VALUES (?, ?, 0, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ssii", $account_type, $open_date, $branch_id, $customer_id);
    mysqli_stmt_execute($stmt);
    $account_number = mysqli_insert_id($db); // Retrieve generated Account_Number
    mysqli_stmt_close($stmt);

    // Insert into users table with plain text password
    $query = "INSERT INTO users (username, password, Account_Number) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $username, $password_1, $account_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Close database connection
    mysqli_close($db);

    // Redirect to login page
    header("Location: login.php");
    exit();
} else {
    die("Invalid request method.");
}
?>
