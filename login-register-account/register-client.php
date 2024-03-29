<?php

@include "../database/config.php";

session_start();

if (isset($_SESSION['username'])) {
  header("location: ../forestry-services-homepage.php");
}

$errorMessage = "";

if (isset($_POST['register'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $business_name = mysqli_real_escape_string($conn, $_POST['business-name']);
  $owners_name = mysqli_real_escape_string($conn, $_POST['owners-name']);
  $sex = mysqli_real_escape_string($conn, $_POST['sex']);
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
    $insert = "INSERT INTO clients (username, business_name, owners_name, address, sex, contact_number, email_address, password) " . "VALUES ('$username', '$business_name', '$owners_name', '$address', '$sex', '$contact_number', '$email_address', '$password')";
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
  <link rel="icon" href="../img/penro-logo.png">
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
    <label for="username">Username:</label>
    <input name="username" class="form-control" type="text" required>
    <label for="business-name">Business Name:</label>
    <input name="business-name" class="form-control" type="text" required>
    <label for="owners-name">Owner's Name:</label>
    <input name="owners-name" class="form-control" type="text" required>
    <lable for="sex">Sex</lable>
    <select class="form-select" name="sex">
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>
    <label for="address">Address:</label>
    <input name="address" class="form-control" type="text" required>
    <label for="">Contact Number:</label>
    <input name="contact-number" class="form-control" type="number" required>
    <label for="">Email Address:</label>
    <input name="email-address" class="form-control" type="email" required>
    <label for="">Password:</label>
    <input name="password" class="form-control" type="password" required>
    <label for="">Confirm Password:</label>
    <input name="confirm-password" class="form-control" type="password" required>
    <input class="btn btn-success" type="submit" name="register" value="Register">
    <a href="">Forgot Password</a>
    <p>Already have an Account?<a href="login-client.php">Login here</a></p>
  </form>
</body>

</html>