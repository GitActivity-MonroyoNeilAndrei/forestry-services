<?php
@include "../../database/config.php";

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
  <title>View Submitted Application</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/icons/font/bootstrap-icons.css?<?php echo time(); ?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>

<body>
  <div class="container p-4">
    <a href="reg-stat-mon-for-<?php echo $_GET['status'] ?>.php"><img src="../../css/icons/arrow-left.svg" class="border rounded" style="width: 50px; height: 50px; position:absolute; left:0.4em; top: 0.4em;" alt="arrow-left"></a>
    <table class="table table-striped table-bordered border-dark mx-auto" style="max-width: 600px">
      <?php
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $select = "SELECT * FROM cov_registrations WHERE cov_registration_id = $_GET[id]";
      $result = $conn->query($select);

      if (!$result) {
        die("Invalid query: " . $conn->error);
      } else {

        while ($row = $result->fetch_assoc()) {
          echo "
        <tr>
          <td class='pe-2'>Registration Number </td><td>$row[registration_number]</td>
        </tr>
        <tr>
         <td class='pe-2'>Name </td><td>$row[name]</td>
        </tr>
        <tr>
          <td class='pe-2'>Address </td><td>$row[address]</td>
        </tr>
        <tr>
          <td class='pe-2'>Purpose </td><td>$row[purpose]</td>
        </tr>
        <tr>
          <td class='pe-2'>Pltp </td><td>$row[pltp]</td>
        </tr>
        <tr>
          <td class='pe-2'>Vehicle Information </td><td>$row[vehicle_information]</td>
        </tr>
        <tr>
          <td class='pe-2'>Location (from)</td><td>$row[location_from]</td>
        </tr>
        <tr>
          <td class='pe-2'>Location (to) </td><td>$row[location_to]</td>
        </tr>
        <tr>
          <td class='pe-2'>Species </td><td>$row[species]</td>
        </tr>
        <tr>
          <td class='pe-2'>Number of Trees </td><td>$row[number_of_trees]</td>
        </tr>
        <tr>
          <td class='pe-2'>Gross Volume </td><td>$row[gross_volume]</td>
        </tr>
        <tr>
          <td class='pe-2'>net_volume </td><td>$row[net_volume]</td>
        </tr>
        <tr>
        <td class='pe-2'>drivers_name </td><td>$row[drivers_name]</td>
      </tr>
      <tr>
      <td class='pe-2'>or_number </td><td>$row[or_number]</td>
    </tr>
    <tr>
    <td class='pe-2'>plate_number </td><td>$row[plate_number]</td>
  </tr>
        <tr>
          <td class='pe-2'>Date and Time Encoded </td><td>$row[date_and_time_encoded]</td>
        </tr>
        <tr>
          <td class='pe-2'>Date and Time Updated </td><td>$row[date_and_time_updated]</td>
        </tr>
        <tr>
          <td class='pe-2'>Received by </td><td>$row[received_by]</td>
        </tr>
        <tr>
          <td class='pe-2'>Date and Time Submitted </td><td>$row[date_and_time_submitted]</td>
        </tr>
      ";
        }
      }
      ?>
    </table>
  </div>
</body>

</html>