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
  $brand = mysqli_escape_string($conn, $_POST['brand']);
  $model = mysqli_escape_string($conn, $_POST['model']);
  $serial_number = mysqli_escape_string($conn, $_POST['serial-number']);
  $date_of_acquisition = mysqli_escape_string($conn, $_POST['date-of-acquisition']);
  $power_output = mysqli_escape_string($conn, $_POST['power-output']);
  $maximum_length_of_guidebar = mysqli_escape_string($conn, $_POST['maximum-length-of-guidebar']);
  $country_of_origin = mysqli_escape_string($conn, $_POST['country-of-origin']);
  $purchase_price = mysqli_escape_string($conn, $_POST['purchase-price']);
  $status = "submitted-by-admin";
  $date_now = "PMDQ-CSAW-". $today['year'] . "-" . check_month($today['mon']). check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_submitted = date('Y-m-d H:i:s');


  $select = "SELECT * FROM registrations WHERE name = '$name' && brand = '$brand' && status = '$status'";
  $check = $conn->query($select);



  if(mysqli_num_rows($check) > 0){
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'chainsaw already registered!';
    //get the clientID
    
  }else {
    

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



          
          $insert = "INSERT INTO registrations (registration_number, name, address, purpose, chainsaw_receipt, mayors_permit, brand, model, serial_no, date_of_acquisition, power_output, maximum_length_of_guidebar, country_of_origin, purchase_price, date_and_time_submitted, uploaded_requirements, status) " . "VALUES ('$date_now', '$name', '$address', '$purpose', '$new_img_name1', '$new_img_name2', '$brand', '$model', '$serial_number', '$date_of_acquisition', '$power_output', '$maximum_length_of_guidebar', '$country_of_origin', '$purchase_price', '$date_and_time_submitted', '$uploaded_requirements', '$status')";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Application</title>
  <link rel="icon" href="../../img/penro-logo.png">
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
            <input class="form-control" type="text" name="name" placeholder='ex. "Neil Andrei G. Monroyo"' required>
            <!-- address -->
            <label class="form-label" for="address">Address</label>
            <input class="form-control" type="text" name="address" placeholder='ex. Bunganay, Boac, Marinduque' required>
            <!-- purpose -->
            <label class="form-label" for="purpose">Purpose</label>
            <input class="form-control" type="text" name="purpose" placeholder='ex. "for cutting lumber"' required>
            <!-- uploading of chainsaw official receipt -->
            <label class="form-label mt-5" for="upload-chainsaw-official-receipt">Upload Chainsaw Official Receipt</label>
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
              <input type="file" class="form-control" for="input-chainsaw-receipt" name="chainsaw-official-receipt" required>
            </div>
            <!-- mayor's permit -->
            <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Upload Mayor's Permit</label>
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
              <input type="file" class="form-control" for="input-mayors-permit" name="mayors-permit" required>
            </div>
          </div>
    
          <!-- chainsaw complete details -->
          <div class="p-3 col-sm-7">
            <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Chainsaw Complete Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">Brand: </span>
              <input type="text" class="form-control" name="brand" placeholder='ex. "STIHL" ' required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Model: </span>
              <input type="text" class="form-control" name="model" placeholder='ex. "MS 070"' required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Serial No.: </span>
              <input type="text" class="form-control" name="serial-number" placeholder='ex. "S188128299"' required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Date of Acquisition: </span>
              <input type="text" class="form-control" name="date-of-acquisition" placeholder='ex. "november 28. 2020"' required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Power Output(kW/bhb): </span>
              <input type="text" class="form-control" name="power-output" placeholder='ex. "1.0 Hp"' required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Maximum Length of Guidebar: </span>
              <input type="text" class="form-control" name="maximum-length-of-guidebar" placeholder='ex. "36 inches"' required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Country of Origin: </span>
              <input type="text" class="form-control" name="country-of-origin" placeholder='ex. "Germany"' required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Purchase Price: </span>
              <input type="text" class="form-control" name="purchase-price" placeholder='ex. "60000"' required>
            </div>
            <div class="text-center mt-4">
              <input class="btn btn-success mx-2" type="submit" name="submit" value="Submit">
            <button class="btn btn-danger" onclick="history.back();">Back</button>

            </div>
          </div>
        </form>

        </div>
      </div>
    </div>

  </div>
</body>

</html>