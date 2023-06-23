<?php
@include '../../database/config.php';

session_start();

// checks if the user is an ordinary user
if (!isset($_SESSION['username'])) {
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
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
  <title>practice website</title>
  <link rel="stylesheet" href="../../css/reg-stat-mon.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
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
          <a href="#">Logout</a>
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
            <li onclick="location.href='application-for-renewal.php'">Application for Renewal</li>
            <li class="nav-link-active" onclick="location.href='reg-stat-mon-for-draft.php'">Registration Status Monitoring</li>
          </ul>
        </nav>
      </div>
      <div class="content border border-primary">
        <div class="content-container">
          <div class="content-header">
            <h4>COV > <span class="fs-5">Registration Status Monitoring > Released</span></h4>
          </div>
          <nav class="status-list-nav">
            <ul>
              <li onclick="location.href='reg-stat-mon-for-draft.php'">Draft</li>
              <li onclick="location.href='reg-stat-mon-for-submitted.php'">Submitted</li>
              <li onclick="location.href='reg-stat-mon-for-returned.php'">Returned</li>
              <li onclick="location.href='reg-stat-mon-for-accepted.php'">Accepted</li>
              <li style="background-color: #3C9811; color: #FFFFFF;" onclick="location.href='reg-stat-mon-for-released.php'">Released</li>
              <li onclick="location.href='reg-stat-mon-for-expired.php'">Expired</li>
            </ul>
          </nav>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Permit Number</th>
                  <th>Date and Time Issued</th>
                  <th>Issued by:</th>
                  <th>Date and Time Released</th>
                  <th>Released by:</th>
                  <th>Validity Date</th>
                  <th>Date and Time Accepted</th>
                  <th>Accepted by</th>
                  <th>Copy of Chainsaw Registration Certificate</th>
                  <td>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>President</td>
                  <td>Anton</td>
                  <td>Hill</td>
                  <td>1st</td>
                  <td>img</td>
                  <td>meta</td>
                  <td>23</td>
                  <td>23</td>
                  <td>23</td>
                  <td>23</td>
                </tr>
                <tr>
                  <td>President</td>
                  <td>Bill</td>
                  <td>Miles</td>
                  <td>1st</td>
                  <td>img</td>
                  <td>Apple</td>
                  <td>111</td>
                  <td>23</td>
                  <td>23</td>
                  <td>23</td>
                </tr>
                <tr>
                  <td>Vice President</td>
                  <td>Anton</td>
                  <td>Hill</td>
                  <td>1st</td>
                  <td>img</td>
                  <td>meta</td>
                  <td>23</td>
                  <td>23</td>
                  <td>23</td>
                  <td>23</td>
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