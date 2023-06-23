<?php

@include '../../database/config.php';

// destroy all the data that is being stored in the pages

session_start();
unset($_SESSION["admin_username"]);

header('location: ../../login-register-account/login-admin.php');

?>