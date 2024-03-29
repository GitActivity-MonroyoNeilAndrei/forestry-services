<?php

@include "../../database/config.php";
@include "../time.php";
@include "../../upload-data.php";


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
$tax_declaration = "";
$special_power_of_attorney = "";
$tax_declaration_number  = "";
$barangay  = "";
$municipality  = "";
$province = "";
$total_lot_area = "";
$area_devoted_to_plantation = "";
$species = "";
$number_of_trees = "";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!isset($_GET["id"])) {
    header("location: reg-stat-mon-for-draft.php");
    exit;
  }

  $id = $_GET["id"];


  $sql = "SELECT * FROM ptpr_registrations WHERE ptpr_registration_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if (!$row) {
    header("location: reg-stat-mon-for-draft.php");
    exit;
  }

  $name = $row["name"];
  $address = $row["address"];
  $purpose = $row["purpose"];
  $tax_declaration = $row["tax_declaration"];
  $special_power_of_attorney = $row["special_power_of_attorney"];
  $tax_declaration_number  = $row["tax_declaration_number"];
  $barangay  = $row["barangay"];
  $municipality  = $row["municipality"];
  $province = $row["province"];
  $total_lot_area = $row["total_lot_area"];
  $area_devoted_to_plantation = $row["area_devoted_to_plantation"];
  $species = $row["species"];
  $number_of_trees = $row["number_of_trees"];
} else if (isset($_POST['save-draft'])) {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $purpose = $_POST["purpose"];
  $tax_declaration_number  = $_POST["tax-declaration-number"];
  $barangay  = $_POST["barangay"];
  $municipality  = $_POST["municipality"];
  $province = $_POST["province"];
  $total_lot_area = $_POST["total-lot-area"];
  $area_devoted_to_plantation = $_POST["area-devoted-to-plantation"];
  $species = $_POST["species"];
  $number_of_trees = $_POST["number-of-trees"];
  $date_and_time_updated = date('Y-m-d H:i:s');
  $status = 'for-draft';

  $id = $_GET["id"];

  
  

  
  $can_upload_official_receipt = false;
  $can_upload_mayors_permit = false;
  $no_error = true;

    
  if(!fileIsEmpty('tax-declaration')) {    // there's a file uploaded
    if(!fileIsImage('tax-declaration')) {  // it is not a image
      $display_error = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_official_receipt = true;
    }
  } else if (!fileIsEmpty('special-power-of-attorney')){         // there's a file uploaded
    if(!fileIsImage('special-power-of-attorney')) {  // it is not a image
      $display_error2 = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_mayors_permit = true;
    }
  }

  if($can_upload_official_receipt) { // there's a file uploaded
    updateImage('tax-declaration', $conn, 'ptpr_registrations', 'tax_declaration', '../uploads/', ['ptpr_registration_id', $id]);
  }
  if($can_upload_mayors_permit) {   // there's a file uploaded
    updateImage('special-power-of-attorney', $conn, 'ptpr_registrations', 'special_power_of_attorney', '../uploads/', ['ptpr_registration_id', $id]);
  }

  if($no_error) {
    $sql = "UPDATE ptpr_registrations " . "SET name = '$name', address = '$address', purpose = '$purpose',  tax_declaration_number = '$tax_declaration_number', barangay = '$barangay', municipality = '$municipality', province = '$province', total_lot_area = '$total_lot_area', area_devoted_to_plantation = '$area_devoted_to_plantation', species = '$species', number_of_trees = '$number_of_trees', date_and_time_updated = '$date_and_time_updated', received_by = '$admin_username' , status = '$status' " . "WHERE ptpr_registration_id = $id";
    $result = $conn->query($sql);

    header("location: reg-stat-mon-for-draft.php");
  }

} else if (isset($_POST['submit'])) {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $purpose = $_POST["purpose"];
  $tax_declaration_number  = $_POST["tax-declaration-number"];
  $barangay  = $_POST["barangay"];
  $municipality  = $_POST["municipality"];
  $province = $_POST["province"];
  $total_lot_area = $_POST["total-lot-area"];
  $area_devoted_to_plantation = $_POST["area-devoted-to-plantation"];
  $species = $_POST["species"];
  $number_of_trees = $_POST["number-of-trees"];
  $date_and_time_submitted = date('Y-m-d H:i:s');
  $status = "for-submitted";


  $id = $_GET["id"];


  
  $can_upload_official_receipt = false;
  $can_upload_mayors_permit = false;
  $no_error = true;

    
  if(!fileIsEmpty('tax-declaration')) {    // there's a file uploaded
    if(!fileIsImage('tax-declaration')) {  // it is not a image
      $display_error = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_official_receipt = true;
    }
  } else if (!fileIsEmpty('special-power-of-attorney')){         // there's a file uploaded
    if(!fileIsImage('special-power-of-attorney')) {  // it is not a image
      $display_error2 = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_mayors_permit = true;
    }
  }

  if($can_upload_official_receipt) { // there's a file uploaded
    updateImage('tax-declaration', $conn, 'ptpr_registrations', 'tax_declaration', '../uploads/', ['ptpr_registration_id', $id]);
  }
  if($can_upload_mayors_permit) {   // there's a file uploaded
    updateImage('special-power-of-attorney', $conn, 'ptpr_registrations', 'special_power_of_attorney', '../uploads/', ['ptpr_registration_id', $id]);
  }

  if($no_error) {
    $sql = "UPDATE ptpr_registrations " . "SET name = '$name', address = '$address', purpose = '$purpose',  tax_declaration_number = '$tax_declaration_number', barangay = '$barangay', municipality = '$municipality', province = '$province', total_lot_area = '$total_lot_area', area_devoted_to_plantation = '$area_devoted_to_plantation', species = '$species', number_of_trees = '$number_of_trees', date_and_time_submitted = '$date_and_time_submitted', received_by = '$admin_username', status = '$status' " . "WHERE ptpr_registration_id = $id";
    $result = $conn->query($sql);

    header("location: reg-stat-mon-for-submitted.php");
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
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <title>practice website</title>
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
        <!-- tax declaration -->
        <label class="form-label mt-5">Upload Tax Declaration</label>
        <?php
        $id = $_GET["id"];
        $sql1 = "SELECT * FROM ptpr_registrations WHERE ptpr_registration_id = $id";
        $res = $conn->query($sql1);

        if (mysqli_num_rows($res) > 0) {
          while ($images = $res->fetch_assoc()) {
            echo "
                      <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[tax_declaration]'>
                        <img style='height:100%; width:100%;' src='../uploads/$images[tax_declaration]'>
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
          <input type="file" class="form-control" name="tax-declaration">
        </div>
        <!-- mayor's permit -->
        <label class="form-label mt-2">Upload Special Power of Attorney</label>
        <?php
        $sql1 = "SELECT * FROM ptpr_registrations WHERE ptpr_registration_id = $id";
        $res = $conn->query($sql1);

        if (mysqli_num_rows($res) > 0) {
          while ($images = $res->fetch_assoc()) {
            echo "
                      <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[special_power_of_attorney]'>
                        <img style='height:100%; width:100%;' src='../uploads/$images[special_power_of_attorney]'>
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
          <input type="file" class="form-control" name="special-power-of-attorney">
        </div>
      </div>

      <!-- plantation location details -->






      <div class="p-3 col-sm-7">
        <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Plantation Location Details</h5>
          <div class="input-group mb-2">
            <span class="input-group-text">OCT/TCT No/Tax. Dec No.: </span>
            <input type="text" class="form-control" name="tax-declaration-number" value="<?php echo $tax_declaration_number; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Barangay: </span>
            <input type="text" class="form-control" name="barangay" value="<?php echo $barangay; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Municipality: </span>
            <input type="text" class="form-control" name="municipality" value="<?php echo $municipality; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Provice: </span>
            <input type="text" class="form-control" name="province" value="<?php echo $province; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Total Lot Area: </span>
            <input type="text" class="form-control" name="total-lot-area" value="<?php echo $total_lot_area; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Total Lot Area Devoted to Plantation: </span>
            <input type="text" class="form-control" name="area-devoted-to-plantation" value="<?php echo $area_devoted_to_plantation; ?>" required>
          </div>

          <!-- plant details -->
          <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Plant Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">Species: </span>
              <input type="text" class="form-control" name="species" value="<?php echo $species; ?>" required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Number of Trees: </span>
              <input type="number" class="form-control" name="number-of-trees" value="<?php echo $number_of_trees; ?>" required>
            </div>

            <div class="text-center mt-4">
              <input class="btn btn-success mx-2" type="submit" name="save-draft" value="Save as Draft">
              <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
            </div>
      </div>
    </form>

  </div>


</body>

</html>