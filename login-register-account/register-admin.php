<?php

@include "../database/config.php";

session_start();

if (isset($_SESSION['admin_username'])) {
  // if not go back to the index file or page
  header("location: ../forestry-services-homepage-admin.php");
}

$errorMessage = "";

if (isset($_POST['register'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $contact_number = mysqli_real_escape_string($conn, $_POST['contact-number']);
  $sex = mysqli_real_escape_string($conn, $_POST['sex']);
  $email_address = mysqli_real_escape_string($conn, $_POST['email-address']);
  $password = md5($_POST['password']);
  $confirm_password = md5($_POST['password']);

  $select = " SELECT * FROM admins WHERE username = '$username' && email_address = '$email_address' && password = '$password'";
  $check = $conn->query($select);

  if (!$check) {
    die("Invalid query: " . $conn->error);
  }
  if (mysqli_num_rows($check) > 0) {
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'admin already exist!';
  } else {
    $insert = "INSERT INTO admins (username, address, contact_number, sex, email_address, password) " . "VALUES ('$username', '$address', '$contact_number', '$sex', '$email_address', '$password')";
    $result = $conn->query($insert);

    if (!$result) {
      die("Invalid query: " . $conn->error);
    }
    header('location:login-admin.php');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../img/penro-logo.png">
  <title>Chainsaw Registration</title>
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/register-admin.css?<?php echo time(); ?>">
</head>

<body>

  <form method="post">
    <h4>Register Account for ADMIN</h4>
    <?php

    // prompt error if user already exist
    if (isset($error)) {
      echo '
        <div class="alert alert-danger" role="alert">
          ' . $error . '
        </div> ';
    }


    ?>
    <img src="../images/penro-logo.png" alt="">
    <label for="">Username:</label>
    <input name="username" class="form-control" type="text" required>
    <label for="">Address:</label>
    <input name="address" class="form-control" type="text" required>
    <label for="">Contact Number:</label>
    <input name="contact-number" class="form-control" type="number" required>
    <select class="form-select" name="sex">
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>
    <label for="">Email Address:</label>
    <input name="email-address" class="form-control" type="email" required>
    <label for="">Password:</label>
    <input name="password" class="form-control" type="password" required>
    <label for="">Confirm Password:</label>
    <input name="confirm-password" class="form-control" type="password" required>
    <input name="register" class="btn btn-success" type="submit" value="Log In">
    <a href="">Forgot Password</a>
    <p>Already have an Account?<a href="login-admin.php">Login here</a></p>
  </form>
</body>

</html>