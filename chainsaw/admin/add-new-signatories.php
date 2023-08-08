<?php

@include "../../database/config.php";

$errorMessage = "";

if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $email_address = mysqli_real_escape_string($conn, $_POST['email-address']);
  $sex = mysqli_real_escape_string($conn, $_POST['sex']);
  $type_of_user = mysqli_real_escape_string($conn, $_POST['type-of-user']);
  $password = md5($_POST['password']);
  $confirm_password = md5($_POST['confirm-password']);

  if ($password != $confirm_password) {
    $password_error = "password doesn't match";
  } else {
    $select = " SELECT * FROM signatories WHERE username = '$username' && email_address = '$email_address' && password = '$password'";
    $check = $conn->query($select);

    if (mysqli_num_rows($check) > 0) {
      // if there is a data retrieve, display an error prompting the user that this email and password already exist
      $error = 'user already exist!';
    } else {
      $insert = "INSERT INTO signatories (username, first_name, last_name, address, email_address, sex, type_of_user, status, password) " . "VALUES ('$username', '$first_name', '$last_name', '$address', '$email_address', '$sex', '$type_of_user', 'activated', '$password')";
      $result = $conn->query($insert);

      header('location: crude-signatories.php');
    }
  }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../img/penro-logo.png">
  <title>Register Signatories</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>

<body>
  <form method="post" class="container border border-dark rounded d-flex flex-column mt-3 px-5 py-1" style="width: 400px;">
    <h3 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Register New Signatories</h3>

    <?php

    // prompt error if user already exist
    if (isset($error)) {
      echo '
        <div class="alert alert-danger" role="alert">
          ' . $error . '
        </div> ';
    }


    ?>

    <div class="form-group">
      <label class="form-label" for="username">Username</label>
      <input class="form-control" type="text" name="username" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="business-name">First Name</label>
      <input class="form-control" type="text" name="first-name" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="owners-name">Last Name</label>
      <input class="form-control" type="text" name="last-name" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="address">Address</label>
      <input class="form-control" type="text" name="address" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="email-address">Email Address</label>
      <input class="form-control" type="email" name="email-address" required>
    </div>

    <label class="form-label" for="sex">Sex</label>
    <select class="form-select" name="sex">
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>

    <label class="form-label" for="type-of-user">Type of User</label>
    <select class="form-select" name="type-of-user">
      <option value="order of payment signatories">Order of Payment Signatories</option>
      <option value="permit signatories">Permit Signatories</option>
      <option value="issuing and releasing personnel">Issuing and Releasing Personnel</option>
    </select>

    <?php 
      if(isset($password_error)) {
        echo '
        <div class="alert alert-danger" role="alert">
          ' . $password_error . '
        </div> ';
      }
    ?>

    <div class="form-group">
      <label class="form-label" for="password">Password</label>
      <input class="form-control" type="password" name="password" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="password">Confirm Password</label>
      <input class="form-control" type="password" name="confirm-password" required>
    </div>

    <div class="d-flex justify-content-evenly mt-3">
      <a class="btn btn-secondary" href="crude-signatories.php">Cancel</a>
      <input name="submit" type="submit" class="btn btn-primary" value="Register">
    </div>


  </form>
</body>

</html>