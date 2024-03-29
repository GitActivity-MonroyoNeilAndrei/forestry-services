<?php

@include '../../database/config.php';
@include "../time.php";
date_default_timezone_set('Asia/Manila');

session_start();

// checks if the user is an ordinary user
if(!isset($_SESSION['admin_username'])){
  // if not go back to the index file or page
  header('location: ../../login-register-account/login-client.php');
}



if(isset($_POST['submit'])){
  $name = mysqli_escape_string($conn, $_POST['name']);
  $address = mysqli_escape_string($conn, $_POST['address']);
  $purpose = mysqli_escape_string($conn, $_POST['purpose']);
  $location_from = mysqli_escape_string($conn, $_POST['location-from']);
  $location_to = mysqli_escape_string($conn, $_POST['location-to']);
  $species = mysqli_escape_string($conn, $_POST['species']);
  $number_of_trees = mysqli_escape_string($conn, $_POST['number-of-trees']);
  $gross_volume = mysqli_escape_string($conn, $_POST['gross-volume']);
  $net_volume = mysqli_escape_string($conn, $_POST['net-volume']);
  $drivers_name = mysqli_escape_string($conn, $_POST['drivers-name']);
  $or_number = mysqli_escape_string($conn, $_POST['or-number']);
  $plate_number = mysqli_escape_string($conn, $_POST['plate-number']);
  $status = "submitted-by-admin";
  $date_now = "PMDQ-COV-". $today['year'] . "-" . check_month($today['mon']). check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_submitted = date('Y-m-d H:i:s');



  $select = "SELECT * FROM cov_registrations WHERE name = '$name' && location_to = '$location_to' && status = '$status'";
  $check = $conn->query($select);



  if(mysqli_num_rows($check) > 0){
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'chainsaw already registered!';
    //get the clientID
    
  }else {
    

    // insert chainsaw receipt URL to the database
    $img_name1 = $_FILES['pltp']['name'];
    $img_size1 = $_FILES['pltp']['size'];
    $tmp_name1 = $_FILES['pltp']['tmp_name'];
    $error1 = $_FILES['pltp']['error'];

    // insert mayors permit URL to the database
    $img_name2 = $_FILES['vehicle-information']['name'];
    $img_size2 = $_FILES['vehicle-information']['size'];
    $tmp_name2 = $_FILES['vehicle-information']['tmp_name'];
    $error2 = $_FILES['vehicle-information']['error'];

    if($error1 === 0 && $error2 === 0) {
        $img_ex1 = pathinfo($img_name1, PATHINFO_EXTENSION);
        $img_ex_lc1 = strtolower($img_ex1);

        $img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
        $img_ex_lc2 = strtolower($img_ex2);

        $allowed_exs = array("jpg", "jpeg", "png");

        if (in_array($img_ex_lc1, $allowed_exs) && in_array($img_ex_lc2, $allowed_exs))  {
          $new_img_name1 = uniqid("IMG-", true).'.'.$img_ex_lc1;
          $new_img_name2 = uniqid("IMG-", true).'.'.$img_ex_lc2;

          $img_upload_path1 = '../uploads/'.$new_img_name1;
          $img_upload_path2 = '../uploads/'.$new_img_name2;

          move_uploaded_file($tmp_name1, $img_upload_path1);
          move_uploaded_file($tmp_name2, $img_upload_path2);



          
          $insert = "INSERT INTO cov_registrations (registration_number, name, address, purpose, pltp, vehicle_information, location_from, location_to, species, number_of_trees, gross_volume, net_volume, drivers_name, or_number, plate_number, uploaded_requirements, date_and_time_submitted, status) " . "VALUES ('$date_now', '$name', '$address', '$purpose', '$new_img_name1', '$new_img_name2', '$location_from', '$location_to', '$species', '$number_of_trees', '$gross_volume', '$net_volume', '$drivers_name', '$or_number', '$plate_number',  '$uploaded_requirements', '$date_and_time_submitted', '$status')";
          $result = $conn->query($insert);

          
          header("location: list-of-applications.php");
          exit();
          

        }else{
          $display_error = "You can't upload files of this type";
        }
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta  name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../img/penro-logo.png">
  <title>Add New Application</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/reg-stat-mon.css?<?php echo time(); ?>">
</head>

<body>
  <div class="body">
    <div class="header bg-green-1">
      <div class="d-flex align-items-center"><a href="../../forestry-services-homepage-admin.php"><img class="header-logo" src="../../img/penro-logo.png" alt="msc logo"></a>
        <h3 class=" header-texts">PENRO</h3>
      </div>
      <div class="dropdown">
        <button class="dropbtn"><?php echo $_SESSION["admin_username"]; ?></button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../../logout.php">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header d-flex justify-content-between align-items-center">
            <h4 style="display: inline;">COV > <span class="fs-5">Application for New Registration</span></h4>
            <button class="btn btn-danger" onclick="history.back();">Back</button>
          </div>
          <form class="row" method="post" enctype="multipart/form-data">
        <?php
              if(isset($error)){
                echo '
                <div class="alert alert-danger" role="alert">
                '.$error.'
                </div>
                ';
              }
            ?>
          <!-- name address chuchu -->
          <div class="border-end border-primary d-flex flex-column px-4 py-2 col-sm-5">
            <!-- name -->
            <label class="form-label" for="name">Name</label>
            <input class="form-control" type="text" name="name"  required>
            <!-- address -->
            <label class="form-label" for="address">Address</label>
            <input class="form-control" type="text" name="address"  required>
            <!-- purpose -->
            <label class="form-label" for="purpose">Purpose</label>
            <input class="form-control" type="text" name="purpose" required>
            <!-- uploading of chainsaw official receipt -->
            <label class="form-label mt-5" for="pltp">PLTP</label>
            <?php
              if(isset($display_error)){
                echo '
                <div class="alert alert-danger" role="alert">
                '.$display_error.'
                </div>
                ';
              }
            ?>
            <div class="d-flex flex-column">
              <input type="file" class="form-control" name="pltp" required>
            </div>
            <!-- mayor's permit -->
            <label class="form-label mt-2" for="vehicle-information">Vehicle Information including driver's License</label>
            <?php
              if(isset($display_error)){
                echo '
                <div class="alert alert-danger" role="alert">
                '.$display_error.'
                </div>
                ';
              }
            ?>
            <div class="d-flex flex-column">
              <input type="file" class="form-control" name="vehicle-information" required>
            </div>
          </div>
    
          <!-- chainsaw complete details -->
          <div class="p-3 col-sm-7">
            <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Plantation Location Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">Location (From): </span>
              <input type="text" class="form-control" name="location-from" required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Location (To): </span>
              <input type="text" class="form-control" name="location-to"  required>
            </div>
            <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Wood Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">Species: </span>
              <input type="text" class="form-control" name="species" required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Number Of Trees: </span>
              <input type="number" class="form-control" name="number-of-trees" required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Gross Volume: </span>
              <input type="text" class="form-control" name="gross-volume"  required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Net Volume: </span>
              <input type="text" class="form-control" name="net-volume" required>
            </div>
            <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Vehicle Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">Driver's Name: </span>
              <input type="text" class="form-control" name="drivers-name" required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">OR Number: </span>
              <input type="text" class="form-control" name="or-number" required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Plate Number: </span>
              <input type="text" class="form-control" name="plate-number"  required>
            </div>
            <div class="text-center mt-4">
              <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
            </div>
          </div>
        </form>

        </div>
      </div>
    </div>

  </div>
</body>

</html>