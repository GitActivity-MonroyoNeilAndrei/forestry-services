<?php
  @include "../../database/config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <title>practice website</title>
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
        <button class="dropbtn">SureName, First Name, M.</button>
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
            <li  class="bg-dark-gray2" onclick="location.href='chainsaw-stores.php'">List of Chainsaw Stores</li>
            <li onclick="location.href='updating-of-application-form.php'">Accept Client Applications</li>
          <li onclick="location.href='list-of-applications.php'">Generate Applications</li>
          <li onclick="location.href='release-applications.php'">Released Applications</li>

          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
          <h4>Chainsaw > <span class="fs-5">List of Chainsaw Stores</span></h4>
          </div>
          <a class="btn btn-success bg-green-3" href="add-new-chainsaw-store.php">Add New Chainsaw Store</a>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Permit Number</th>
                  <th>Bus Name</th>
                  <th>Owner's Name</th>
                  <th>Address</th>
                  <th>Date Issued</th>
                  <th>Expiration Date</th>
                  <th>Certificate</th>
                </tr>
              </thead>
              <tbody>
              <?php
          // displays the error on the page when there is an error connecting to the database
          if($conn->connect_error){
            die("Connection failed: ". $conn->connect_error);
          }

          // execute the sql  query in the database
          $select = "SELECT * FROM chainsaw_stores";
          $result = $conn->query($select);

          // display error, if there's any
          if (!$result){
            die("Invalid query: ". $conn->error);
          }

          //displays the data in a table form in the page
          while($row = $result->fetch_assoc()) {
            echo "
            <tr>
            <td>$row[permit_number]</td>
            <td>$row[bus_name]</td>
            <td>$row[owners_name]</td>
            <td>$row[address]</td>
            <td>$row[date_issued]</td>
            <td>$row[expiration_date]</td>
            <td><a type='button' class='btn btn-success' href='view-document.php?url=$row[certificate]&path=chainsaw-stores'>View</a></td>
            <td>
              <a class='btn btn-primary btn-sm' href='edit-chainsaw-store.php?id=$row[chainsaw_store_id]'>Edit</a>

              <a class='btn btn-danger btn-sm' href='delete-chainsaw-store.php?id=$row[chainsaw_store_id]'>Delete</a>
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




















