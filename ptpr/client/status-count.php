<?php 
@include '../../database/config.php';

if($conn->connect_error){
  die("Connection Error: ". $conn->connect_error);
  exit;
}

function status_count($conn, $status) {

  $select_draft = "SELECT COUNT(*) AS 'app_count' FROM ptpr_registrations WHERE status = '$status' && ptpr_client_id = '$_SESSION[ptpr_client_id]'";
  $result_draft = $conn->query($select_draft);

  $row = $result_draft->fetch_assoc();

  $number_of_draft = $row['app_count'];

  return $number_of_draft;
}
  

?>