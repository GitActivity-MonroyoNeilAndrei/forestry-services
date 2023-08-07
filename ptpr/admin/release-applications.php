<?php
@include "../../database/config.php";
@include "../../check-expiration.php";

session_start();

// checks if the user is an ordinary user
if (!isset($_SESSION['admin_username'])) {
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
  <link rel="icon" href="../../img/penro-logo.png">
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <title>Release Applications</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/admin.css?<?php echo time(); ?>">

  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
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
          <a href="../../admin-logout.php">Logout</a>
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="nav-links">
        <nav style="position: sticky; top: 6vh;">
          <ul>
            <li onclick="location.href='../../forestry-services-homepage-admin.php'">Home</li>
            <li onclick="location.href='crude-clients.php'">List of Clients</li>
            <li onclick="location.href='updating-of-application-form.php'">Accept Client Applications</li>
            <li onclick="location.href='list-of-applications.php'">Generate Applications</li>
            <li class="bg-dark-gray2" onclick="location.href='release-applications.php'">Release Applications</li>

          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>PTPR > <span class="fs-5">Released Applications</span></h4>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Permit Number</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Issued On:</th>
                  <th>Released by:</th>
                  <th>Validity Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php


                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $select = "SELECT * FROM ptpr_registrations WHERE status = 'for-released' ORDER BY date_and_time_submitted DESC";
                $result = $conn->query($select);

                if (!$result) {
                  die("Invalid query: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                  echo "
                  <tr>
                  <td>$row[permit_number]</td>
                  <td>$row[name]</td>
                  <td>$row[address]</td>
                  <td>$row[date_and_time_released]</td>
                  <td>$row[released_by]</td>
                  <td>$row[validity_date]</td>
                    <td class='text-center'>
                      <a class='btn btn-success' href='view-pdf-file.php?doc=$row[documents]' target='_blank'>View</a>
                    </td>

                  </tr>
                ";
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

  </div>
</body>

</html>