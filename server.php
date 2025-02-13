<?php
session_start();

// Connect to database
$db = mysqli_connect('localhost', 'root', '', 'bank');

// Initializing variables
$username = "";
$errors = array(); 

// REGISTER USER
if (isset($_POST['reg_user'])) {
    $username = $_POST['username'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO users (username, password) VALUES('$username', '$password_1')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: accountregister.php');
        exit();
    }
}

// CREATE ACCOUNT (Newly added logic for handling account creation)
if (isset($_POST['create_account'])) {
    $account_type = $_POST['account_type'];
    $open_date = $_POST['open_date'];
    $branch_id = $_POST['branch_id'];

    // Validate fields
    if (empty($account_type)) { array_push($errors, "Account Type is required"); }
    if (empty($open_date)) { array_push($errors, "Account Open Date is required"); }
    if (empty($branch_id)) { array_push($errors, "Branch ID is required"); }

    // If no errors, proceed with inserting the new account into the database
    if (count($errors) == 0) {
        // Constants for Customer_ID and Account_Number
        $customer_id = 205;  // As per your request, customer ID is constant
        $account_number = 305; // Account Number is constant

        // Query to insert the new account into the accounts table
        $query = "INSERT INTO accounts (Account_Number, Account_Type, Open_Date, Balance, Branch_ID, Customer_ID) 
                  VALUES ('$account_number', '$account_type', '$open_date', 0.00, '$branch_id', '$customer_id')";

        // Execute the query
        if (mysqli_query($db, $query)) {
            $_SESSION['success'] = "Account created successfully!";
            header('location: index.php');  // Redirect to index.php after successful account creation
            exit();
        } else {
            array_push($errors, "Error creating account: " . mysqli_error($db));
        }
    }
}

// LOGIN USER (Still vulnerable!)
if (isset($_SESSION['safe_username']) && isset($_SESSION['safe_password'])) {
    $username = $_SESSION['safe_username'];
    $password = $_SESSION['safe_password'];

    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    if (count($errors) == 0) {
        // **Vulnerable Query - No Prepared Statements**
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php'); // Redirect to home page
            exit();
        } else {
            array_push($errors, "Wrong username/password combination");
            $_SESSION['error'] = "Wrong username or password";
            header("Location: login.php");
            exit();
        }
    }
}

// Unset session variables after login attempt
unset($_SESSION['safe_username']);
unset($_SESSION['safe_password']);
?>
