<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$brandName = $_POST['editBrandName'];
  $brandStatus = $_POST['editBrandStatus'];
  $brandId = $_POST['brandId'];
	$brandDes = $_POST['editBrandDes'];
	$addedBy				=	$_SESSION['userName'];

	$sql = "UPDATE brands SET brand_name = '$brandName', brand_active = '$brandStatus',brand_des='$brandDes' WHERE brand_id = '$brandId'";

	if($connect->query($sql) === TRUE) {

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Edit Brand','$brandName')";
		if($connect->query($sqlActivity) === TRUE)

	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}

	$connect->close();

	echo json_encode($valid);

} // /if $_POST
