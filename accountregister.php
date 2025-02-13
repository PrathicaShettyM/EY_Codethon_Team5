<?php 
  include('server.php'); // Including server.php for backend logic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="login-body">

<div class="login-container">
  <div class="login-box">
    <h2>Create Bank Account</h2>
    <form method="post" action="customer_details.php"> <!-- Send to customer_details.php for next input -->
      
      <!-- Account Type -->
      <div class="input-group">
        <label for="account_type">Account Type</label>
        <select name="account_type" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
          <option value="" disabled selected>--Select--</option>
          <option value="Savings">Savings</option>
          <option value="Current">Current</option>
          <option value="Fixed Deposit">Fixed Deposit</option>
          <option value="Recurring Deposit">Recurring Deposit</option>
        </select>
      </div>

      <!-- Account Open Date -->
      <div class="input-group">
        <label for="open_date">Account Open Date</label>
        <input type="date" name="open_date" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
      </div>

      <!-- Branch ID -->
      <div class="input-group">
        <label for="branch_id">Branch ID</label>
        <input type="number" name="branch_id" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
      </div>

      <!-- Hidden Fields to Pass User Data -->
      <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
      <input type="hidden" name="password_1" value="<?php echo isset($_POST['password_1']) ? $_POST['password_1'] : ''; ?>">
      <input type="hidden" name="password_2" value="<?php echo isset($_POST['password_2']) ? $_POST['password_2'] : ''; ?>">

      <!-- Submit Button -->
      <div class="input-group">
        <button type="submit" name="next_step" class="login-btn">Next Step</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
