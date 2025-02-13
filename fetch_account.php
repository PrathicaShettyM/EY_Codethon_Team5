<?php
  // Connect to database
  $db = mysqli_connect('localhost', 'root', '', 'bank');

  // Initialize session and check if username exists
  session_start();
  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }

  // Get username from session
  $username = $_SESSION['username'];

  // Prepare and execute the query to fetch account details based on the username
  $query = "SELECT * FROM accounts WHERE Account_Number = (SELECT account_number FROM users WHERE username = ?)";

  // Use prepared statements to avoid SQL injection
  if ($stmt = mysqli_prepare($db, $query)) {
    // Bind parameters (username) to the query
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get result
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query returned a row
    if (mysqli_num_rows($result) > 0) {
      // Fetch the account data
      $account_data = mysqli_fetch_assoc($result);
    } else {
      $account_data = null;  // No account found
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
  } else {
    // Handle error if the query preparation fails
    echo "Error preparing the query.";
    exit();
  }

  // Close database connection
  mysqli_close($db);
?>
