<?php
@include '../../database/config.php';

session_start();

// checks if the user is an ordinary user
if (!isset($_SESSION['username'])) {
  // if not go back to the index file or page
  header('location: ../../login-register-account/login-client.php');
}

if (isset($_POST['submit'])) {
  $certificate_no = mysqli_escape_string($conn, $_POST['certificate-no']);

  $select = "SELECT * FROM registrations WHERE permit_number = '$certificate_no'";
  $result = $conn->query($select);
  $row = $result->fetch_assoc();

  if ($row['client_id'] == $_SESSION['client_id']) {
    header("location: application-for-renewal.php?id=$row[permit_number]");
  } else {
    header("location: verification-for-renewal.php?invalidCertificate");
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
        <button class="dropbtn"><?php echo $_SESSION["username"]; ?></button>
        <div class="dropdown-content">
          <a href="#">My Profile</a>
          <a href="../../logout.php">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 6vh;">
          <ul>
            <li onclick="location.href='../../forestry-services-homepage.php'">Home</li>
            <li onclick="location.href='chainsaw-homepage.php'">Dashboard</li>
            <li onclick="location.href='application-for-new-registration.php'">Application for New Registration</li>
            <li class="nav-link-active" onclick="location.href='verification-for-renewal.php'">Application for Renewal</li>
            <li onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>Chainsaw > <span class="fs-5">Verification for Renewal</span></h4>
          </div>
          <form class="mx-auto d-flex flex-column" method="post" style="max-width: 20rem;">
            <h4 class="text-center">Fill Up</h4>
            <?php
            if (isset($_REQUEST['invalidCertificate'])) {
              echo '<div class="alert alert-danger" role="alert"> Certificate No. doesn\'t exist </div> ';
            }
            ?>
            <label class="form-label" for="certificate-no">Chainsaw Registration Certificate No.:</label>
            <input class="form-control" type="text" name="certificate-no" required>

            <label class="form-label mt-4" for="accredited-chainsaw">Accredited Chainsaw Stores:</label>
            <select class="form-select mx-auto" name="accredited-chainsaw">
              <?php

              $select3 = "SELECT * FROM chainsaw_stores";
              $result3 = $conn->query($select3);
              while ($row3 = $result3->fetch_assoc()) {
              ?>
                <option value="<?php echo $row3['bus_name']; ?>"><?php echo $row3['bus_name']; ?></option>
              <?php } ?>
            </select>
            <input class="btn btn-primary mx-auto mt-4 shadow-sm" type="submit" name="submit" value="Apply for Renewal">
          </form>
        </div>
      </div>
    </div>

  </div>
</body>

</html>