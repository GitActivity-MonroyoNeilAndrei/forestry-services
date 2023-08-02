<?php
session_start();
@include "../../database/config.php";

if (isset($_GET['id'])) {

  if (isset($_POST['yes'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM cov_registrations WHERE cov_registration_id=$id";
    $conn->query($sql);
    header("location: list-of-applications.php");
    exit();
  }else if (isset($_POST['no'])){
    header("location: list-of-applications.php");
    exit();
  }
} else {
  header("location: list-of-applications.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta  name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../img/penro-logo.png">
  <title>Delete Application</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time();?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>

<body>
  <form method="post" class="border border-dark mt-5 mx-auto px-5 py-3" style="max-width: 500px;">
    <h4 class="text-center">Are You Sure You want to delete this Client?</h4>
    <div class="row">
      <input class="btn btn-success mb-2" type="submit" name="yes" value="Yes">
      <input class="btn btn-danger" type="submit" name="no" value="No">
    </div>
  </form>
</body>

</html>