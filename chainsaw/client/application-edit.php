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
$chainsaw_official_receipt = "";
$mayors_permit = "";
$brand = "";
$model = "";
$serial_number = "";
$date_of_aquisition = "";
$power_output = "";
$maximum_length_of_guidebar = "";
$country_of_origin = "";
$purchase_price = "";
$chainsaw_store = "";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!isset($_GET["id"])) {
    header("location: reg-stat-mon-for-draft.php");
    exit;
  }

  $id = $_GET["id"];


  $sql = "SELECT * FROM registrations WHERE registration_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if (!$row) {
    header("location: reg-stat-mon-for-draft.php");
    exit;
  }

  $name = $row["name"];
  $address = $row["address"];
  $purpose = $row["purpose"];
  $chainsaw_official_receipt = $row["chainsaw_receipt"];
  $mayors_permit = $row["mayors_permit"];
  $brand = $row["brand"];
  $model = $row["model"];
  $serial_number = $row["serial_no"];
  $date_of_acquisition = $row["date_of_acquisition"];
  $power_output = $row["power_output"];
  $maximum_length_of_guidebar = $row["maximum_length_of_guidebar"];
  $country_of_origin = $row["country_of_origin"];
  $purchase_price = $row["purchase_price"];
  $chainsaw_store = $row["chainsaw_store"];
} else if (isset($_POST['save-draft'])) {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $purpose = $_POST["purpose"];
  $brand = $_POST["brand"];
  $model = $_POST["model"];
  $serial_number = $_POST["serial-number"];
  $date_of_acquisition = $_POST["date-of-acquisition"];
  $power_output = $_POST["power-output"];
  $maximum_length_of_guidebar = $_POST["maximum-length-of-guidebar"];
  $country_of_origin = $_POST["country-of-origin"];
  $purchase_price = $_POST["purchase-price"];
  $chainsaw_store = $_POST["accredited-chainsaw"];

  $id = $_GET["id"];

  $can_upload_official_receipt = false;
  $can_upload_mayors_permit = false;
  $no_error = true;

    
  if(!fileIsEmpty('chainsaw-official-receipt')) {    // there's a file uploaded
    if(!fileIsImage('chainsaw-official-receipt')) {  // it is not a image
      $display_error = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_official_receipt = true;
    }
  } else if (!fileIsEmpty('mayors-permit')){         // there's a file uploaded
    if(!fileIsImage('mayors-permit')) {  // it is not a image
      $display_error2 = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_mayors_permit = true;
    }
  }

  if($can_upload_official_receipt) { // there's a file uploaded
    updateImage('chainsaw-official-receipt', $conn, 'registrations', 'chainsaw_receipt', '../uploads/', ['registration_id', $id]);
  }
  if($can_upload_mayors_permit) {   // there's a file uploaded
    updateImage('mayors-permit', $conn, 'registrations', 'mayors_permit', '../uploads/', ['registration_id', $id]);
  }

  if($no_error) {
    $sql = "UPDATE registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', brand = '$brand', model = '$model', serial_no = '$serial_number', date_of_acquisition = '$date_of_acquisition', power_output = '$power_output', maximum_length_of_guidebar = '$maximum_length_of_guidebar', country_of_origin = '$country_of_origin', purchase_price = '$purchase_price', chainsaw_store = '$chainsaw_store', date_and_time_submitted = '$date_and_time_submitted', status = 'for-draft' " . "WHERE registration_id = $id";
    $result = $conn->query($sql);

    header("location: reg-stat-mon-for-draft.php");
  }

} else if (isset($_POST['submit'])) {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $purpose = $_POST["purpose"];
  $brand = $_POST["brand"];
  $model = $_POST["model"];
  $serial_number = $_POST["serial-number"];
  $date_of_acquisition = $_POST["date-of-acquisition"];
  $power_output = $_POST["power-output"];
  $maximum_length_of_guidebar = $_POST["maximum-length-of-guidebar"];
  $country_of_origin = $_POST["country-of-origin"];
  $purchase_price = $_POST["purchase-price"];
  $chainsaw_store = $_POST["accredited-chainsaw"];
  $date_and_time_submitted = date('Y-m-d H:i:s');
  $status = "for-submitted";


  $id = $_GET["id"];


  $can_upload_official_receipt = false;
  $can_upload_mayors_permit = false;
  $no_error = true;

    
  if(!fileIsEmpty('chainsaw-official-receipt')) {    // there's a file uploaded
    if(!fileIsImage('chainsaw-official-receipt')) {  // it is not a image
      $display_error = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_official_receipt = true;
    }
  } else if (!fileIsEmpty('mayors-permit')){         // there's a file uploaded
    if(!fileIsImage('mayors-permit')) {  // it is not a image
      $display_error2 = "You can't upload files of this type";
      $no_error = false;
    } else {
      $can_upload_mayors_permit = true;
    }
  }

  if($can_upload_official_receipt) { // there's a file uploaded
    updateImage('chainsaw-official-receipt', $conn, 'registrations', 'chainsaw_receipt', '../uploads/', ['registration_id', $id]);
  }
  if($can_upload_mayors_permit) {   // there's a file uploaded
    updateImage('mayors-permit', $conn, 'registrations', 'mayors_permit', '../uploads/', ['registration_id', $id]);
  }

  if($no_error) {
    $sql = "UPDATE registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', brand = '$brand', model = '$model', serial_no = '$serial_number', date_of_acquisition = '$date_of_acquisition', power_output = '$power_output', maximum_length_of_guidebar = '$maximum_length_of_guidebar', country_of_origin = '$country_of_origin', purchase_price = '$purchase_price', chainsaw_store = '$chainsaw_store', received_by = '$admin_username', date_and_time_submitted = '$date_and_time_submitted', status = '$status' " . "WHERE registration_id = $id";
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
  <link rel="icon" href="../../img/penro-logo.png">
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
        <input class="form-control" type="text" name="name" placeholder='ex. "Neil Andrei G. Monroyo"' value="<?php echo $name; ?>" required>
        <!-- address -->
        <label class="form-label" for="address">Address</label>
        <input class="form-control" type="text" name="address" placeholder='ex. Bunganay, Boac, Marinduque' value="<?php echo $address; ?>" required>
        <!-- purpose -->
        <label class="form-label" for="purpose">Purpose</label>
        <input class="form-control" type="text" name="purpose" placeholder='ex. "for cutting lumber"' value="<?php echo $purpose; ?>" required>
        <!-- uploading of chainsaw official receipt -->
        <label class="form-label mt-5" for="upload-chainsaw-official-receipt">Change Chainsaw Official Receipt</label>
        <?php
        $id = $_GET["id"];
        $sql1 = "SELECT * FROM registrations WHERE registration_id = $id";
        $res = $conn->query($sql1);

        if (mysqli_num_rows($res) > 0) {
          while ($images = $res->fetch_assoc()) {
            if($images['chainsaw_receipt'] != "") {
              echo "
              <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[chainsaw_receipt]'>
                <img style='height:100%; width:100%;' src='../uploads/$images[chainsaw_receipt]'>
              </a>
            ";
            }

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
          <input type="file" class="form-control" for="input-chainsaw-receipt" name="chainsaw-official-receipt">
        </div>
        <!-- mayor's permit -->
        <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Change Mayor's Permit</label>

        <?php
        $sql1 = "SELECT * FROM registrations WHERE registration_id = $id";
        $res = $conn->query($sql1);

        if (mysqli_num_rows($res) > 0) {
          while ($images = $res->fetch_assoc()) {
            if($images['mayors_permit'] != "") {
                  echo "
              <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[mayors_permit]'>
                <img style='height:100%; width:100%;' src='../uploads/$images[mayors_permit]'>
              </a>
            ";
            }

          }
        }
        ?>

        <?php
        if (isset($display_error2)) {
          echo '
                <div class="alert alert-danger" role="alert">
                ' . $display_error2 . '
                </div>
                ';
        }
        ?>
        <div class="d-flex flex-column">
          <input type="file" class="form-control" for="input-mayors-permit" name="mayors-permit">
        </div>
      </div>

      <!-- chainsaw complete details -->
      <div class="p-3 col-sm-7">
        <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Chainsaw Complete Details</h5>
          <div class="input-group mb-2">
            <span class="input-group-text">Brand: </span>
            <input type="text" class="form-control" name="brand" placeholder='ex. "STIHL" ' value="<?php echo $brand; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Model: </span>
            <input type="text" class="form-control" name="model" placeholder='ex. "MS 070"' value="<?php echo $model; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Serial No.: </span>
            <input type="text" class="form-control" name="serial-number" placeholder='ex. "S188128299"' value="<?php echo $serial_number; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Date of Acquisition: </span>
            <input type="text" class="form-control" name="date-of-acquisition" placeholder='ex. "november 28. 2020"' value="<?php echo $date_of_acquisition; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Power Output(kW/bhb): </span>
            <input type="text" class="form-control" name="power-output" placeholder='ex. "1.0 Hp"' value="<?php echo $power_output; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Maximum Length of Guidebar: </span>
            <input type="text" class="form-control" name="maximum-length-of-guidebar" placeholder='ex. "36 inches"' value="<?php echo $maximum_length_of_guidebar; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Country of Origin: </span>
            <input type="text" class="form-control" name="country-of-origin" placeholder='ex. "Germany"' value="<?php echo $country_of_origin; ?>" required>
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Purchase Price: </span>
            <input type="text" class="form-control" name="purchase-price" placeholder='ex. "60000"' value="<?php echo $purchase_price; ?>" required>
          </div>
          <label class="form-label" for="accredited-chainsaw">Where did you Buy your Chainsaw?:</label>
          <select class="form-select mx-auto" name="accredited-chainsaw">
            <?php

            $select3 = "SELECT * FROM chainsaw_stores";
            $result3 = $conn->query($select3);
            while ($row3 = $result3->fetch_assoc()) {
            ?>
              <option <?php if ($chainsaw_store == $row3['bus_name']) {
                        echo 'selected';
                      } ?> value="<?php echo $row3['bus_name']; ?>"><?php echo $row3['bus_name']; ?></option>
            <?php } ?>
          </select>
          <div class="text-center mt-4">
            <input class="btn btn-success mx-2" type="submit" name="save-draft" value="Save as Draft">
            <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
            <a class="btn btn-danger mx-2" name="cancel" href="reg-stat-mon-for-draft.php">Cancel</a>
          </div>
      </div>
    </form>

  </div>

</body>

</html>