<?php 

  function fileIsImage($inputName) {
    $img_name = $_FILES["$inputName"]['name'];
    $img_size = $_FILES["$inputName"]['size'];
    $tmp_name = $_FILES["$inputName"]['tmp_name'];
    $error = $_FILES["$inputName"]['error'];


    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);
    $allowed_exs = array('jpg', 'jpeg', 'png');

    if (!in_array($img_ex_lc, $allowed_exs)) { // not image file
      return false;
    }else {
      return true;
    }
  }

  function fileIsEmpty($inputName) {
    if($_FILES["$inputName"]['name'] == "") {
        return true;
      }else {
        return false;
      }
  }



  function updateImage($inputName, $conn, $table, $column, $path, $id = array())
  {
    $img_name = $_FILES["$inputName"]['name'];
    $img_size = $_FILES["$inputName"]['size'];
    $tmp_name = $_FILES["$inputName"]['tmp_name'];
    $error = $_FILES["$inputName"]['error'];

    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);

    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;

    $img_upload_path = $path . $new_img_name;

    move_uploaded_file($tmp_name, $img_upload_path);

    $select = "SELECT * FROM $table WHERE $id[0] = $id[1]";
    $check = $conn->query($select);

    while ($row = $check->fetch_assoc()) {
      unlink("$path" . $row["$column"]);
    }

    $update = "UPDATE $table SET $column = '$new_img_name' WHERE $id[0] = $id[1]";
    $conn->query($update);
  }


  // if(!fileIsImage('thisImage')) {
  //   $error1 = "Upload image file only ";
  // } else if (!fileIsImage('thisImage2')) {
  //   $error2 = "Upload Image file Only";
  // } else {
  //   if(!fileIsEmpty('thisImage')) {
  //     updateImage('thisImage', $conn, 'registrations', 'official_receipt', '../../path', ['registration_id', 3]);
  //   }
  //   if(!fileIsEmpty('thisImage2')) {
  //     updateImage('thisImage2', $conn, 'registrations', 'mayors_permit', '../../path', ['registration_id', 3]);
  //   }
  //   $sql = "UPDATE registrations " . "SET name = '$name', address = '$address', purpose = '$purpose', chainsaw_receipt = '$new_img_name1', mayors_permit = '$new_img_name2', brand = '$brand', model = '$model', serial_no = '$serial_number', date_of_acquisition = '$date_of_acquisition', power_output = '$power_output', maximum_length_of_guidebar = '$maximum_length_of_guidebar', country_of_origin = '$country_of_origin', purchase_price = '$purchase_price', chainsaw_store = '$chainsaw_store', received_by = '$admin_username', date_and_time_submitted = '$date_and_time_submitted', status = '$status' " . "WHERE registration_id = $id";
  //   $result = $conn->query($sql);

  //   header("location: reg-stat-mon-for-submitted.php");
  // }




?>