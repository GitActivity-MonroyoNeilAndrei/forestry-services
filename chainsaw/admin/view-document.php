<?php
  if(isset($_GET['id'])){
    $id = $_GET["id"];
  }else {
    $id = "";
  }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="../../css/admin.css?<?php echo time(); ?>">
</head>
<body>
  <button class="btn btn-danger" style="position: fixed; left: 1rem; top: 1rem;" onclick="history.back();">Back</button>
  <div style="width: 80vw; margin: 50px auto;">
    <img style="height: 100%; width: 100%;" src="../uploads/<?php echo $_GET['url'] ?>" alt="">
  </div>
</body>
</html>