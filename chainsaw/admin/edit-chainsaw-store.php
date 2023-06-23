<?php
  @include "../../database/config.php";

  session_start();

  $id = "";
  $permit_number = "";
  $bus_name = "";
  $owners_name = "";
  $address =  "";
  $date_issued = "";
  $expiration_date = "";
  $certificate = "";

  if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!isset($_GET["id"])){
      header("location: chainsaw-stores.php");
      exit;
    }

    $id = $_GET["id"];

    $sql = "SELECT * FROM chainsaw_stores WHERE chainsaw_store_id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(!$row) {
      header("location: chainsaw-stores.php");
      exit;
    }
    $id = $row['chainsaw_store_id'];
    $permit_number = $row['permit_number'];
    $bus_name = $row['bus_name'];
    $owners_name = $row['owners_name'];
    $address =  $row['address'];
    $date_issued = $row['date_issued'];
    $expiration_date = $row['expiration_date'];
    $certificate = $row['certificate'];


  }else if(isset($_POST['submit'])) {
    $permit_number = mysqli_real_escape_string($conn, $_POST['permit-number']);
    $bus_name = mysqli_real_escape_string($conn, $_POST['bus-name']);
    $owners_name = mysqli_real_escape_string($conn, $_POST['owners-name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $date_issued = mysqli_real_escape_string($conn, $_POST['date-issued']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration-date']);

    $select = "SELECT * FROM chainsaw_stores WHERE permit_number = '$permit_number' && bus_name = '$bus_name'";
    $check = $conn->query($select);

    if(mysqli_num_rows($check) > 0){
      $error = "chainsaw store already registered";
    }else {

      $img_name = $_FILES['certificate']['name'];
      $img_size = $_FILES['certificate']['size'];
      $tmp_name = $_FILES['certificate']['tmp_name'];
      $error = $_FILES['certificate']['error'];

      if($error === 0){
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png");

        if(in_array($img_ex_lc, $allowed_exs)){
          $new_img_name = uniqid("IMG-", true). '.'.$img_ex_lc;

          $img_upload_path = '../uploads/'.$new_img_name;

          move_uploaded_file($tmp_name, $img_upload_path);

          $insert = "INSERT INTO chainsaw_stores (permit_number, bus_name, owners_name, address, date_issued, expiration_date, certificate) VALUES ('$permit_number', '$bus_name', '$owners_name', '$address', '$date_issued', '$expiration_date', '$new_img_name')";
          $result = $conn->query($insert);

          header("location: chainsaw-stores.php");
        }else{
          $display_error = "You cant upload files at this type";
        }
      }


    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chainsaw Registration</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time();?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>
<body>
  <form method="post" class="container border border-dark rounded d-flex flex-column mt-3 px-5 py-1" style="width: 400px;" enctype="multipart/form-data">
    <h3 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Register New <br> Chainsaw Store</h3>

    <?php
      
      // prompt error if user already exist
      if(isset($error)) {
        echo '
        <div class="alert alert-danger" role="alert">
          '.$error.'
        </div> ';
      }

      
      ?>

    <div class="form-group">
      <label class="form-label" for="username">Permit Number</label>
      <input class="form-control" type="text" name="permit-number" value="<?php echo $permit_number; ?>" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="business-name">Business Name</label>
      <input class="form-control" type="text" name="bus-name" value="<?php echo $bus_name; ?>" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="owners-name">Owners Name</label>
      <input class="form-control" type="text" name="owners-name" value="<?php echo $owners_name; ?>" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="address">Date Issued</label>
      <input class="form-control" type="text" name="date-issued" value="<?php echo  $date_issued; ?>" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="address">Expiration Date</label>
      <input class="form-control" type="text" name="expiration-date" value="<?php echo $expiration_date; ?>" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="address">Address</label>
      <input class="form-control" type="text" name="address" value="<?php echo $address; ?>" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="certificate">Certificate</label><br>
      <a href="view-document.php?url=<?php echo $certificate; ?>&path=edit-chainsaw-store&id=<?php echo $id; ?>"><img style="width: 70px;" src="../uploads/<?php echo $certificate; ?>" alt="img"></a>
      <input type="file" class="form-control" name="certificate" required>
    </div>

    <div class="d-flex justify-content-evenly mt-4 mb-2">
      <a class="btn btn-secondary" href="chainsaw-stores.php">Cancel</a>
      <input name="submit" type="submit" class="btn btn-primary" value="Register">
    </div>


    <a class="text-center" data-bs-toggle="modal" data-bs-target="#terms-and-condition">terms and conditions</a>
    <!-- modal for terms and conditions -->
    <div class="modal fade" id="terms-and-condition" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Terms and Conditions</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. At libero ab cumque quos voluptatem exercitationem enim, veritatis maiores tempora similique ipsa, natus reiciendis. Earum accusamus totam ducimus sapiente, odit aspernatur? Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem optio eius aliquid laborum unde sit temporibus, minima, culpa officia dolore totam? Maiores, repellendus in id quos accusamus expedita nostrum explicabo. <br> <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde, dignissimos distinctio eius mollitia eligendi itaque possimus debitis dolores, adipisci inventore odit architecto incidunt veniam obcaecati cupiditate libero perspiciatis quae laborum! Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo quod facere saepe neque dicta nemo praesentium vel voluptate illum recusandae! Aliquid, ipsum accusantium esse nobis dicta a sit aut laboriosam. <br> <br> <br> <br> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellat beatae officiis alias reiciendis temporibus laborum aliquam, recusandae, eligendi atque quas nulla odio fugit voluptates, accusantium earum corrupti placeat cupiditate iste. Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium hic doloremque, beatae cum, accusantium modi facere vero quos impedit quis saepe debitis alias repellat labore ratione commodi reiciendis dignissimos at? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officia atque similique nostrum aliquam inventore autem adipisci reiciendis porro ex, voluptate quae! Beatae possimus illo reprehenderit consequuntur nesciunt maiores dignissimos cupiditate. Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, expedita voluptatem voluptatibus rerum porro necessitatibus! Aliquid maxime eaque, repellat, nulla ab fugiat odio et, animi quaerat est nemo veniam eligendi! Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde ut tempora, magni similique maxime iste recusandae praesentium aliquam, officia quia reprehenderit sapiente ex rerum doloremque rem! Sit odio est temporibus? Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere autem, accusamus dolore mollitia obcaecati enim consequuntur, voluptates architecto aperiam nisi rerum minus aliquam eos omnis itaque nam quis. Amet, recusandae. 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  </form>
</body>
</html>