<?php
@include "../../database/config.php";
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
  <title>List of Clients</title>
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
      <div class="nav-links" style="position: sticky; top: 0;">
        <nav>
          <ul>
            <li onclick="location.href='../../forestry-services-homepage-admin.php'">Home</li>
            <li class="bg-dark-gray2" onclick="location.href='crude-clients.php'">List of Users</li>
            <li onclick="location.href='updating-of-application-form.php'">Accept Client Applications</li>
            <li onclick="location.href='list-of-applications.php'">Generate Applications</li>
            <li onclick="location.href='release-applications.php'">Released Applications</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>PTPR > <span class="fs-5">List of Clients</span></h4>
          </div>

          <nav class="status-list-nav">
            <ul>
              <li style="background-color: #3C9811; color: #FFFFFF;" onclick="location.href='crude-clients.php'">Clients</li>
              <li onclick="location.href='crude-admins.php'">Admins</li>
              <li onclick="location.href='crude-signatories.php'">Signatories</li>
            </ul>
          </nav>




          <a class="btn btn-success bg-green-3" href="add-new-client.php">Add New Client</a>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Business Name</th>
                  <th>Owner's Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Email Address</th>
                  <th>Sex</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                // displays the error on the page when there is an error connecting to the database
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                // execute the sql  query in the database
                $select = "SELECT * FROM clients ORDER BY client_id DESC";
                $result = $conn->query($select);

                // display error, if there's any
                if (!$result) {
                  die("Invalid query: " . $conn->error);
                }

                //displays the data in a table form in the page
                while ($row = $result->fetch_assoc()) {
                  echo "
            <tr>
            <td>$row[client_id]</td>
            <td>$row[username]</td>
            <td>$row[business_name]</td>
            <td>$row[owners_name]</td>
            <td>$row[address]</td>
            <td>$row[contact_number]</td>
            <td>$row[email_address]</td>
            <td>$row[sex]</td>
            <td>$row[status]</td>
            <td>
              <a class='btn btn-primary btn-sm mb-1' href='edit-client.php?id=$row[client_id]'>Edit</a>

              <a class='btn btn-danger btn-sm mb-1' href='deactivate-client.php?id=$row[client_id]&status=deactivated'>Deactivate</a>
              <a class='btn btn-success btn-sm' href='deactivate-client.php?id=$row[client_id]&status=activated'>Activate</a>

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