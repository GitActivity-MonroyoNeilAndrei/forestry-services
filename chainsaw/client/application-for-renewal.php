<?php
@include '../../database/config.php';

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
$serial_no = "";
$date_of_acquisition = "";
$power_output = "";
$maximum_length_of_guidebar = "";
$country_of_origin = "";
$purchase_price = "";
$purpose = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (isset($_GET['id'])) {
    if ($_GET['id'] == "" || $_GET['id'] == NULL) {
      header('location: verification-for-renewal.php');
    }
    $select = "SELECT * FROM registrations WHERE permit_number = '$_GET[id]'";
    $result = $conn->query($select);

    while ($row = $result->fetch_assoc()) {

      $name = $row['name'];
      $address = $row['address'];
      $purpose = $row['purpose'];
      $chainsaw_official_receipt = $row['chainsaw_receipt'];
      $mayors_permit = $row['mayors_permit'];
      $brand = $row['brand'];
      $model = $row['model'];
      $serial_no = $row['serial_no'];
      $date_of_acquisition = $row['date_of_acquisition'];
      $power_output = $row['power_output'];
      $maximum_length_of_guidebar = $row['maximum_length_of_guidebar'];
      $country_of_origin = $row['country_of_origin'];
      $purchase_price = $row['purchase_price'];
      $purpose = $row['purpose'];
    }
  }
} else if (isset($_POST['submit'])) {

  $name = mysqli_escape_string($conn, $_POST['name']);
  $address = mysqli_escape_string($conn, $_POST['address']);
  $purpose = mysqli_escape_string($conn, $_POST['purpose']);
  $brand = mysqli_escape_string($conn, $_POST['brand']);
  $model = mysqli_escape_string($conn, $_POST['model']);
  $serial_no = mysqli_escape_string($conn, $_POST['serial-number']);
  $date_of_acquisition = mysqli_escape_string($conn, $_POST['date-of-acquisition']);
  $power_output = mysqli_escape_string($conn, $_POST['power-output']);
  $maximum_length_of_guidebar = mysqli_escape_string($conn, $_POST['maximum-length-of-guidebar']);
  $country_of_origin = mysqli_escape_string($conn, $_POST['country-of-origin']);
  $purchase_price = mysqli_escape_string($conn, $_POST['purchase-price']);
  $purpose = mysqli_escape_string($conn, $_POST['purpose']);



  // MAKE THIS UPLOAD THREE PICTURES AT A TIME
  // <========================================================>
  $img_name1 = $_FILES['chainsaw-official-receipt']['name'];
  $img_size1 = $_FILES['chainsaw-official-receipt']['size'];
  $tmp_name1 = $_FILES['chainsaw-official-receipt']['tmp_name'];
  $error1 = $_FILES['chainsaw-official-receipt']['error'];

  // insert mayors permit URL to the database
  $img_name2 = $_FILES['mayors-permit']['name'];
  $img_size2 = $_FILES['mayors-permit']['size'];
  $tmp_name2 = $_FILES['mayors-permit']['tmp_name'];
  $error2 = $_FILES['mayors-permit']['error'];

  $img_name3 = $_FILES['new-document']['name'];
  $img_size3 = $_FILES['new-document']['size'];
  $tmp_name3 = $_FILES['new-document']['tmp_name'];
  $error3 = $_FILES['new-document']['error'];

  if ($error1 === 0 && $error2 === 0 && $error3 == 0) {
    $img_ex1 = pathinfo($img_name1, PATHINFO_EXTENSION);
    $img_ex_lc1 = strtolower($img_ex1);

    $img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
    $img_ex_lc2 = strtolower($img_ex2);

    $img_ex3 = pathinfo($img_name3, PATHINFO_EXTENSION);
    $img_ex_lc3 = strtolower($img_ex3);

    $allowed_exs = array("jpg", "jpeg", "png");

    if (in_array($img_ex_lc1, $allowed_exs) && in_array($img_ex_lc2, $allowed_exs) && in_array($img_ex_lc3, $allowed_exs)) {
      $new_img_name1 = uniqid("IMG-", true) . '.' . $img_ex_lc1;
      $new_img_name2 = uniqid("IMG-", true) . '.' . $img_ex_lc2;
      $new_img_name3 = uniqid("IMG-", true) . '.' . $img_ex_lc3;

      $img_upload_path1 = '../uploads/' . $new_img_name1;
      $img_upload_path2 = '../uploads/' . $new_img_name2;
      $img_upload_path3 = '../uploads/' . $new_img_name3;

      move_uploaded_file($tmp_name1, $img_upload_path1);
      move_uploaded_file($tmp_name2, $img_upload_path2);
      move_uploaded_file($tmp_name3, $img_upload_path3);

      // execute the sql  query in the database
      $select = "SELECT * FROM registrations WHERE permit_number = '$_GET[id]'";
      $check = $conn->query($select);

      while ($row = $check->fetch_assoc()) {
        unlink("../uploads/" . $row['chainsaw_receipt']);
        unlink("../uploads/" . $row['mayors_permit']);
        unlink("../uploads/" . $row['new_documents']);
      }

      $update = "UPDATE registrations SET name = '$name', address = '$address', purpose = '$purpose', brand = '$brand', model = '$model', serial_no = '$serial_no', date_of_acquisition = '$date_of_acquisition', power_output = '$power_output', maximum_length_of_guidebar = '$maximum_length_of_guidebar', country_of_origin = '$country_of_origin', purchase_price = '$purchase_price', purpose = '$purpose', chainsaw_receipt = '$new_img_name1', mayors_permit = '$new_img_name2', new_documents = '$new_img_name3', chainsaw_receipt =  registration_number = CONCAT(registration_number, registration_id , '(RENEWAL)'), validity_date = '', documents = '', status = 'for-submitted'  WHERE permit_number = '$_GET[id]'";

      $result2 = $conn->query($update);
      header('location: reg-stat-mon-for-submitted.php');
    }

    $error = "upload only image";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application for Renewal</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/reg-stat-mon.css?<?php echo time(); ?>">
</head>

<body>
  <div class="body">
    <div class="header bg-green-1">
      <div class="d-flex align-items-center"><a href="../../forestry-services-homepage.php"><img class="header-logo" src="../../img/penro-logo.png" alt="msc logo"></a>
        <h3 class=" header-texts">PENRO</h3>
      </div>
      <div class="dropdown">
        <button class="dropbtn"><?php echo $_SESSION["username"]; ?></button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../../logout.php">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <!-- <div class="nav-links">
        <nav  style="position: sticky; top: 6vh;">
          <ul>
          <li onclick="location.href='../../forestry-services-homepage.php'">Home</li>
            <li onclick="location.href='chainsaw-homepage.php'">Dashboard</li>
            <li onclick="location.href='application-for-new-registration.php'">Application for New Registration</li>
            <li class="nav-link-active" onclick="location.href='verification-for-renewal.php'">Application for Renewal</li>
            <li onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div> -->
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>Chainsaw > <span class="fs-5">Application for Renewal</span></h4>
          </div>
          <form class="row" method="post" enctype="multipart/form-data">
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

              <?php

              if (isset($error)) {
                echo "
                <div class='alert alert-danger' role='alert'>
                  $error 
                </div>
                ";
              }

              $id = $_GET["id"];
              $sql1 = "SELECT * FROM registrations WHERE permit_number = '$id'";
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
              <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Upload Chainsaw Official Receipt</label>
              <div class="d-flex flex-column">
                <input type="file" class="form-control" for="input-chainsaw-receipt" name="chainsaw-official-receipt" required>
              </div>
              <!-- mayor's permit -->
              <?php

              $sql1 = "SELECT * FROM registrations WHERE permit_number = '$id'";
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
              <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Upload Mayor's Permit</label>
              <div class="d-flex flex-column">
                <input type="file" class="form-control" for="input-chainsaw-receipt" name="mayors-permit" required>
              </div>
              <!-- some new documents -->
              <label class="form-label mt-2 fw-bold" for="upload-chainsaw-official-receipt">New Documents</label>
              <div class="d-flex flex-column">
                <input type="file" class="form-control" for="input-chainsaw-receipt" name="new-document" required>
              </div>
            </div>

            <!-- chainsaw complete details -->
            <div class="p-3 col-sm-7">
              <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Chainsaw Complete Details</h5>
                <div class="input-group mb-2">
                  <span class="input-group-text">Brand: </span>
                  <input type="text" class="form-control" name="brand" value="<?php echo $brand; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Model: </span>
                  <input type="text" class="form-control" name="model" value="<?php echo $model; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Serial No.: </span>
                  <input type="text" class="form-control" name="serial-number" value="<?php echo $serial_no; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Date of Acquisition: </span>
                  <input type="text" class="form-control" name="date-of-acquisition" value="<?php echo $date_of_acquisition; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Power Output(kW/bhb): </span>
                  <input type="text" class="form-control" name="power-output" value="<?php echo $power_output; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Maximum Length of Guidebar: </span>
                  <input type="text" class="form-control" name="maximum-length-of-guidebar" value="<?php echo $maximum_length_of_guidebar; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Country of Origin: </span>
                  <input type="text" class="form-control" name="country-of-origin" value="<?php echo $country_of_origin; ?>" required>
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text">Purchase Price: </span>
                  <input type="text" class="form-control" name="purchase-price" value="<?php echo $purchase_price; ?>" required>
                </div>

                <div class="text-center mt-4">
                  <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
                  <a class="btn btn-danger" href="verification-for-renewal.php">Cancel</a>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</body>

</html>