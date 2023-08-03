<?php

@include "../../database/config.php";
@include "../time.php";

$url_status = "";

if ($_GET['status'] == 'draft') {
  $url_status = "draft";
} else if ($_GET['status'] == 'return') {
  $url_status = 'returned';
}

$admins_no_of_submissions = [];
$admins_id = [];
$choosen_admin = "";
$admin_username = "";

date_default_timezone_set('Asia/Manila');

session_start();

// checks if the user is an ordinary user
if (!isset($_SESSION['username'])) {
  // if not go back to the index file or page
  header('location: ../../login-register-account/login-client.php');
}

$name = "";
$address = "";
$purpose = "";
$pltp = "";
$vehicle_information = "";
$location_from = "";
$location_to = "";
$species = "";
$number_of_trees = "";
$gross_volume = "";
$net_volume = "";
$drivers_name = "";
$or_nummber = "";
$plate_number = "";

$new_img_name1 = "";
$new_img_name2 = "";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!isset($_GET["id"])) {
    header("location: reg-stat-mon-for-draft.php");
    exit;
  }

  $id = $_GET["id"];


  $sql = "SELECT * FROM cov_registrations WHERE cov_registration_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if (!$row) {
    header("location: reg-stat-mon-for-draft.php");
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
} else if (isset($_POST['save-draft'])) {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $purpose = $_POST["purpose"];
  $location_from = $_POST["location-from"];
  $location_to = $_POST["location-to"];
  $species = $_POST["species"];
  $number_of_trees = $_POST["number-of-trees"];
  $gross_volume = $_POST["gross-volume"];
  $net_volume = $_POST["net-volume"];
  $drivers_name = $_POST["drivers-name"];
  $or_number = $_POST["or-number"];
  $plate_number = $_POST["plate-number"];
  $status = "for-draft";

  $id = $_GET["id"];

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

  if ($error1 === 0 && $error2 === 0) {
    $img_ex1 = pathinfo($img_name1, PATHINFO_EXTENSION);
    $img_ex_lc1 = strtolower($img_ex1);

    $img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
    $img_ex_lc2 = strtolower($img_ex2);

    $allowed_exs = array("jpg", "jpeg", "png");

    if (in_array($img_ex_lc1, $allowed_exs) && in_array($img_ex_lc2, $allowed_exs)) {
      $new_img_name1 = uniqid("IMG-", true) . '.' . $img_ex_lc1;
      $new_img_name2 = uniqid("IMG-", true) . '.' . $img_ex_lc2;

      $img_upload_path1 = '../uploads/' . $new_img_name1;
      $img_upload_path2 = '../uploads/' . $new_img_name2;

      move_uploaded_file($tmp_name1, $img_upload_path1);
      move_uploaded_file($tmp_name2, $img_upload_path2);

      // execute the sql  query in the database
      $select = "SELECT * FROM cov_registrations WHERE cov_registration_id = $id";
      $check = $conn->query($select);



      while ($row = $check->fetch_assoc()) {
        unlink("../uploads/" . $row['pltp']);
        unlink("../uploads/" . $row['vehicle_information']);
      }

      // get the minimum submission by an admin
      // ----------------------------
      $sql = "SELECT * FROM admins";
      $admin_results = $conn->query($sql);

      if (!$admin_results) {
        die("Invalid query: " . $conn->error);
      }

      while ($row = $admin_results->fetch_assoc()) {
        array_push($admins_no_of_submissions, $row['number_of_submissions']);
        array_push($admins_id, $row['id']);
      }


      $mins = array_keys($admins_no_of_submissions, min($admins_no_of_submissions));
      $lowest_admin_id = $admins_id[$mins[0]];


      // ---------------------------

      // get the admins id with the lowest submission

      $check = "SELECT * FROM admins WHERE id = $lowest_admin_id";
      $lowest_result = $conn->query($check);

      if (!$lowest_result) {
        die("Invalid Query: " . $conn->error);
      }

      while ($row = $lowest_result->fetch_assoc()) {
        $admin_username = $row['username'];
      }





      $sql = "UPDATE cov_registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', pltp = '$new_img_name1', vehicle_information = '$new_img_name2', location_from = '$location_from', location_to = '$location_to', species = '$species', number_of_trees = '$number_of_trees', gross_volume = '$gross_volume', net_volume = '$net_volume', drivers_name = '$drivers_name', or_number = '$or_number', plate_number = '$plate_number', received_by = '$admin_username', status = '$status' " . "WHERE cov_registration_id = $id";
      $result = $conn->query($sql);

      header("location: reg-stat-mon-for-draft.php");
    } else {
      $display_error = "You can't upload files of this type";
    }
  }
} else if (isset($_POST['submit'])) {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $purpose = $_POST["purpose"];
  $species = $_POST["species"];
  $location_from = $_POST["location-from"];
  $location_to = $_POST["location-to"];
  $number_of_trees = $_POST["number-of-trees"];
  $gross_volume = $_POST["gross-volume"];
  $net_volume = $_POST["net-volume"];
  $drivers_name = $_POST["drivers-name"];
  $or_number = $_POST["or-number"];
  $plate_number = $_POST["plate-number"];
  $date_and_time_submitted = date('Y-m-d H:i:s');
  $status = "for-submitted";


  $id = $_GET["id"];

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



  if ($error1 === 0 && $error2 === 0) {
    $img_ex1 = pathinfo($img_name1, PATHINFO_EXTENSION);
    $img_ex_lc1 = strtolower($img_ex1);

    $img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
    $img_ex_lc2 = strtolower($img_ex2);

    $allowed_exs = array("jpg", "jpeg", "png");

    if (in_array($img_ex_lc1, $allowed_exs) && in_array($img_ex_lc2, $allowed_exs)) {
      $new_img_name1 = uniqid("IMG-", true) . '.' . $img_ex_lc1;
      $new_img_name2 = uniqid("IMG-", true) . '.' . $img_ex_lc2;

      $img_upload_path1 = '../uploads/' . $new_img_name1;
      $img_upload_path2 = '../uploads/' . $new_img_name2;

      move_uploaded_file($tmp_name1, $img_upload_path1);
      move_uploaded_file($tmp_name2, $img_upload_path2);

      // execute the sql  query in the database
      $select = "SELECT * FROM cov_registrations WHERE cov_registration_id = $id";
      $check = $conn->query($select);



      while ($row = $check->fetch_assoc()) {
        unlink("../uploads/" . $row['pltp']);
        unlink("../uploads/" . $row['vehicle_information']);
      }

      // get the minimum submission by an admin
      // ----------------------------
      $sql = "SELECT * FROM admins";
      $admin_results = $conn->query($sql);

      if (!$admin_results) {
        die("Invalid query: " . $conn->error);
      }

      while ($row = $admin_results->fetch_assoc()) {
        array_push($admins_no_of_submissions, $row['number_of_submissions']);
        array_push($admins_id, $row['id']);
      }


      $mins = array_keys($admins_no_of_submissions, min($admins_no_of_submissions));
      $lowest_admin_id = $admins_id[$mins[0]];


      // ---------------------------

      // get the admins id with the lowest submission

      $check = "SELECT * FROM admins WHERE id = $lowest_admin_id";
      $lowest_result = $conn->query($check);

      if (!$lowest_result) {
        die("Invalid Query: " . $conn->error);
      }

      while ($row = $lowest_result->fetch_assoc()) {
        $admin_username = $row['username'];
      }




      $sql = "UPDATE cov_registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', pltp = '$new_img_name1', vehicle_information = '$new_img_name2', location_from = '$location_from', location_to = '$location_to', species = '$species', number_of_trees = '$number_of_trees', gross_volume = '$gross_volume', net_volume = '$net_volume', drivers_name = '$drivers_name', or_number = '$or_number', plate_number = '$plate_number',  received_by = '$admin_username', date_and_time_submitted = '$date_and_time_submitted', status = '$status' " . "WHERE cov_registration_id = $id";
      $result = $conn->query($sql);

      header("location: reg-stat-mon-for-submitted.php");
    } else {
      $display_error = "You can't upload files of this type";
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
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <title>Edit Application</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>

<body>
  <a href="reg-stat-mon-for-<?php echo $url_status; ?>.php"><img src="../../css/icons/arrow-left.svg" class="border rounded" style="width: 50px; height: 50px; position:absolute; left:0.4em; top: 0.4em;" alt="arrow-left"></a>
  <div class="container-xl">

    <h3 class="text-center">Edit Application</h3>
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
                <input class="btn btn-success mx-2" type="submit" name="save-draft" value="Save as Draft">
                <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
                <a class="btn btn-danger mx-2" name="cancel" href="reg-stat-mon-for-draft.php">Cancel</a>
              </div>
      </div>
    </form>

  </div>

  <!-- modal -->
  <div class='modal fade' id='deleteModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h1 class='modal-title fs-5' id='exampleModalLabel'>Warning!</h1>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
        <div class='modal-body'>
          Are You Sure You Want to Log Out?<br>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
          <a class='btn btn-danger' href='../../logout.php'>Log Out</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>