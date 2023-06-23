<?php

@include "../database/config.php";

$errorMessage = "";

if (isset($_POST['register'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $business_name = mysqli_real_escape_string($conn, $_POST['business-name']);
  $owners_name = mysqli_real_escape_string($conn, $_POST['owners-name']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $contact_number = mysqli_real_escape_string($conn, $_POST['contact-number']);
  $email_address = mysqli_real_escape_string($conn, $_POST['email-address']);
  $password = md5($_POST['password']);
  $confirm_password = md5($_POST['password']);


  $select = " SELECT * FROM clients WHERE username = '$username' && email_address = '$email_address' && password = '$password'";
  $check = $conn->query($select);

  if (mysqli_num_rows($check) > 0) {
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'user already exist!';
  } else {
    $insert = "INSERT INTO clients (username, business_name, owners_name, address, contact_number, email_address, password) " . "VALUES ('$username', '$business_name', '$owners_name', '$address', '$contact_number', '$email_address', '$password')";
    $result = $conn->query($insert);

    header('location:login-client.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Registration</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/register-client.css?<?php echo time(); ?>">
</head>

<body>

  <form action="" method="post">
    <h4>Register Account</h4>
    <?php

    // prompt error if user already exist
    if (isset($error)) {
      echo '
        <div class="alert alert-danger" role="alert">
          ' . $error . '
        </div> ';
    }
    ?>
    <img src="../img/penro-logo.png" alt="">
    <label for="">Username:</label>
    <input name="username" class="form-control" type="text">
    <label for="">Business Name:</label>
    <input name="business-name" class="form-control" type="text">
    <label for="">Owner's Name:</label>
    <input name="owners-name" class="form-control" type="text">
    <label for="">Address:</label>
    <input name="address" class="form-control" type="text">
    <label for="">Contact Number:</label>
    <input name="contact-number" class="form-control" type="number">
    <label for="">Email Address:</label>
    <input name="email-address" class="form-control" type="email">
    <label for="">Password:</label>
    <input name="password" class="form-control" type="password">
    <label for="">Confirm Password:</label>
    <input name="confirm-password" class="form-control" type="password">
    <input class="btn btn-success" type="submit" name="register" value="Register">
    <a href="">Forgot Password</a>
    <p>Already have an Account?<a href="login-client.php">Login here</a></p>
  </form>
</body>

</html>
