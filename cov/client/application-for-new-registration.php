<?php
@include '../../database/config.php';
@include "../time.php";

session_start();

$admins_no_of_submissions = [];
$admins_id = [];
$choosen_admin = "";
$admin_username = "";


// checks if the user is an ordinary user
if(!isset($_SESSION['username'])){
   // if not go back to the index file or page
   header('location: ../../login-register-account/login-client.php');
}



if(isset($_POST['save-draft'])){
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
  $status = "for-draft";
  $date_now = "PMDQ-COV-". $today['year'] . "-" . check_month($today['mon']). check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_updated = date('Y-m-d H:i:s');


  $select = "SELECT * FROM cov_registrations WHERE name = '$name' && location_to = '$location_to' && status = '$status'";
  $check = $conn->query($select);



  if(mysqli_num_rows($check) > 0){
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'Cov already registered!';
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

          
          $insert = "INSERT INTO cov_registrations (registration_number, cov_client_id, name, address, purpose, pltp, vehicle_information, location_from, location_to, species, number_of_trees, gross_volume, net_volume, drivers_name, or_number, plate_number, date_and_time_updated, uploaded_requirements, status) " . "VALUES ('$date_now', '$cov_client_id', '$name', '$address', '$purpose', '$new_img_name1', '$new_img_name2', '$location_from', '$location_to', '$species', '$number_of_trees', '$gross_volume', '$net_volume', '$drivers_name', '$or_number', '$plate_number', '$date_and_time_updated', '$uploaded_requirements', '$status')";
          $result = $conn->query($insert);


          
          header("location: reg-stat-mon-for-draft.php");
          exit();
          

        }else{
          $display_error = "You can't upload files of this type";
        }
    }
  }
}

if(isset($_POST['submit'])){
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
  $status = "for-submitted";
  $date_now = "PMDQ-COV-". $today['year'] . "-" . check_month($today['mon']). check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_submitted = date('Y-m-d H:i:s');


  $select = "SELECT * FROM cov_registrations WHERE name = '$name' && location_from = '$location_from' && status = '$status'";
  $check = $conn->query($select);



  if(mysqli_num_rows($check) > 0){
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'cov already registered!';
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

          // get the minimum submission by an admin
          // ----------------------------
          $sql = "SELECT * FROM admins";
          $admin_results = $conn->query($sql);

          if(!$admin_results){
            die("Invalid query: ". $conn->error);
          }

          while ($row = $admin_results->fetch_assoc()){
            array_push($admins_no_of_submissions, $row['number_of_submissions']);
            array_push($admins_id, $row['id']);
          }


          $mins = array_keys($admins_no_of_submissions, min($admins_no_of_submissions));
          $lowest_admin_id = $admins_id[$mins[0]];


          // ---------------------------

          // get the admins id with the lowest submission

          $check = "SELECT * FROM admins WHERE id = $lowest_admin_id";
          $lowest_result = $conn->query($check);

          if(!$lowest_result){
            die("Invalid Query: ". $conn->error);
          }

          while ($row = $lowest_result->fetch_assoc()){
            $admin_username = $row['username'];
          }

          
          $insert = "INSERT INTO cov_registrations (registration_number, cov_client_id, name, address, purpose, pltp, vehicle_information, location_from, location_to, species, number_of_trees, gross_volume, net_volume, drivers_name, or_number, plate_number, received_by, date_and_time_submitted, uploaded_requirements, status) " . "VALUES ('$date_now', '$cov_client_id', '$name', '$address', '$purpose', '$new_img_name1', '$new_img_name2', '$location_from', '$location_to', '$species', '$number_of_trees', '$gross_volume', '$net_volume', '$drivers_name', '$or_number', '$plate_number', '$admin_username', '$date_and_time_submitted', '$uploaded_requirements', '$status')";
          $result = $conn->query($insert);

          $update_admin_submission = "UPDATE admins SET number_of_submissions = number_of_submissions + 1 WHERE id = $lowest_admin_id";
          $admin_submission_result = $conn->query($update_admin_submission);
          
          $update = "";


          
          header("location: reg-stat-mon-for-submitted.php");
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
  <title>Admin Home Page</title>
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
        <button class="dropbtn">SureName, First Name, M.</button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../../logout.php">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav>
          <ul>
          <li onclick="location.href='../../forestry-services-homepage.php'">Home</li>
            <li onclick="location.href='cov-homepage.php'">Dashboard</li>
            <li class="nav-link-active" onclick="location.href='application-for-new-registration.php'">Application for New Registration</li>
            <li onclick="location.href='application-for-renewal.php'">Application for Renewal</li>
            <li onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
          <h4>COV > <span class="fs-5">Application for New Registration</span></h4>
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
              <input class="btn btn-success mx-2" type="submit" name="save-draft" value="Save as Draft">
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













