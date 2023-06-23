<?php
@include 'database/config.php';

session_start();

// checks if the user is an ordinary user
if(!isset($_SESSION['admin_username'])){
   // if not go back to the index file or page
   header('location: ../../login-register-account/login-admin.php');
}

?> 



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="css/homepage.css?php echo time(); ?>">

    <style type="text/css">
        body {
            background-image: url(img/forestry-background.jpg);
            background-size: cover;
        }

        h1 {
            color: white;
            font-size: 5em;
            position: absolute;
            top: 5vh;
            left: 50%;
            transform: translate(-50%);
            color: rgb(120, 240, 160);
        
        }

        h4 {
            color: white;
            font-size: 3em;
            position: absolute;
            top: 18vh;
            left: 50%;
            transform: translate(-50%);
            color: rgb(120, 240, 160);
        
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.60);
            height: 100vh;
            width: 100vw;
        }

        .container {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        a {
            box-shadow: 7px 7px 10px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>

<h1>Forestry Services</h1>
<h4>admin</h4>
    <div class="overlay">

    </div>
    <div class="container">
        
        <a href="chainsaw/admin/crude-clients.php">
            <img src="img/icons/chainsaw.PNG" alt="">
        </a>
        <a href="cov/admin/crude-clients.php">
            <img src="img/icons/cov.PNG" alt="">
        </a>
        <a href="ptpr/admin/crude-clients.php">
            <img src="img/icons/ptpr.PNG" alt="">
        </a>
    </div>

</body>

</html>


