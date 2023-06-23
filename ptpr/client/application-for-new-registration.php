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
  $client_id =  $_SESSION['client_id'];
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
  $status = "for-draft";
  $date_now = "PMDQ-PTPR-". $today['year'] . "-" . check_month($today['mon']). check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_updated = date('Y-m-d H:i:s');


  $select = "SELECT * FROM ptpr_registrations WHERE name = '$name' && tax_declaration_number = '$tax_declaration_number' && status = '$status'";
  $check = $conn->query($select);



  if(mysqli_num_rows($check) > 0){
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'Ptpr already registered!';
    //get the clientID
    
  }else {
    

    // insert tax declaration receipt URL to the database
    $img_name1 = $_FILES['tax-declaration']['name'];
    $img_size1 = $_FILES['tax-declaration']['size'];
    $tmp_name1 = $_FILES['tax-declaration']['tmp_name'];
    $error1 = $_FILES['tax-declaration']['error'];

    // insert mayors permit URL to the database
    $img_name2 = $_FILES['special-power-of-attorney']['name'];
    $img_size2 = $_FILES['special-power-of-attorney']['size'];
    $tmp_name2 = $_FILES['special-power-of-attorney']['tmp_name'];
    $error2 = $_FILES['special-power-of-attorney']['error'];

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

          
          $insert = "INSERT INTO ptpr_registrations (registration_number, ptpr_client_id, name, address, purpose, tax_declaration, special_power_of_attorney, tax_declaration_number, barangay, municipality, province, total_lot_area, area_devoted_to_plantation, species, number_of_trees, date_and_time_updated, uploaded_requirements, status) " . "VALUES ('$date_now', '$client_id', '$name', '$address', '$purpose', '$new_img_name1', '$new_img_name2', '$tax_declaration_number', '$barangay', '$municipality', '$province', '$total_lot_area', '$area_devoted_to_plantation', '$species', '$number_of_trees', '$date_and_time_updated', '$uploaded_requirements', '$status')";
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
  $client_id =  $_SESSION['client_id'];
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
  $status = "for-submitted";
  $date_now = "PMDQ-PTPR-". $today['year'] . "-" . check_month($today['mon']). check_day($today['mday']);
  $uploaded_requirements = "/";
  $date_and_time_submitted = date('Y-m-d H:i:s');


  $select = "SELECT * FROM ptpr_registrations WHERE name = '$name' && tax_declaration_number = '$tax_declaration_number' && status = '$status'";
  $check = $conn->query($select);



  if(mysqli_num_rows($check) > 0){
    // if there is a data retrieve, display an error prompting the user that this email and password already exist
    $error = 'ptpr already registered!';
    //get the clientID
    
  }else {
    

    // insert tax declaration receipt URL to the database
    $img_name1 = $_FILES['tax-declaration']['name'];
    $img_size1 = $_FILES['tax-declaration']['size'];
    $tmp_name1 = $_FILES['tax-declaration']['tmp_name'];
    $error1 = $_FILES['tax-declaration']['error'];

    // insert special pwower of attorney URL to the database
    $img_name2 = $_FILES['special-power-of-attorney']['name'];
    $img_size2 = $_FILES['special-power-of-attorney']['size'];
    $tmp_name2 = $_FILES['special-power-of-attorney']['tmp_name'];
    $error2 = $_FILES['special-power-of-attorney']['error'];

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

          
          $insert = "INSERT INTO ptpr_registrations (registration_number, ptpr_client_id, name, address, purpose, tax_declaration, special_power_of_attorney, tax_declaration_number, barangay, municipality, province, total_lot_area, area_devoted_to_plantation, species, number_of_trees, date_and_time_submitted, uploaded_requirements, status) " . "VALUES ('$date_now', '$client_id', '$name', '$address', '$purpose', '$new_img_name1', '$new_img_name2', '$tax_declaration_number', '$barangay', '$municipality', '$province', '$total_lot_area', '$area_devoted_to_plantation', '$species', '$number_of_trees', '$date_and_time_submitted', '$uploaded_requirements', '$status')";
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
            <li onclick="location.href='ptpr-homepage.php'">Dashboard</li>
            <li class="nav-link-active" onclick="location.href='application-for-new-registration.php'">Application for New Registration</li>
            <li onclick="location.href='application-for-renewal.php'">Application for Renewal</li>
            <li onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>PTPR > <span class="fs-5">Application for New Registration</span></h4>
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
            <!-- tax declaration -->
            <label class="form-label mt-5">Upload Tax Declaration</label>
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
              <input type="file" class="form-control" name="tax-declaration" required>
            </div>
            <!-- mayor's permit -->
            <label class="form-label mt-2">Upload Special Power of Attorney</label>
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
              <input type="file" class="form-control" name="special-power-of-attorney" required>
            </div>
          </div>
    
          <!-- plantation location details -->
          
          
          
          
          
          
          <div class="p-3 col-sm-7">
            <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Plantation Location Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">OCT/TCT No/Tax. Dec No.: </span>
              <input type="text" class="form-control" name="tax-declaration-number"  required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Barangay: </span>
              <input type="text" class="form-control" name="barangay"  required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Municipality: </span>
              <input type="text" class="form-control" name="municipality"  required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Provice: </span>
              <input type="text" class="form-control" name="province"  required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Total Lot Area: </span>
              <input type="text" class="form-control" name="total-lot-area"  required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Total Lot Area Devoted to Plantation: </span>
              <input type="text" class="form-control" name="area-devoted-to-plantation"  required>
            </div>

            <!-- plant details -->
            <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Plant Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">Species: </span>
              <input type="text" class="form-control" name="species" required>
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Number of Trees: </span>
              <input type="number" class="form-control" name="number-of-trees"required>
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













