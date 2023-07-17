<?php 
  @include "../../database/config.php";
  @include "../time.php";
date_default_timezone_set('Asia/Manila');

 session_start();


  if (isset($_POST['submit'])) {
    $pdf_name1 = $_FILES['pdf-file']['name'];
    $pdf_size1 = $_FILES['pdf-file']['size'];
    $tmp_name1 = $_FILES['pdf-file']['tmp_name'];
    $error1 = $_FILES['pdf-file']['error'];
  
  
    if ($error1 === 0) {
      $pdf_ex1 = pathinfo($pdf_name1, PATHINFO_EXTENSION);
      $pdf_ex_lc1 = strtolower($pdf_ex1);
  
  
      $allowed_exs = array("pdf");
  
      if (in_array($pdf_ex_lc1, $allowed_exs)) {
        $new_pdf_name1 = uniqid("FILE-", true) . '.' . $pdf_ex_lc1;
  
        $pdf_upload_path1 = '../uploads/' . $new_pdf_name1;
  
        move_uploaded_file($tmp_name1, $pdf_upload_path1);

        $permit_number = $_GET['id'] .'-'. date('Y');
        $date_and_time_released = date('Y-m-d H:i:s');
        $released_by = $_SESSION['admin_username'];
        $validity_date =   ($today['year']+2) .'-'. check_month($today['mon']) .'-'. check_day($today['mday']);
        $status = 'for-released';
  
        $update = "UPDATE registrations SET documents = '$new_pdf_name1', permit_number = '$permit_number', date_and_time_released = '$date_and_time_released', released_by = '$released_by', validity_date = '$validity_date', status = '$status' WHERE registration_id = $_GET[id]";
        $result = $conn->query($update);
        header("location: release-applications.php");
      }    else {
        $error = "upload only PDF file";
      }
    }    else {
      $error = "upload only PDF file";
    }

  }
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/admin.css?<?php echo time(); ?>">
  <style type="text/css">
    form {
      max-width: 30rem;
      padding: .5rem 1rem;
      border: 1px solid black;
      border-radius: 10px;
      margin: auto;
      margin-top: 4rem;

      display: flex;
      flex-direction: column;
    }

    input[type="submit"] {
      width: auto;
      margin: auto;
    }
    button {
      position: absolute;
      left: 1rem;
      top: 1rem;
    }
  </style>
</head>

<body>
  <button onclick="history.back();" class="btn btn-danger">Back</button>
  <form method="post" enctype="multipart/form-data">
    <h4 class="text-center">Upload Image of Certificate</h4>
    <h4 class="text-center">and Requirements</h4>
    <?php 
      if (isset($error)) {
        echo '
        <div class="alert alert-danger" role="alert">'
          .$error.'
        </div>
        ';
      }
    ?>
    <div class="input-group mb-3">
      
      <input type="file" class="form-control" id="inputGroupFile02" name="pdf-file">
      
    </div>
    <input class="btn btn-success" type="submit" name="submit" value="Upload PDF file">
  </form>
</body>

</html>