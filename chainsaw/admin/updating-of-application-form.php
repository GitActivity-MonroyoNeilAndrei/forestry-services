<?php
@include "../../database/config.php";
session_start();



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <title>Update Applications</title>
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
        <nav  style="position: sticky; top: 6vh;">
          <ul>
            <li onclick="location.href='../../forestry-services-homepage-admin.php'">Home</li>
            <li onclick="location.href='crude-clients.php'">List of Clients</li>
            <li onclick="location.href='chainsaw-stores.php'">List of Chainsaw Stores</li>
            <li class="bg-dark-gray2"  onclick="location.href='updating-of-application-form.php'">Accept Client Applications</li>
          <li onclick="location.href='list-of-applications.php'">Generate Applications</li>
          <li onclick="location.href='release-applications.php'">Released Applications</li>


          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
          <h4>Chainsaw > <span class="fs-5">Update Client Applications</span></h4>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Registration Number</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Purpose</th>
                  <th>Chainsaw Receipt</th>
                  <th>Mayor's Permit</th>
                  <th>Brand</th>
                  <th>Model</th>
                  <th>Serial Number</th>
                  <th>Date of Acquisition</th>
                  <th>Power Output</th>
                  <th>Maximum Length of Guidebar</th>
                  <th>Country of Origin</th>
                  <th>Purchase Price</th>
                  <th>Date and Time Encoded</th>
                  <th>Date and Time Updated</th>
                  <th>Uploaded Requirements</th>
                  <th>Date and Time of Submitted</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php


                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $select = "SELECT * FROM registrations WHERE status = 'for-submitted'";
                $result = $conn->query($select);

                if (!$result) {
                  die("Invalid query: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                  echo "
                    <tr>
                      <td>$row[registration_number]</td>
                      <td>$row[name]</td>
                      <td>$row[address]</td>
                      <td>$row[purpose]</td>
                      <td><a type='button' class='btn btn-success' href='view-document.php?url=$row[chainsaw_receipt]&path=updating-of-application-form'>View</a></td>
                      <td><a type='button' class='btn btn-success' href='view-document.php?url=$row[mayors_permit]&path=updating-of-application-form'>View</a></td>
                      <td>$row[brand]</td>
                      <td>$row[model]</td>
                      <td>$row[serial_no]</td>
                      <td>$row[date_of_acquisition]</td>
                      <td>$row[power_output]</td>
                      <td>$row[maximum_length_of_guidebar]</td>
                      <td>$row[country_of_origin]</td>
                      <td>$row[purchase_price]</td>
                      <td>$row[date_and_time_encoded]</td>
                      <td>$row[date_and_time_updated]</td>
                      <td>$row[uploaded_requirements]</td>
                      <td>$row[date_and_time_submitted]</td>
                      <td class='text-center'>
                        <a href='update-application-status.php?id=$row[registration_id]&status=accept' class='btn btn-success'>Accept</a>
                        <a href='update-application-status.php?id=$row[registration_id]&status=reject' class='btn btn-danger'>Reject</a>
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