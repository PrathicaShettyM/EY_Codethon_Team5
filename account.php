<?php 
  session_start(); 

  // Ensure the user is logged in
  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }

  // Include the file to fetch account details
  include('fetch_account.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Details</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f4f4;
    }

    .container {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #333;
      padding: 20px;
      color: #fff;
      display: flex;
      flex-direction: column;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar a {
      text-decoration: none;
      color: #fff;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .sidebar a:hover {
      background-color: #444;
    }

    .return-button {
      background-color: #444; /* Shade of the dashboard background color */
      padding: 15px;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      margin-bottom: 10px;
      display: block;
      text-decoration: none;
      font-weight: bold;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); /* Add shadow effect */
    }

    .return-button:hover {
      background-color: #555; /* Darker shade when hovered */
    }

    .logout-box {
      margin-top: auto;
      padding: 15px;
      background-color: #e74c3c;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      cursor: pointer;
    }

    .content {
      flex-grow: 1;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .header {
      background-color: #2c3e50;
      color: #fff;
      padding: 15px;
      text-align: center;
      font-size: 24px;
    }

    /* Table styling for displaying account data */
    .account-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .account-table th, .account-table td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
    }

    .account-table th {
      background-color: #2c3e50;
      color: #fff;
    }

    .account-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .logout-box a {
      text-decoration: none;
      color: #fff;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Left Sidebar -->
  <div class="sidebar">
    <h2>Dashboard</h2>
    <a href="index.php" class="return-button">Return</a> <!-- "Return" button added with box shade -->
    <a href="transactions.php">Transactions</a>
    <a href="loans.php">Loans</a>
    <a href="services.php">Services</a>
    
    <!-- Logout Box -->
    <div class="logout-box">
      <a href="index.php?logout='1'">Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="header">
      <h2>Account Details</h2>
    </div>

    <!-- Account Details Section -->
    <?php if (isset($_SESSION['username'])) : ?>
      <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
      <!-- Display Account Information in Table Format -->
      <?php if (isset($account_data)) : ?>
        <h3>Your Account Information</h3>
        <table class="account-table">
          <tr>
            <th>Account Number</th>
            <th>Account Type</th>
            <th>Open Date</th>
            <th>Balance</th>
            <th>Branch ID</th>
            <th>Customer ID</th>
          </tr>
          <tr>
            <td><?php echo $account_data['account_number']; ?></td>
            <td><?php echo $account_data['Account_Type']; ?></td>
            <td><?php echo $account_data['Open_Date']; ?></td>
            <td><?php echo "₹" . number_format($account_data['Balance'], 2); ?></td>
            <td><?php echo $account_data['Branch_ID']; ?></td>
            <td><?php echo $account_data['Customer_ID']; ?></td>
          </tr>
        </table>
      <?php else: ?>
        <p>No account found for this user.</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
