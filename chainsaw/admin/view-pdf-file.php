<?php
if(isset($_GET['doc'])){

  $document = $_GET['doc'];

  $file = '../uploads/'. $document;
  $filename = $document;
  header('Content-type: application/pdf');
  header('Content-Disposition: inline; filename="' . $filename . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($file);
}

?>
