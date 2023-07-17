<?php
date_default_timezone_set('Asia/Manila');

session_start();
@include "../../database/config.php";
@include "../time.php";

$registration_no;
$name;
$address;
$purpose;
$tax_declaration_number;
$barangay;
$municipality;
$province;
$total_lot_area;
$area_devoted_to_plantation;
$species;
$number_of_trees;
$date_and_time_submitted;
$received_by;
$date_today;



if(isset($_GET['id'])){
  if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
  }

  $select = "SELECT * FROM ptpr_registrations WHERE ptpr_registration_id = $_GET[id]";
  $result = $conn->query($select);

  if(!$result){
    die("Invalid query: ". $conn->error);
  }else{

  while($row = $result->fetch_assoc()){

    $registration_no = $row['ptpr_registration_id'] . '-' . date('Y');
    $name = $row['name'];
    $address = $row['address'];
    $purpose = $row['purpose'];
    $tax_declaration_number = $row['tax_declaration_number'];
    $barangay = $row['barangay'];
    $municipality = $row['municipality'];
    $province = $row['province'];
    $total_lot_area = $row['total_lot_area'];
    $area_devoted_to_plantation = $row['area_devoted_to_plantation'];
    $species = $row['species'];
    $number_of_trees = $row['number_of_trees'];
    $date_and_time_submitted = $row['date_and_time_submitted'];
    $received_by = $row['received_by'];
    $validity_date = $row['validity_date'];
    $date_today = $today['year'] .'-'. check_month($today['mon']) .'-'. check_day($today['mday']);


  }}


}else {
  header("location: reg-stat-mon-for-accepted.php");
}

?>



<!DOCTYPE html>
<html>

<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script defer>
    function generatePDF() {
      const element = document.getElementById('container_content');
      var opt = {
        margin: 0,
        filename: 'ptpr document.pdf',
        image: {
          type: 'jpeg',
          quality: 0.98
        },
        html2canvas: {
          scale: 2
        },
        jsPDF: {
          unit: 'in',
          format: 'legal',
          orientation: 'portrait'
        }
      };
      // Choose the element that our invoice is rendered in.

      html2pdf().set(opt).from(element).save();
    }
  </script>
  <style type="text/css">
    * {
      line-height: 28px;
    }
    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
    }
  </style>
</head>

<body>
  <div class="container_content" style="padding: 20px 20px 25px 20px" id="container_content">
    <div class="paper" style="height: 188vh;">
      <div class="header" style="display: flex; border-bottom: 2px solid red;">
        <img style="width: 100px; margin-right: 25px; padding-left: 50px;" src="penroLogo.png" alt="">
        <div class="header-text">
          <h4>Republic of the Philippines <br>
            Department of Environment and Natural Resources <br>
            PENRO Marinduque</h4>
        </div>
      </div>
      <h4 style="text-align: center;">PRIVATE TREE PLANTATION REGISTRATION</h4>
      <H4 style="text-align: center;">No. <?php echo $registration_no; ?></H4>
      <h4>Owner's Basic Information</h4>
      <table style="width: 90%; margin: auto;">
        <tr>
          <td style="border: 1px solid black; border-collapse: collapse;">Name</td>
          <td colspan="3"><?php echo $name ; ?></td>
        </tr>
        <tr>
          <td>Permanent Address</td>
          <td><?php echo $address ; ?></td>
        </tr>
        <tr>
          <td>Contact Number</td>
          <td>0915-110-2554</td>
        </tr>
        <tr>
          <td>Email Address</td>
          <td></td>
        </tr>
      </table>

      <h4>Tree Plantation Location</h4>
      <table style="width: 90%; margin: auto;">
        <tr>
          <td>OCT/TCT No/Tax. Dec No.</td>
          <td colspan="3"><?php echo $tax_declaration_number ; ?></td>
        </tr>
        <tr>
          <td>Barangay/s</td>
          <td colspan="3"><?php echo $barangay ; ?></td>
        </tr>
        <tr>
          <td>Municipality/ies</td>
          <td colspan="3"><?php echo $municipality ; ?></td>
        </tr>
        <tr>
          <td>Province</td>
          <td><?php echo $province ; ?></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Total Lot Area</td>
          <td><?php echo $total_lot_area ; ?></td>
          <td>Total Lot Area Devoted to Plantation</td>
          <td><?php echo $area_devoted_to_plantation ; ?></td>
        </tr>
        <tr>
          <td>Tree Species Planted</td>
          <td colspan="3"><?php echo $number_of_trees. '  '. $species ; ?></td>
        </tr>
      </table>

      <h4>Attachments</h4>

      <table style="width: 90%; margin: auto;">
        <tr>
          <td>X</td>
          <td>Copy of Tax Declaration</td>
        </tr>
        <tr>
          <td>X</td>
          <td>GIS Generated Map of Tree Plantation</td>
        </tr>
      </table>

      <h4>I hereby certify that the above information are true and correct.</h4>
      <div style="display: flex; justify-content: space-between;">
        <div>
          <h5 style="padding-left: 100px;">LEONARDO PIZARRA</h5>
          <p style="padding-left: 40px;">Signiture over Printed Name of the Applicant</p>
        </div>
        <div>
          <h5 style="padding-right: 35px;"><?php echo $date_and_time_submitted; ?></h5>
          <p style="padding-right: 90px;">Date Submitted</p>
        </div>
      </div>

      <h4>I hereby certify that the above information are verified and the Private Tree Plantation registration is approved:</h4>

      <div style="display: flex; justify-content: space-between;">
        <div>
          <h5 style="padding-left: 100px;">IMELDA M. DIAZ</h5>
          <p style="padding-left: 90px;">OIC-PENR OFFICER</p>
        </div>
        <div>
          <h5 style="padding-right: 31px;">__________________</h5>
          <p style="padding-right: 90px;">Date Approved</p>
        </div>
      </div>
    <h6 style="text-align: center; line-height: 0;">Capitol Compound, Barangay Bangbangalon, Boac, Marinduque</h6>
    <h6 style="text-align: center; line-height: 0;">Telephone Nos: (042) 223-1490(042) 332-0727/(042) 332-297/(042) 332-1913</h6>
    <h6 style="text-align: center; line-height: 0;">Website https://penromarinduque.gov.ph/</h6>
    <h6 style="text-align: center; line-height: 0;">Email: penromarinduque@denr.gov.ph</h6>

    </div>
  </div>


  <script>generatePDF();</script>
</body>

</html>
</body>

</html>