<?php
session_start();
@include "../../database/config.php";
@include "../time.php";

$control_no;
$name;
$address;
$purpose;
$location_from;
$location_to;
$species;
$number_of_trees;
$gross_volume;
$net_volume;
$date_and_time_submitted;
$received_by;
$validity_date;
$date_today;



if (isset($_GET['id'])) {
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $select = "SELECT * FROM cov_registrations WHERE cov_registration_id = $_GET[id]";
  $result = $conn->query($select);

  if (!$result) {
    die("Invalid query: " . $conn->error);
  } else {

    while ($row = $result->fetch_assoc()) {

      $control_no = $today['year'] . '-' . $row['cov_registration_id'];
      $name = $row['name'];
      $address = $row['address'];
      $purpose = $row['purpose'];
      $location_from = $row['location_from'];
      $location_to = $row['location_to'];
      $species = $row['species'];
      $number_of_trees = $row['number_of_trees'];
      $gross_volume = $row['gross_volume'];
      $net_volume = $row['net_volume'];
      $drivers_name = $row['drivers_name'];
      $or_number = $row['or_number'];
      $plate_number = $row['plate_number'];
      $date_and_time_submitted = $row['date_and_time_submitted'];
      $received_by = $row['received_by'];
      $validity_date = $row['validity_date'];
      $date_today = $today['year'] . '-' . check_month($today['mon']) . '-' . check_day($today['mday']);
    }
  }
} else {
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
        filename: 'COV.pdf',
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

</head>

<body>

  <div class="container_content" style="padding: 0px 20px 25px 20px;" id="container_content">
    <div class="paper" style="height: 188vh;">
      <div class="header" style="display: flex; border-bottom: 2px solid red;">
        <img style="width: 100px; margin-right: 25px; padding-left: 50px;" src="penroLogo.png" alt="">
        <div class="header-text">
          <h4>Republic of the Pasfdafdfhilippines <br>
            Department of Environment and Natural Resources <br>
            PENRO Marinduque</h4>

        </div>
      </div>
      <h5 style="line-height: 0;">Control No. <u><?php echo $control_no; ?></u></h5>
      <h4 style="line-height: 0; text-align: center;">CERTIFICATE OF VERIFICATION</h4>
      <h4 style="line-height: 0;">To all Conern:</h4>
      <p style="text-align: justify;"><span style="visibility: hidden;">wwwww</span>Be informed that I, <?php echo $name; ?> is a holder of Private Land Timber Permit from the DENR PENRO Marinduque bearing control Number PLTP No. ____________ to cut/utilize manufacture <?php echo $number_of_trees; ?> <?php echo $species; ?> trees located at <?php echo $location_from; ?>. That I am transporting the following forest products gathered from <?php echo $location_from; ?> described as follows, to wit:</p>

      <p style="line-height: 0;">1. Kind, species, quantity & vol. of forest products: <u><?php echo $species; ?> <?php echo $number_of_trees; ?>. <?php echo $gross_volume; ?>;</u></p>
      <p style="line-height: 0;">2. Conveyance:______________________ <u>OR no. <?php echo $or_number; ?> Plate No: <?php echo $plate_number; ?>;</u></p>
      <p style="line-height: 0;">3. Driver: <u><?php echo $drivers_name; ?></u></p>
      <p style="line-height: 0;">4. Consignee/Destination <u><?php echo $location_to; ?></u></p>
      <h4 style="line-height: 0; text-align: right; padding-right: 30px;"><u><?php echo $name; ?></u></h4>
      <p style="line-height: 0; text-align: right; padding-right: 80px;">Owner</p><br>
      <h4 style="text-align: center;">CERTIFICATION</h4>
      <h5 style="line-height: 0;">To whom it may concern:</h5>
      <p><span style="visibility: hidden;">wwwww</span>This is to certify that the above described forest products had been verified by this Office to have originated from the private land and is hereby allowed to be transforted with the following particulars:</p>
      <p style="line-height: 0;"><span style="visibility: hidden;">wwwww</span>Described Route From : <u><?php echo $location_from; ?></u></p>
      <p style="line-height: 0;"><span style="visibility: hidden;">wwwww</span><span style="visibility: hidden;">wwwww</span>To : <u><?php echo $location_to; ?></u></p>
      <p style="line-height: 0;"><span style="visibility: hidden;">wwwww</span>Validity Date From : ___________</p>
      <p style="line-height: 0;"> <span style="visibility: hidden;">wwwww</span><span style="visibility: hidden;">wwwww</span>To : ________</p>
      <p style="line-height: 0;"><span style="visibility: hidden;">wwwww</span>Others : Please see attached copy of the Private Land Timber Permit from DENR PENRO Marinduque</p>
      <p><span style="visibility: hidden;">wwwww</span>Certification and inspection fees in the amount of Php _____ in favor of the Department and Environment and Natural Resources were paid under Official Receipt No. ______ dated _______.</p>
      <p style="line-height: 0;">Scaled by:</p>
      <h4 style="line-height: 0; padding-left: 40px">RANDY N. ESTRELLA</h4>
      <p style="padding-left: 60px;">Forest Ranger</p>
      <p>Attested by:</p>
      <h4 style="line-height: 0; text-align: right; padding-right: 50px;"><u>Engr. CYNTHIA U. LOZANO</u></h4>
      <p style="line-height: 0; text-align: right; padding-right: 40px;">Chief, Technical Services Division</p>
      <p style="text-align: center;">SUBSCRIBED AND SWORN to before me this ___ day of ____ at Boac Marinduque.</p>
      <h4 style="line-height: 0; text-align:right; padding-right: 85px;">IMELDA M. DIAZ</h4>
      <p style="line-height: 0; text-align:right; padding-right: 90px;"><u>OIC, PENR Officer</u></p>
      <p style="line-height: 0; text-align:right; padding-right: 40px;">Authorized Person to Administer Oath</p>
      <p>NOTE: The shipper is liable of any unaccounted lumbers or forest products aside from the herein certified lumber shipment.</p>
      <div style="border-bottom: 1px dashed black;">
        <p style="line-height: 0; text-align: center;">THIS PERMIT IS NOT VALID IF IT CONTAINS ERASURE OR ALTERATION</p>
      </div>
      <h5>Control No.:<?php echo $control_no; ?></h5>
      <h4 style="text-align: center;">ARRIVAL CONFIRMATION RECEIPT</h4>
      <p>Date: _______________</p>
      <p style="line-height: 10px;">This is to acknowledge the arrival of the transported forest products within this area of responsibility with the following particulars, to wit:</p>

      <div style="display: flex;">
        <div>
          <p style="line-height: 0;">1.Volume, kind and species: <u><?php echo $gross_volume . ' ' . $species; ?> </u></p>
          <p style="line-height: 0;">2.SMF Control No.: <u><?php echo $control_no; ?> </u></p>
          <p style="line-height: 0;">3.Description of Conveyance:______________</p><br>
        </div>
        <div> 
          <p style="line-height: 0;">4. Date of Arrival._________________</p>
          <p style="line-height: 0;">5. Consigneess/Destination: <u><?php echo $location_to; ?></u></p> 
          <p style="line-height: 0;">6.Scaler:_________________</p></div>
      </div>





      <p style="line-height: 0;">ORIGINAL COPY : OWNER TO ACCOMPANY TRANSPORT</p>
      <p style="line-height: 0;">DUPLICATE COPY : PENRO FILE</p>
      <p style="line-height: 0;">TRIPLICATE : OWNER FILE</p>


      <h6>***Not Valid Without Official DENR PENRO Marinduque Dry Seal***</h6>



    </div>

  </div>
  <script>
    generatePDF();
  </script>
</body>

</html>
</body>

</html>