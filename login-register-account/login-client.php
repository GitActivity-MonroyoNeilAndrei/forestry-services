<?php
@include "../database/config.php";

session_start();

if (isset($_SESSION['username'])) {
  header("location: ../forestry-services-homepage.php");
}

if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = md5($_POST['password']);

  $select = "SELECT * FROM clients WHERE username = '$username' && password = '$password'";
  $result = $conn->query($select);
  $row = mysqli_fetch_assoc($result);

  if (!$result) {
    die("Invalid query: " . $conn->error);
  }

  if (mysqli_num_rows($result) > 0) {

    if ($row['status'] == 'deactivated') {
      header("location: login-client.php?status=deactivated");
    } else {
      $_SESSION['username'] = $username;


      $select2 = "SELECT * FROM clients WHERE username = '$username' && password = '$password'";
      $result2 = $conn->query($select);
      // get the client ID
      while ($row2 = $result2->fetch_assoc()) {
        $_SESSION["client_id"] = $row2['client_id'];
        $_SESSION["cov_client_id"] = $row2['client_id'];
        $_SESSION["ptpr_client_id"] = $row2['client_id'];
      }

      header("location: ../forestry-services-homepage.php");
    }
  } else {
    $error = 'incorrect email or password';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/login-client.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
</head>

<body>

  <form method="post">
    <h4>Login Account</h4>
    <?php

    // prompt error if user already exist
    if (isset($error)) {
      echo '
        <div class="alert alert-danger" role="alert">
          ' . $error . '
        </div>';
    } else if (isset($_GET['status'])) {
      echo '
        <div class="alert alert-danger" role="alert">
          User has been ' . $_GET['status'] . '
        </div>';
    }


    ?>
    <img src="../images/penro-logo.png" alt="">
    <label for="">Username:</label>
    <input id="username" name="username" class="form-control" type="text" required>
    <label for="">Password:</label>
    <input id="password" name="password" class="form-control" type="password" required>
    <input id="login" name="login" class="btn btn-success" type="submit" value="Log In">
    <p>Not registered?<a href="register-client.php">Create an Account</a></p>
  </form>

</body>

</html>