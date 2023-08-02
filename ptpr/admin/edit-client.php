<?php
  @include "../../database/config.php";

  $id = "";
  $username = "";
  $business_name = "";
  $owners_name = "";
  $address = "";
  $contact_number = "";
  $email_address = "";
  $sex = "";

  $errorMessage = "";
  $successMessage = "";

  if($_SERVER['REQUEST_METHOD'] == 'GET') {

    if(!isset($_GET["id"])) {
      header("location: crude-clients.php");
      exit;
    }
    $id = $_GET["id"];

    $select = "SELECT * FROM clients WHERE client_id = $id";
    $result = $conn->query($select);
    $row = $result->fetch_assoc();

    if(!$row) {
      header("location: crude-clients.php");
      exit;
    }
  
    $username = $row["username"];
    $business_name = $row["business_name"];
    $owners_name = $row["owners_name"];
    $address = $row["address"];
    $contact_number = $row["contact_number"];
    $email_address = $row["email_address"];
    $sex = $row['sex'];
  }else {

    $id = $_POST["id"];
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $business_name = mysqli_real_escape_string($conn, $_POST["business_name"]);
    $owners_name = mysqli_real_escape_string($conn, $_POST["owners_name"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $contact_number = mysqli_real_escape_string($conn, $_POST["contact_number"]);
    $email_address = mysqli_real_escape_string($conn, $_POST["email_address"]);

    $sql = "UPDATE clients SET username = '$username', business_name = '$business_name', owners_name = '$owners_name', address = '$address', contact_number = '$contact_number', email_address = '$email_address' WHERE clients.client_id = $id";
    $result = $conn->query($sql);

    if(!$result) {
      $errorMessage = "Invalid query: " . $conn->error;
    }else {
      $successMessage = "Client update correctly";

      header("location: crude-clients.php");
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
  <title>Edit Client</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time();?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>
<body>
<div class="container my-5">
  <h2>Edit Client</h2>
  
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
        <label class="col-sm-3 col-form-label">Business Name</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="business_name" value="<?php echo $business_name; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Owner's Name</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="owners_name" value="<?php echo $owners_name; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Contact Number</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="contact_number" value="<?php echo $contact_number; ?>">
        </div>
      </div>
      <div class="row mb-3"> 
        <label class="col-sm-3 col-form-label">Email Address</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" name="email_address" value="<?php echo $email_address; ?>">
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
          <a class="btn btn-outline-primary" href="crude-clients.php" role="button">Cancel</a>
        </div>
      </div>
    </form>
</div>


</body>
</html>