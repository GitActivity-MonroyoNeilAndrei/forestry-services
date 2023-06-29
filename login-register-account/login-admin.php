<?php

  @include "../database/config.php";

  session_start();  

  if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM admins WHERE username = '$username' && password = '$password'";
    $result = $conn->query($select);

    if(!$result) {
      die("Invalid query: ". $conn->error);
    }

    if(mysqli_num_rows($result) > 0) {
      $_SESSION['admin_username'] = $username;
      header("location: ../forestry-services-homepage-admin.php");
    }else{
      $error = "incorrect email or password";
    }
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chainsaw Login</title>
  <link rel="stylesheet" href="../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../css/login-admin.css?<?php echo time(); ?>">
</head>
<body>
  <form method="post" class="container d-flex flex-column justtify-content-center border px-4 py-2 mt-5" style="max-width: 350px">
    <h3 class="text-center border-bottom border-dark pb-1" style="--bs-border-opacity: .5;">Log In Form for <br> ADMIN</h2>

    <?php
    if(isset($error)) {
      echo '
      <div class="alert alert-danger" role="alert">
      '. $error .'
      </div>
      ';
    }
    ?>

    

    <label for="username" class="form-label">Username</label>
    <input type="text" placeholder="username" class="form-control mb-2" name="username" required>
    <label for="password" class="form-label">Password</label>
    <input type="password" placeholder="password" class="form-control mb-2" name="password" required>
    <input type="submit" class="mx-auto my-1 btn btn-primary" value="Log In" name="submit">
    <a href="" class="text-center">Forgot Password?</a>
    <p class="text-center">Not Registered? <a href="register-admin.php">Create an account</a></p>
  </form>
</body>
</html>

