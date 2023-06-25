<?php
  session_start();
  @include "../../database/config.php";
  @include "../time.php";

  $registration_no;
  $name;
  $address;
  $purpose;
  $brand;
  $model;
  $serial_no;
  $date_of_acquisition;
  $power_output;
  $maximum_length_of_guidebar;
  $country_of_origin;
  $date_and_time_submitted;
  $received_by;
  $date_today;

  

  if(isset($_GET['id'])){
    if($conn->connect_error){
      die("Connection failed: ". $conn->connect_error);
    }

    $select = "SELECT * FROM registrations WHERE registration_id = $_GET[id]";
    $result = $conn->query($select);

    if(!$result){
      die("Invalid query: ". $conn->error);
    }else{

    while($row = $result->fetch_assoc()){

      $permit_no = "No. MR-MRQ-" . $row['registration_id'] . "-" . date('Y') ;
      $name = $row['name'];
      $address = $row['address'];
      $purpose = $row['purpose'];
      $brand = $row['brand'];
      $model = $row['model'];
      $serial_no = $row['serial_no'];
      $date_of_acquisition = $row['date_of_acquisition'];
      $power_output = $row['power_output'];
      $maximum_length_of_guidebar = $row['maximum_length_of_guidebar'];
      $country_of_origin = $row['country_of_origin'];
      $purchase_price = $row['purchase_price'];
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
        filename: 'chainsaw document.pdf',
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

      <h4 style="text-align: center;">CERTIFICATE OF REGISTRATION</h4>
      <p style="text-align: center;"><u><?php echo $permit_no; ?>(NEW)</u></p>

      <p>After having compiled with the provision of DENR Administrative Order No. 2003 -24, Series of 2003 otherwise known as “The Implementing Rules and Regulations of the Chainsaw Act of 2002 (RA No. 9175)” entitled “AN ACT REGULATING THE OWNERSHIPT, POSSESSION, SALE, IMPORTATION AND USE OF CHAINSAWS PENALIZING VIOLATIONS THEREOF AND FOR OTHER PURPOSES” this Certificate of Registration to own, possess and / or use a chainsaw hereby issued to:</p><br>
      <h4 style="text-align: center;"><?php echo $name; ?></h4>
      <p style="text-align: center;">(Name of Owner)</p>
      <p style="text-align: center;"><?php echo $address ?></p>
      <p style="text-align: center;">(Address)</p><br>

      <p style="line-height: 8px;">Bearing the following information and description:</p>
      <p style="line-height: 8px;"><bold>Use of the Chainsaw:</bold> <u><?php echo $purpose ?></u></p>
      <p style="line-height: 8px;">Brand		:	<u><?php echo $brand ?></u></p>
      <p style="line-height: 8px;">Model		:	<u><?php echo $model ?></u></p>
      <p style="line-height: 8px;">Serial No.	:	<u><?php echo $serial_no ?></u></p>
      <p style="line-height: 8px;">Date of Acquisition: <u><?php echo $date_of_acquisition ?></u>	</p>
      <p style="line-height: 8px;">Power Output(kW/bhp): <u><?php echo $power_output ?></u></p>
      <p style="line-height: 8px;">Maximum Length of Guidebar: <u><?php echo $maximum_length_of_guidebar ?></u></p>
      <p style="line-height: 8px;">Country of Origin: <u><?php echo $country_of_origin ?></u></p>
      <p style="line-height: 8px;">Purchase Price: <u><?php echo $purchase_price ?></u></p>
      <p style="line-height: 8px;">Others	:	To be used within the jurisdiction of DENR-PENRO, Marinduque</p><br>

      <p>Issued on	:	<u><?php echo $date_and_time_submitted ?></u> at DENR-PENRO, Marinduque</p>
      <p>Expiry Date	: <u><?php echo $validity_date ?></u>	</p>
      <h4>An authenticated copy of this Certification must accompany the chainsaw at all time.</h4>
      <p>APPROVED BY:</p><br>

      <h4>IMELDA M. DIAZ</h4>
      <p>OIC, PENR Officer</p><b></b>

      <p>Amount paid: Php 500.00</p>
      <p>OR. No: ___________</p>
      <p>Date: <u><?php echo $date_today ?></u></p>
      <p>***Not valid w/o PENRO Official Seal***</p><br>


      <p style="text-align: center; line-height: 2px;">Capitol Compound, Barangay, Bangbangaln, Boac, Marinduque</p>
      <p style="text-align: center; line-height: 2px;">Telephone Nos: (042) 332-1490(042) 332-0727(042) 332-1913</p>
      <p style="text-align: center; line-height: 2px;">Wesbite: https://penromarinduque.gov.ph/</p>
      <p style="text-align: center; line-height: 2px;">Email: penromarinduque@denr.gov.ph</p>



    </div>
  </div>


<script>generatePDF();</script>
</body>

</html>
</body>

</html>