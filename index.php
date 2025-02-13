<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }

  // Include the file to fetch balance (if applicable, ensure fetch_balance.php is fetching correct data)
  include('fetch_balance.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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

    .welcome-message {
      font-size: 18px;
      margin-top: 20px;
    }

    .notification {
      background-color: #f39c12;
      color: #fff;
      padding: 15px;
      border-radius: 5px;
      margin-top: 20px;
      text-align: center;
    }

    .error {
      background-color: #e74c3c;
    }

    .success {
      background-color: #2ecc71;
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
    <a href="account.php">Accounts</a>  <!-- Link to Account Page -->
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
      <h2>Welcome to Your Dashboard</h2>
    </div>

    <!-- Logged-in User Information -->
    <?php if (isset($_SESSION['username'])) : ?>
      <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
      <!-- Display Account Balance -->
      <?php if (isset($balance)) : ?>
        <p>Your Account Balance: <strong><?php echo "₹" . number_format($balance, 2); ?></strong></p>
      <?php endif; ?>
    <?php endif ?>
  </div>
</div>

</body>
</html>
