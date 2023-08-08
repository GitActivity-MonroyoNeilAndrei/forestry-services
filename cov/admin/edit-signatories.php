<?php
  @include "../../database/config.php";

  $id = "";
  $username = "";
  $first_name = "";
  $last_name = "";
  $address = "";
  $email_address = "";
  $sex = "";
  $type_of_user = "";

  $errorMessage = "";
  $successMessage = "";

  if($_SERVER['REQUEST_METHOD'] == 'GET') {

    if(!isset($_GET["id"])) {
      header("location: crude-signatories.php");
      exit;
    }
    $id = $_GET["id"];

    $select = "SELECT * FROM signatories WHERE signatories_id = $id";
    $result = $conn->query($select);
    $row = $result->fetch_assoc();

    if(!$row) {
      header("location: crude-signatories.php");
      exit;
    }


    $username = $row['username'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $address = $row['address'];
    $email_address = $row['email_address'];
    $sex = $row['sex'];
    $type_of_user = $row['type_of_user'];
  
  }else {



    $id = $_POST["id"];
    $username = mysqli_escape_string($conn, $_POST['username']);
    $first_name = mysqli_escape_string($conn, $_POST['first-name']);
    $last_name = mysqli_escape_string($conn, $_POST['last-name']);
    $address = mysqli_escape_string($conn, $_POST['address']);
    $email_address = mysqli_escape_string($conn, $_POST['email-address']);
    $sex = mysqli_escape_string($conn, $_POST['sex']);
    $type_of_user = mysqli_escape_string($conn, $_POST['type-of-user']);


    $sql = "UPDATE signatories SET username = '$username', first_name = '$first_name', last_name = '$last_name', address = '$address', email_address = '$email_address', sex = '$sex', type_of_user = '$type_of_user' WHERE signatories.signatories_id = $id";
    $result = $conn->query($sql);

    if(!$result) {
      $errorMessage = "Invalid query: " . $conn->error;
    }else {
      $successMessage = "Signatory update correctly";

      header("location: crude-signatories.php");
      exit;
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
  <title>Edit Signatories</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time();?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>
<body>
<div class="container my-5">
  <h2>Edit Signatories</h2>
  
    <?php 
      if( !empty($errorMessage)) {
        echo "
          <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>
          ";

      }
    ?>



  <form method="post">
      <input type="hidden" name="id" value="<?php echo $id;  ?>">
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">UserName</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">First Name</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="first-name" value="<?php echo $first_name; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Last Name</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="last-name" value="<?php echo $last_name; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Email Address</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="email-address" value="<?php echo $email_address; ?>">
        </div>
      </div>

      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Sex</label>
        <div class="col-sm-6">
          <select class="form-select" name="sex">
            <option <?php if($sex == 'male') {echo 'selected';} ?> value="male">Male</option>
            <option <?php if($sex == 'female') {echo 'selected';} ?>  value="female">Female</option>
          </select>
        </div>
      </div>

      
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="type-of-user">Type of User</label>
        <div class="col-sm-6">
          <select class="form-select" name="type-of-user">
            <option value="order of payment signatories">Order of Payment Signatories</option>
            <option value="permit signatories">Permit Signatories</option>
            <option value="issuing and releasing personnel">Issuing and Releasing Personnel</option>
          </select>
        </div>
      </div>




      <?php
        if ( !empty($successMessage) ) {
          echo "
          <div class='row mb-3'>
            <div class='offset-sm-3 col-sm-6'>
              <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>
            </div>
          </div>
          ";
        }
      ?>

      <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid"> 
          <button type="submit" class="btn btn-primary" >Update</button>
        </div>
        <div class="col-sm-3 d-grid">
          <a class="btn btn-outline-primary" href="crude-signatories.php" role="button">Cancel</a>
        </div>
      </div>
    </form>
</div>


</body>
</html>