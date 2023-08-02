<?php

@include '../../database/config.php';
@include "../time.php";

date_default_timezone_set('Asia/Manila');

session_start();

if (isset($_GET['id'])) {

  $id = $_GET["id"];


  $sql = "SELECT * FROM registrations WHERE registration_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if (!$row) {
    header("location: list-of-applications.php");
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
}
if (isset($_POST['submit'])) {
  $name = mysqli_escape_string($conn, $_POST['name']);
  $address = mysqli_escape_string($conn, $_POST['address']);
  $purpose = mysqli_escape_string($conn, $_POST['purpose']);
  $brand = mysqli_escape_string($conn, $_POST['brand']);
  $model = mysqli_escape_string($conn, $_POST['model']);
  $serial_number = mysqli_escape_string($conn, $_POST['serial-number']);
  $date_of_acquisition = mysqli_escape_string($conn, $_POST['date-of-acquisition']);
  $power_output = mysqli_escape_string($conn, $_POST['power-output']);
  $maximum_length_of_guidebar = mysqli_escape_string($conn, $_POST['maximum-length-of-guidebar']);
  $country_of_origin = mysqli_escape_string($conn, $_POST['country-of-origin']);
  $purchase_price = mysqli_escape_string($conn, $_POST['purchase-price']);
  $status = "submitted-by-admin";
  $date_now = "PMDQ-CSAW-" . $today['year'] . "-" . check_month($today['mon']) . check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_submitted = $today['year'] . '-' . check_month($today['mon']) . '-' . check_day($today['mday']);




    // insert chainsaw receipt URL to the database
    $img_name1 = $_FILES['chainsaw-official-receipt']['name'];
    $img_size1 = $_FILES['chainsaw-official-receipt']['size'];
    $tmp_name1 = $_FILES['chainsaw-official-receipt']['tmp_name'];
    $error1 = $_FILES['chainsaw-official-receipt']['error'];

    // insert mayors permit URL to the database
    $img_name2 = $_FILES['mayors-permit']['name'];
    $img_size2 = $_FILES['mayors-permit']['size'];
    $tmp_name2 = $_FILES['mayors-permit']['tmp_name'];
    $error2 = $_FILES['mayors-permit']['error'];

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


        $sql = "UPDATE registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', chainsaw_receipt = '$new_img_name1', mayors_permit = '$new_img_name2', brand = '$brand', model = '$model', serial_no = '$serial_number', date_of_acquisition = '$date_of_acquisition', power_output = '$power_output', maximum_length_of_guidebar = '$maximum_length_of_guidebar', country_of_origin = '$country_of_origin', purchase_price = '$purchase_price', date_and_time_submitted = '$date_and_time_submitted', status = '$status' ". "WHERE registration_id = $id";
        $result = $conn->query($sql);


        header("location: list-of-applications.php");
        exit();
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
            <h4 style="display: inline;">Chainsaw > <span class="fs-5">Application for New Registration</span></h4>
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
              <input class="form-control" type="text" name="name" value='<?php echo $name; ?>' required>
              <!-- address -->
              <label class="form-label" for="address">Address</label>
              <input class="form-control" type="text" name="address" value='<?php echo $address; ?>' required>
              <!-- purpose -->
              <label class="form-label" for="purpose">Purpose</label>
              <input class="form-control" type="text" name="purpose" value='<?php echo $purpose; ?>' required>
              <!-- uploading of chainsaw official receipt -->
              <label class="form-label mt-5" for="upload-chainsaw-official-receipt">Upload Chainsaw Official Receipt</label>
              <?php
              $id = $_GET["id"];
              $sql1 = "SELECT * FROM registrations WHERE registration_id = $id";
              $res = $conn->query($sql1);

              if (mysqli_num_rows($res) > 0) {
                while ($images = $res->fetch_assoc()) {
                  echo "
                      <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[chainsaw_receipt]'>
                        <img style='height:100%; width:100%;' src='../uploads/$images[chainsaw_receipt]'>
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
                <input type="file" class="form-control" for="input-chainsaw-receipt" name="chainsaw-official-receipt" required>
              </div>
              <!-- mayor's permit -->
              <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Upload Mayor's Permit</label>

              <?php
              $sql1 = "SELECT * FROM registrations WHERE registration_id = $id";
              $res = $conn->query($sql1);

              if (mysqli_num_rows($res) > 0) {
                while ($images = $res->fetch_assoc()) {
                  echo "
                      <a style='height: 100px; width: 160px;' href='view-document.php?url=$images[mayors_permit]'>
                        <img style='height:100%; width:100%;' src='../uploads/$images[mayors_permit]'>
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
                <input type="file" class="form-control" for="input-mayors-permit" name="mayors-permit" required>
              </div>
            </div>

            <!-- chainsaw complete details -->
            <div class="p-3 col-sm-7">
              <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Chainsaw Complete Details</h5>
                <div class="input-group mb-2">
                  <span class="input-group-text">Brand: </span>
                  <input type="text" class="form-control" name="brand" value='<?php echo $brand; ?>' required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Model: </span>
                  <input type="text" class="form-control" name="model" value='<?php echo $model; ?>' required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Serial No.: </span>
                  <input type="text" class="form-control" name="serial-number" value='<?php echo $serial_number; ?>' required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Date of Acquisition: </span>
                  <input type="text" class="form-control" name="date-of-acquisition" value='<?php echo $date_of_acquisition; ?>' required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Power Output(kW/bhb): </span>
                  <input type="text" class="form-control" name="power-output" value='<?php echo $power_output; ?>' required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Maximum Length of Guidebar: </span>
                  <input type="text" class="form-control" name="maximum-length-of-guidebar" value='<?php echo $maximum_length_of_guidebar; ?>' required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Country of Origin: </span>
                  <input type="text" class="form-control" name="country-of-origin" value='<?php echo $country_of_origin; ?>' required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Purchase Price: </span>
                  <input type="text" class="form-control" name="purchase-price" value='<?php echo $purchase_price; ?>' required>
                </div>
                <div class="text-center mt-4">
                  <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
                  <button class="btn btn-danger mx-2" onclick="history.back();">Cancel</button>
                </div>
            </div>
          </form>

        </div>
      </div>
    </div>

  </div>
</body>

</html>