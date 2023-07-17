<?php
date_default_timezone_set('Asia/Manila');


$today = getdate();
  function check_month($month){
    if($month <= 9) {
      $month = "0". $month;
      return $month;
    }else{
      return $month;
    }
  }
  function check_day($day) {
    if($day <= 9){
      $day = "0" . $day;
      return $day;
    }else{
      return $day;
    }
  }

?>