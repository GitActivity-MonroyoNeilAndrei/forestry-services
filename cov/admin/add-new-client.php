<?php

  @include "../../database/config.php";

  $errorMessage = "";

  if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $business_name = mysqli_real_escape_string($conn, $_POST['business-name']);
    $owners_name = mysqli_real_escape_string($conn, $_POST['owners-name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact-number']);
    $email_address = mysqli_real_escape_string($conn, $_POST['email-address']);
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['password']);


    $select = " SELECT * FROM clients WHERE username = '$username' && email_address = '$email_address' && password = '$password'";
    $check = $conn->query($select);

    if(mysqli_num_rows($check) > 0){
      // if there is a data retrieve, display an error prompting the user that this email and password already exist
      $error = 'user already exist!';
    }else {
      $insert = "INSERT INTO clients (username, business_name, owners_name, address, contact_number, email_address, password) " . "VALUES ('$username', '$business_name', '$owners_name', '$address', '$contact_number', '$email_address', '$password')";
      $result = $conn->query($insert);
  
      header('location: crude-clients.php');
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
  <form method="post" class="container border border-dark rounded d-flex flex-column mt-3 px-5 py-1" style="width: 400px;">
    <h3 class="text-center border-bottom border-dark pb-2" style="--bs-border-opacity: .5;">Register New Client</h3>

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
      <label class="form-label" for="username">Username</label>
      <input class="form-control" type="text" name="username" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="business-name">Business Name</label>
      <input class="form-control" type="text" name="business-name" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="owners-name">Owners Name</label>
      <input class="form-control" type="text" name="owners-name" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="address">Address</label>
      <input class="form-control" type="text" name="address" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="contact-number">Contact Number</label>
      <input class="form-control" type="number" name="contact-number" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="email-address">Email Address</label>
      <input class="form-control" type="text" name="email-address" required>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="password">Password</label>
      <input class="form-control" type="password" name="password" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="password">Confirm Password</label>
      <input class="form-control" type="password" name="confirm-password" required>
    </div>
    
    <div class="d-flex justify-content-evenly mt-3">
      <a class="btn btn-secondary" href="crude-clients.php">Cancel</a>
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