<?php 
  include('server.php'); // Including server.php for backend logic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="login-body">

<div class="login-container">
  <div class="login-box">
    <h2>Customer Details</h2>
    <form method="post" action="user_acc_creation.php"> <!-- Send to user_acc_creation.php -->
      
      <!-- Customer Name -->
      <div class="input-group">
        <label for="name">Full Name</label>
        <input type="text" name="name" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
      </div>

      <!-- Customer Email -->
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" name="email" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
      </div>

      <!-- Date of Birth -->
      <div class="input-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
      </div>

      <!-- Phone Number -->
      <div class="input-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
      </div>

      <!-- Address -->
      <div class="input-group">
        <label for="address">Address</label>
        <input type="text" name="address" required style="width: 90%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-family: Arial, sans-serif; text-align: center;">
      </div>

      <!-- Hidden Fields to Pass Account and Branch Data -->
      <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
      <input type="hidden" name="password_1" value="<?php echo isset($_POST['password_1']) ? $_POST['password_1'] : ''; ?>">
      <input type="hidden" name="password_2" value="<?php echo isset($_POST['password_2']) ? $_POST['password_2'] : ''; ?>">
      <input type="hidden" name="account_type" value="<?php echo isset($_POST['account_type']) ? $_POST['account_type'] : ''; ?>">
      <input type="hidden" name="open_date" value="<?php echo isset($_POST['open_date']) ? $_POST['open_date'] : ''; ?>">
      <input type="hidden" name="branch_id" value="<?php echo isset($_POST['branch_id']) ? $_POST['branch_id'] : ''; ?>">

      <!-- Submit Button -->
      <div class="input-group">
        <button type="submit" name="create_customer" class="login-btn">Create Customer</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
