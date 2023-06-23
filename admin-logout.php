<?php

@include 'database/config.php';

// destroy all the data that is being stored in the pages

session_start();
session_unset();
session_destroy();

header('location: login-register-account/login-admin.php');

?>