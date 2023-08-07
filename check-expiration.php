<?php
date_default_timezone_set('Asia/Manila');
$date_today = date('Y-m-d');

$select = "SELECT * FROM registrations WHERE validity_date != '' || validity_date != NULL";
$check = $conn->query($select);

while ($row = mysqli_fetch_assoc($check)) {
    if ($row['validity_date'] < $date_today) {
        $update = "UPDATE registrations SET status = 'for-expired' WHERE registration_id = $row[registration_id]";
        $conn->query($update);
    }
}

$select = "SELECT * FROM cov_registrations WHERE validity_date != '' || validity_date != NULL";
$check = $conn->query($select);

while ($row = mysqli_fetch_assoc($check)) {
    if ($row['validity_date'] < $date_today) {
        $update = "UPDATE cov_registrations SET status = 'for-expired' WHERE cov_registration_id = $row[cov_registration_id]";
        $conn->query($update);
    }
}


$select = "SELECT * FROM ptpr_registrations WHERE validity_date != '' || validity_date != NULL";
$check = $conn->query($select);

while ($row = mysqli_fetch_assoc($check)) {
    if ($row['validity_date'] < $date_today) {
        $update = "UPDATE ptpr_registrations SET status = 'for-expired' WHERE ptpr_registration_id = $row[ptpr_registration_id]";
        $conn->query($update);
    }
}
?>