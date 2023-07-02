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
  <title>Chainsaw Registration</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/admin.css?<?php echo time(); ?>">
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
            <li onclick="location.href='updating-of-application-form.php'">Accept Client Applications</li>
            <li class="bg-dark-gray2"  onclick="location.href='list-of-applications.php'">Generate Applications</li>
            <li onclick="location.href='release-applications.php'">Released Applications</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>PTPR > <span class="fs-5">List of Applications</span></h4>
          </div>
          <a class="btn btn-success bg-green-3" href="add-new-application.php">Add New Application</a>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Registration Number</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>Purpose</th>
                  <th>Tax Declaration</th>
                  <th>Special Power of Attorney</th>
                  <th>Tax Declaration Number</th>
                  <th>Barangay</th>
                  <th>Municipality</th>
                  <th>Province</th>
                  <th>Total Lot Area</th>
                  <th>Area Devoted to Plantation</th>
                  <th>Species</th>
                  <th>Number of Trees</th>
                  <th>Date and Time Encoded</th>
                  <th>Date and Time Updated</th>
                  <th>Uploaded Redquirements</th>
                  <th>Date and Time Submitted</th>
                  <th>Action</th>
                  <th>Release</th>
                </tr>
              </thead>
              <tbody>
                <?php


                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $select = "SELECT * FROM ptpr_registrations WHERE status IN ('submitted-by-admin','accepted') ORDER BY date_and_time_submitted DESC";
                $result = $conn->query($select);

                if (!$result) {
                  die("Invalid query: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                  echo "
                    <tr>
                    <td>$row[registration_number]$row[ptpr_registration_id]</td>
                    <td>$row[name]</td>
                    <td>$row[address]</td>
                    <td>$row[purpose]</td>
                    <td><a type='button' class='btn btn-success' href='view-document.php?url=$row[tax_declaration]&path=updating-of-application-form'>View</a></td>
                    <td><a type='button' class='btn btn-success' href='view-document.php?url=$row[special_power_of_attorney]&path=updating-of-application-form'>View</a></td>
                    <td>$row[tax_declaration_number]</td>
                    <td>$row[barangay]</td>
                    <td>$row[municipality]</td>
                    <td>$row[province]</td>
                    <td>$row[total_lot_area]</td>
                    <td>$row[area_devoted_to_plantation]</td>
                    <td>$row[species]</td>
                    <td>$row[number_of_trees]</td>
                    <td>$row[date_and_time_encoded]</td>
                    <td>$row[date_and_time_updated]</td>
                    <td>$row[uploaded_requirements]</td>
                    <td>$row[date_and_time_submitted]</td>
                      <td class='text-center'>
                        <a href='edit-application.php?id=$row[ptpr_registration_id]' class='btn btn-success'>Edit</a>
                        <a href='delete-application.php?id=$row[ptpr_registration_id]' class='btn btn-danger'>Delete</a>
                      <button class='btn btn-secondary btn-sm' onclick=\"window.open('generate-pdf.php?id=$row[ptpr_registration_id]','_blank')\">Generate</button>

                      </td>
                      <td><a href='release-application.php?id=$row[ptpr_registration_id]' class='btn btn-primary'>Release</a></td>

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