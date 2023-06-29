<?php

@include '../../database/config.php';
@include "../time.php";

session_start();

if (isset($_GET['id'])) {

  $id = $_GET["id"];


  $sql = "SELECT * FROM ptpr_registrations WHERE ptpr_registration_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if (!$row) {
    header("location: list-of-applications.php");
    exit;
  }

  $name = $row['name'];
  $address = $row['address'];
  $purpose = $row['purpose'];
  $tax_declaration_number  = $row['tax_declaration_number'];
  $barangay  = $row['barangay'];
  $municipality  = $row['municipality'];
  $province = $row['province'];
  $total_lot_area = $row['total_lot_area'];
  $area_devoted_to_plantation = $row['area_devoted_to_plantation'];
  $species = $row['species'];
  $number_of_trees = $row['number_of_trees'];
}
if (isset($_POST['submit'])) {
  $name = mysqli_escape_string($conn, $_POST['name']);
  $address = mysqli_escape_string($conn, $_POST['address']);
  $purpose = mysqli_escape_string($conn, $_POST['purpose']);
  $tax_declaration_number = mysqli_escape_string($conn, $_POST['tax-declaration-number']);
  $barangay = mysqli_escape_string($conn, $_POST['barangay']);
  $municipality = mysqli_escape_string($conn, $_POST['municipality']);
  $province = mysqli_escape_string($conn, $_POST['province']);
  $total_lot_area = mysqli_escape_string($conn, $_POST['total-lot-area']);
  $area_devoted_to_plantation = mysqli_escape_string($conn, $_POST['area-devoted-to-plantation']);
  $species = mysqli_escape_string($conn, $_POST['species']);
  $number_of_trees = mysqli_escape_string($conn, $_POST['number-of-trees']);
  $status = "submitted-by-admin";
  $date_now = "PMDQ-CSAW-" . $today['year'] . "-" . check_month($today['mon']) . check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_submitted = $today['year'] . '-' . check_month($today['mon']) . '-' . check_day($today['mday']);




    // insert chainsaw receipt URL to the database
    $img_name1 = $_FILES['tax-declaration']['name'];
    $img_size1 = $_FILES['tax-declaration']['size'];
    $tmp_name1 = $_FILES['tax-declaration']['tmp_name'];
    $error1 = $_FILES['tax-declaration']['error'];

    // insert mayors permit URL to the database
    $img_name2 = $_FILES['special-power-of-attorney']['name'];
    $img_size2 = $_FILES['special-power-of-attorney']['size'];
    $tmp_name2 = $_FILES['special-power-of-attorney']['tmp_name'];
    $error2 = $_FILES['special-power-of-attorney']['error'];

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


        $sql = "UPDATE ptpr_registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', tax_declaration = '$new_img_name1', special_power_of_attorney = '$new_img_name2', tax_declaration_number = '$tax_declaration_number', barangay = '$barangay', municipality = '$municipality', province = '$province', total_lot_area = '$total_lot_area', area_devoted_to_plantation = '$area_devoted_to_plantation', species = '$species', number_of_trees = '$number_of_trees'  " . "WHERE ptpr_registration_id = $id";
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
  <title>Admin Home Page</title>
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
            <h4 style="display: inline;">PTPR > <span class="fs-5">Application for New Registration</span></h4>
            <button onclick="history.back();" class="btn btn-danger">Back</button>
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
        <!-- tax declaration -->
        <label class="form-label mt-5">Upload Tax Declaration</label>

        <?php
        if (isset($display_error)) {
          echo '
                <div class="alert alert-danger" role="alert">
                ' . $display_error . '
                </div>
                ';
        }
        ?>
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


        <div class="d-flex flex-column">
          <input type="file" class="form-control" name="tax-declaration" required>
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

        <div class="d-flex flex-column">
          <input type="file" class="form-control" name="special-power-of-attorney" required>
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
              <input class="btn btn-success mx-2" type="submit" name="submit" value="Edit">
            </div>
      </div>
    </form>

        </div>
      </div>
    </div>

  </div>
</body>

</html>