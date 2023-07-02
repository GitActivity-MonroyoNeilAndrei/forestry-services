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
        <nav  style="position: sticky; top: 6vh;">
          <ul>
            <li onclick="location.href='../../forestry-services-homepage.php'">Home</li>
            <li onclick="location.href='cov-homepage.php'">Dashboard</li>
            <li onclick="location.href='application-for-new-registration.php'">Application for New Registration</li>
            <!-- <li onclick="location.href='application-for-renewal.php'">Application for Renewal</li> -->
            <li class="nav-link-active" onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>COV > <span class="fs-5">Registration Status Monitoring > Draft</span></h4>
          </div>
          <nav class="status-list-nav">
            <ul>
              <li style="background-color: #3C9811; color: #FFFFFF;" onclick="location.href='reg-stat-mon-for-draft.php'">Draft</li>
              <li onclick="location.href='reg-stat-mon-for-submitted.php'">Submitted</li>
              <li onclick="location.href='reg-stat-mon-for-returned.php'">Returned</li>
              <li onclick="location.href='reg-stat-mon-for-accepted.php'">Accepted</li>
              <li onclick="location.href='reg-stat-mon-for-released.php'">Released</li>
              <li onclick="location.href='reg-stat-mon-for-expired.php'">Expired</li>
            </ul>
          </nav>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>

                <tr>
                  <th>Application Number</th>
                  <th>Date and Time Encoded(yyyy-mm-dd)</th>
                  <th>Date and Time Updated (yyyy-mm-dd)</th>
                  <th>Uploaded Requirements</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              if($conn->connect_error){
                die("Connection failed: ". $conn->connect_error);
              }

              $select = "SELECT * FROM cov_registrations WHERE cov_client_id = ".$_SESSION['cov_client_id']." AND status = 'for-draft' ORDER BY date_and_time_submitted DESC";
              $result = $conn->query($select);

              if(!$result){
                die("Invalid query: ". $conn->error);
              }else{

              while($row = $result->fetch_assoc()){
                echo "
                <tr>
                  <td>$row[registration_number]$row[cov_registration_id]</td>
                  <td class='px-3'>$row[date_and_time_encoded]</td>
                  <td class='px-3'>$row[date_and_time_updated]</td>
                  <td class='px-3'>$row[uploaded_requirements]</td>
                  <td>
                    <a class='btn btn-primary btn-sm' href='application-edit.php?id=$row[cov_registration_id]&status=draft'>Edit</a>
                  </td>
          
                </tr>
                ";
              }
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