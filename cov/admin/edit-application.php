<?php

@include '../../database/config.php';
@include "../time.php";
date_default_timezone_set('Asia/Manila');

session_start();

// checks if the user is an ordinary user
if (!isset($_SESSION['admin_username'])) {
  // if not go back to the index file or page
  header('location: ../../login-register-account/login-client.php');
}

if (isset($_GET['id'])) {

  $id = $_GET["id"];


  $sql = "SELECT * FROM cov_registrations WHERE cov_registration_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if (!$row) {
    header("location: list-of-applications.php");
    exit;
  }

  $name = $row["name"];
  $address = $row["address"];
  $purpose = $row["purpose"];
  $pltp = $row["pltp"];
  $vehicle_information = $row["vehicle_information"];
  $location_from = $row["location_from"];
  $location_to = $row["location_to"];
  $species = $row["species"];
  $number_of_trees = $row["number_of_trees"];
  $gross_volume = $row["gross_volume"];
  $net_volume = $row["net_volume"];
  $drivers_name = $row["drivers_name"];
  $or_number = $row["or_number"];
  $plate_number = $row["plate_number"];
}
if (isset($_POST['submit'])) {
  $cov_client_id =  $_SESSION['cov_client_id'];
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
  $date_now = "PMDQ-COV-" . $today['year'] . "-" . check_month($today['mon']) . check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_submitted = date('Y-m-d H:i:s');




  $can_upload_official_receipt = false;
  $can_upload_mayors_permit = false;
  $no_error = true;


  if (!fileIsEmpty('pltp')) {    // there's a file uploaded
    if (!fileIsImage('pltp')) {  // it is not a image
      $display_error = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_official_receipt = true;
    }
  } else if (!fileIsEmpty('vehicle-information')) {         // there's a file uploaded
    if (!fileIsImage('vehicle-information')) {  // it is not a image
      $display_error2 = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_mayors_permit = true;
    }
  }

  if ($can_upload_official_receipt) { // there's a file uploaded
    updateImage('pltp', $conn, 'cov_registrations', 'pltp', '../uploads/', ['cov_registration_id', $id]);
  }
  if ($can_upload_mayors_permit) {   // there's a file uploaded
    updateImage('vehicle-information', $conn, 'cov_registrations', 'vehicle_information', '../uploads/', ['cov_registration_id', $id]);
  }

  if ($no_error) {
    $sql = "UPDATE registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', brand = '$brand', model = '$model', serial_no = '$serial_number', date_of_acquisition = '$date_of_acquisition', power_output = '$power_output', maximum_length_of_guidebar = '$maximum_length_of_guidebar', country_of_origin = '$country_of_origin', purchase_price = '$purchase_price', date_and_time_submitted = '$date_and_time_submitted', status = '$status' " . "WHERE registration_id = $id";
    $result = $conn->query($sql);


    header("location: list-of-applications.php");
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
  <title>Edit Application</title>
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
            <button class="btn btn-danger mx-2" onclick="history.back();">Back</button>

          </div>
          <form class="row" method="post" enctype="multipart/form-data">
            <?php
            if (isset($error)) {
              echo '
                <div class="alert alert-danger" role="alert">
                ' . $error . '
                </div>
                ';
            }
            ?>
            <!-- name address chuchu -->
            <div class="border-end border-primary d-flex flex-column px-4 py-2 col-sm-5">
              <!-- name -->
              <label class="form-label" for="name">Name</label>
              <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" required>
              <!-- address -->
              <label class="form-label" for="address">Address</label>
              <input class="form-control" type="text" name="address" value="<?php echo $address; ?>" required>
              <!-- purpose -->
              <label class="form-label" for="purpose">Purpose</label>
              <input class="form-control" type="text" name="purpose" value="<?php echo $purpose; ?>" required>
              <!-- uploading of chainsaw official receipt -->
              <label class="form-label mt-5" for="upload-chainsaw-official-receipt">PLTP</label>
              <?php
              $id = $_GET["id"];
              $sql1 = "SELECT * FROM cov_registrations WHERE cov_registration_id = $id";
              $res = $conn->query($sql1);

              if (mysqli_num_rows($res) > 0) {
                while ($images = $res->fetch_assoc()) {
                  echo "
                      <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[pltp]'>
                        <img style='height:100%; width:100%;' src='../uploads/$images[pltp]'>
                      </a>
                    ";
                }
              }
              ?>

              <?php
              if (isset($display_error)) {
                echo '
                <div class="alert alert-danger" role="alert">
                ' . $display_error . '
                </div>
                ';
              }
              ?>
              <div class="d-flex flex-column">
                <input type="file" class="form-control" for="input-chainsaw-receipt" name="pltp" required>
              </div>
              <!-- mayor's permit -->
              <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Vehicle Information</label>

              <?php
              $sql1 = "SELECT * FROM cov_registrations WHERE cov_registration_id = $id";
              $res = $conn->query($sql1);

              if (mysqli_num_rows($res) > 0) {
                while ($images = $res->fetch_assoc()) {
                  echo "
                      <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[vehicle_information]'>
                        <img style='height:100%; width:100%;' src='../uploads/$images[vehicle_information]'>
                      </a>
                    ";
                }
              }
              ?>

              <?php
              if (isset($display_error)) {
                echo '
                <div class="alert alert-danger" role="alert">
                ' . $display_error . '
                </div>
                ';
              }
              ?>
              <div class="d-flex flex-column">
                <input type="file" class="form-control" for="input-mayors-permit" name="vehicle-information" required>
              </div>
            </div>

            <!-- chainsaw complete details -->
            <div class="p-3 col-sm-7">
              <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Plantation Location Details</h5>
                <div class="input-group mb-2">
                  <span class="input-group-text">Location (From): </span>
                  <input type="text" class="form-control" name="location-from" value="<?php echo $location_from; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Location (To): </span>
                  <input type="text" class="form-control" name="location-to" value="<?php echo $location_to; ?>" required>
                </div>
                <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Wood Details</h5>
                  <div class="input-group mb-2">
                    <span class="input-group-text">Species: </span>
                    <input type="text" class="form-control" name="species" value="<?php echo $species; ?>" required>
                  </div>
                  <div class="input-group mb-2">
                    <span class="input-group-text">Number_of_Trees: </span>
                    <input type="number" class="form-control" name="number-of-trees" value="<?php echo $number_of_trees; ?>" required>
                  </div>
                  <div class="input-group mb-2">
                    <span class="input-group-text">Gross Volume: </span>
                    <input type="text" class="form-control" name="gross-volume" value="<?php echo $gross_volume; ?>" required>
                  </div>
                  <div class="input-group mb-2">
                    <span class="input-group-text">Net Volume: </span>
                    <input type="text" class="form-control" name="net-volume" value="<?php echo $net_volume; ?>" required>
                  </div>
                  <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Vehicle Details</h5>
                    <div class="input-group mb-2">
                      <span class="input-group-text">Driver's Name: </span>
                      <input type="text" class="form-control" name="drivers-name" value="<?php echo $drivers_name; ?>" required>
                    </div>
                    <div class="input-group mb-2">
                      <span class="input-group-text">OR number: </span>
                      <input type="text" class="form-control" name="or-number" value="<?php echo $or_number; ?>" required>
                    </div>
                    <div class="input-group mb-2">
                      <span class="input-group-text">Plate Number: </span>
                      <input type="text" class="form-control" name="plate-number" value="<?php echo $plate_number; ?>" required>
                    </div>
                    <div class="text-center mt-4">
                      <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
                      <button class="btn btn-danger mx-2" type="button"  onclick="location.href='list-of-applications.php'">Cancel</button>

                    </div>
            </div>
          </form>

        </div>
      </div>
    </div>

  </div>
</body>

</html>