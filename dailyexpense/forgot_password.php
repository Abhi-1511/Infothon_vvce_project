<?php
require('config.php');
session_start();
$errormsg = "";
$successMsg = "";

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $newPassword = $_POST['new_password'];

  // Check if the email exists in the database
  $query = "SELECT * FROM `users` WHERE email='$email'";
  $result = mysqli_query($con, $query) or die(mysqli_error($con));
  $rows = mysqli_num_rows($result);

  if ($rows == 1) {
    // Update the user's password
    $hashedPassword = md5($newPassword);
    $updateQuery = "UPDATE `users` SET password='$hashedPassword' WHERE email='$email'";
    mysqli_query($con, $updateQuery) or die(mysqli_error($con));
    $successMsg = "Password updated successfully!";
  } else {
    $errormsg = "Email not found!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Add the necessary CSS styles and scripts -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Forgot Password</title>
  <link href="bootstrap.min.css" rel="stylesheet">
  <!-- Add your custom styles if needed -->
  <style>
    /* Custom styles go here */
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center">Forgot Password</h2>
        <?php if ($successMsg != "") : ?>
          <div class="alert alert-success" role="alert"><?php echo $successMsg; ?></div>
        <?php endif; ?>
        <?php if ($errormsg != "") : ?>
          <div class="alert alert-danger" role="alert"><?php echo $errormsg; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
          </div>
          <button type="submit" class="btn btn-primary" name="submit">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
  <!-- Include Bootstrap core JavaScript and any additional scripts if needed -->
  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>