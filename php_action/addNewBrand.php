<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$newBrandName = $_POST['newBrandName'];
	$addedBy				=	$_SESSION['userName'];

	$sql1 = "SELECT * from brands where brand_name = '$newBrandName'";
	$result = mysqli_query($connect,$sql1);

	if(mysqli_num_rows($result)>0){
		$valid['success'] = false;
		$valid['messages'] = "Already Available Brand Name";
	}else{
		$sql = "INSERT INTO brands (brand_name, brand_active, brand_status,added_by) VALUES ('$newBrandName',1, 1,'$addedBy')";

		if($connect->query($sql) === TRUE) {
			$sql1 = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Brand name added','$newBrandName')";
			if($connect->query($sql1) === TRUE)
		 	$valid['success'] = true;
			$valid['messages'] = "Successfully Added";
		} else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Error while adding the members";
		}
	}



} // /if $_POST
$connect->close();

echo json_encode($valid);
