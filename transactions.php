<?php 
session_start();

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
    exit();
}

// Include the fetch transactions script
include('fetch_transactions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
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
            background-color: #444;
            padding: 15px;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 10px;
            display: block;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .return-button:hover {
            background-color: #555;
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
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .transaction-table th, .transaction-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .transaction-table th {
            background-color: #2c3e50;
            color: #fff;
        }
        .transaction-table tr:nth-child(even) {
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
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="index.php" class="return-button">Return</a>
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
            <h2>Transaction History</h2>
        </div>

        <!-- Transaction Table -->
        <?php if (!empty($transactions)) : ?>
            <table class="transaction-table">
                <tr>
                    <th>Transaction ID</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Account Number</th>
                </tr>
                <?php foreach ($transactions as $transaction) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($transaction['Transaction_ID']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['Description']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['Date']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['Type']); ?></td>
                        <td><?php echo "₹" . number_format($transaction['Amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($transaction['Account_Number']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No transactions found for your account.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
