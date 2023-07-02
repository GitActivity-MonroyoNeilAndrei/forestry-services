<?php
@include '../../database/config.php';

session_start();

// checks if the user is an ordinary user
if(!isset($_SESSION['username'])){
   // if not go back to the index file or page
   header('location: ../../login-register-account/login-client.php');
}

@include "status-count.php";
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
        <nav  style="position: sticky; top: 6vh;">
          <ul>
          <li onclick="location.href='../../forestry-services-homepage.php'">Home</li>
            <li class="nav-link-active" onclick="location.href='cov-homepage.php'">Dashboard</li>
            <li onclick="location.href='application-for-new-registration.php'">Application for New Registration</li>
            <!-- <li onclick="location.href='application-for-renewal.php'">Application for Renewal</li> -->
            <li onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>COV > <span class="fs-5">Draft</span></h4>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
            <thead>
            <tr>
              <th>Draft</th>
              <th>Sumitted</th>
              <th>Returned</th>
              <th>Accepted</th>
              <th>Released</th>
              <th>Expired</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo status_count($conn, "for-draft") ?></td>
              <td><?php echo status_count($conn, "for-submitted") ?></td>
              <td><?php echo status_count($conn, "rejected") ?></td>
              <td><?php echo status_count($conn, "accepted") ?></td>
              <td><?php echo status_count($conn, "for-released") ?></td>
              <td><?php echo status_count($conn, "for-expired") ?></td>
            </tr>
            <tr>
              <td><a class="btn btn-success" href="reg-stat-mon-for-draft.php">View</a></td>
              <td><a class="btn btn-success" href="reg-stat-mon-for-submitted.php">View</a></td>
              <td><a class="btn btn-success" href="reg-stat-mon-for-returned.php">View</a></td>
              <td><a class="btn btn-success" href="reg-stat-mon-for-accepted.php">View</a></td>
              <td><a class="btn btn-success" href="reg-stat-mon-for-released.php">View</a></td>
              <td><a class="btn btn-success" href="reg-stat-mon-for-expired.php">View</a></td>
            </tr>
          </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

  </div>
</body>

</html>













