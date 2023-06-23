<?php
  $conn = new mysqli("localhost", "root", "", "forestry-services");

  if ($mysqli -> connect_error) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }
?>