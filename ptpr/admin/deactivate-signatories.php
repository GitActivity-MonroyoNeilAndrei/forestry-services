<?php
  @include "../../database/config.php";

	if(isset($_POST['yes'])) {
		$id = $_GET["id"];

		if($_GET['status'] == 'activated') {
			$sql = "UPDATE signatories SET status = 'activated' WHERE signatories_id=$id";
			$conn->query($sql);
			header('location: crude-signatories.php');
		} else if ($_GET['status'] == 'deactivated') {
			$sql = "UPDATE signatories SET status = 'deactivated' WHERE signatories_id=$id";
			$conn->query($sql);
			header('location: crude-signatories.php');
		}

		
		exit;
	}else if (isset($_POST['no'])){
		header("location: crude-signatories.php");
		exit;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Deactivate Signatory</title>
  <link rel="stylesheet" href="../../css/bootstrap.css?<?php echo time();?>">
  <script defer src="../../js/bootstrap.js"></script>
  <script defer src="../../js/script.js"></script>
</head>
<body>
	<form method="post" class="border border-dark mt-5 mx-auto px-5 py-3" style="max-width: 500px;">
		<h4 class="text-center">Are You Sure You want to  <?php echo $_GET['status']; ?>  this Signatory?</h4>
		<div class="row">
			<input class="btn btn-success mb-2" type="submit" name="yes" value="Yes">
			<input class="btn btn-danger" type="submit" name="no" value="No" >
		</div>
	</form>
</body>
</html>