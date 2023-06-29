<?php
@include '../../database/config.php';

session_start();

// checks if the user is an ordinary user
if(!isset($_SESSION['username'])){
   // if not go back to the index file or page
   header('location: ../../login-register-account/login-client.php');
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
        <button class="dropbtn"><?php echo $_SESSION["username"]; ?></button>
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
            <li onclick="location.href='application-for-new-registration.php'">Application for New Registration</li>
            <!-- <li class="nav-link-active" onclick="location.href='application-for-renewal.php'">Application for Renewal</li> -->
            <li onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>COV > <span class="fs-5">Application for Renewal</span></h4>
          </div>
          <form class="row">
          <!-- name address chuchu -->
          <div class="border-end border-primary d-flex flex-column px-4 py-2 col-sm-5">
            <!-- name -->
            <label class="form-label" for="name">Name</label>
            <input class="form-control" type="text" name="name">
            <!-- address -->
            <label class="form-label" for="address">Address</label>
            <input class="form-control" type="text" name="address">
            <!-- purpose -->
            <label class="form-label" for="purpose">Purpose</label>
            <input class="form-control" type="text" name="purpose">
            <!-- uploading of chainsaw official receipt -->
            <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Upload Chainsaw Official Receipt</label>
            <div class="d-flex flex-column">
              <input type="file" class="form-control" for="input-chainsaw-receipt">
            </div>
            <!-- mayor's permit -->
            <label class="form-label mt-2" for="upload-chainsaw-official-receipt">Upload Mayor's Permit</label>
            <div class="d-flex flex-column">
              <input type="file" class="form-control" for="input-chainsaw-receipt">
            </div>
            <!-- some new documents -->
            <label class="form-label mt-2 fw-bold" for="upload-chainsaw-official-receipt">New Documents</label>
            <div class="d-flex flex-column">
              <input type="file" class="form-control" for="input-chainsaw-receipt">
            </div>
          </div>
    
          <!-- chainsaw complete details -->
          <div class="p-3 col-sm-7">
            <h6 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Chainsaw Complete Details</h5>
            <div class="input-group mb-2">
              <span class="input-group-text">Brand: </span>
              <input type="text" class="form-control" name="brand">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Model: </span>
              <input type="text" class="form-control" name="model">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Serial No.: </span>
              <input type="text" class="form-control" name="serial-number">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Date of Acquisition: </span>
              <input type="text" class="form-control" name="date-of-acquisition">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Power Output(kW/bhb): </span>
              <input type="text" class="form-control" name="power-output">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Maximum Length of Guidebar: </span>
              <input type="text" class="form-control" name="maximum-length-of-guidebar">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Country of Origin: </span>
              <input type="text" class="form-control" name="maximum-length-of-guidebar">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Purchase Price: </span>
              <input type="text" class="form-control" name="purchase-price">
            </div>
            <div class="input-group mb-2">
              <span class="input-group-text">Purpose: </span>
              <input type="text" class="form-control" name="purpose">
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
















