<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta  name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../img/penro-logo.png">
  <title>View Document</title>
  <link rel="stylesheet" href="../../css/bootstrap.css">
</head>
<body>
  <button style="position: fixed; left: 1rem; top: 1rem;" onclick="history.back();" class="btn btn-danger">Back</button>
  <div style="width: 80vw; margin: 50px auto;">
    <img style="height: 100%; width: 100%;" src="../uploads/<?php echo $_GET['url'] ?>" alt="">
  </div>
</body>
</html>