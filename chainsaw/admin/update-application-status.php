<?php
session_start();
@include "../../database/config.php";
@include "../time.php";

// checks if the user is an ordinary user
if (!isset($_SESSION['admin_username'])) {
  // if not go back to the index file or page
  header('location: ../../login-register-account/login-client.php');
}

$date_and_time_today = $today['year'] . '-' . check_month($today['mon']) . '-' . check_day($today['mday']);
$validity_date =   ($today['year'] + 2) . '-' . check_month($today['mon']) . '-' . check_day($today['mday']);

if ($conn->connect_error) {
  die("Connection Failed: " . $conn->connect_error);
}

if ($_GET['status'] == 'accept') {
  if (isset($_POST['submit'])) {
    $amount = $_POST['amount'];

    $update = "UPDATE registrations SET status = 'accepted', date_and_time_accepted = '$date_and_time_today', remark = '', validity_date = '$validity_date', accepted_by = '$_SESSION[admin_username]', amount_to_pay = '$amount' WHERE registration_id = $_GET[id]";
    $result = $conn->query($update);
    header("location: updating-of-application-form.php");
  }

} else if ($_GET['status'] == 'reject') {
  if (isset($_POST['submit2'])) {
    $remark = mysqli_escape_string($conn, $_POST['remark']);


    $update = "UPDATE registrations SET status = 'rejected', date_and_time_returned = '$date_and_time_today', remark = '$remark' WHERE registration_id = $_GET[id]";
    $result = $conn->query($update);
    header("location: updating-of-application-form.php");
  }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../img/penro-logo.png">
  <title>Update Application Status</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>

<body>

  <div class="container" style="display: <?php if ($_GET['status'] != 'accept') {echo 'none';} ?>;">
    <form method="post" class="p-2 mx-auto border rounded mt-5 d-flex justify-content-center flex-column" style="max-width: 250px;">
      <label class="text-center" for="remark">Add Amount to Pay</label>
      <input class="mt-4" style="width: 100%;" type="number" name="amount">
      <input class="btn btn-primary mt-3" type="submit" name="submit" value="Submit">
    </form>
  </div>

  <div class="container" style="display: <?php if ($_GET['status'] != 'reject') {echo 'none';} ?>;">
    <form method="post" class="p-2 mx-auto border rounded mt-5 d-flex justify-content-center flex-column" style="max-width: 250px;">
      <label class="text-center" for="remark">Add Remark to this Applications</label>
      <input class="mt-4" style="width: 100%;" type="text" name="remark">
      <input class="btn btn-primary mt-3" type="submit" name="submit2" value="Submit">
    </form>
  </div>


</body>

</html>