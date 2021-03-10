<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$brandName = $_POST['brandName'];
	$brandDes = $_POST['brandDes'];
  $brandStatus = $_POST['brandStatus'];
	$addedBy				=	$_SESSION['userName'];

	$sql1 = "SELECT * from brands where brand_name = '$brandName'";
	$result = mysqli_query($connect,$sql1);

	if(mysqli_num_rows($result)>0){
		$valid['success'] = false;
		$valid['messages'] = "Already Available Brand Name";
	}else{
		$sql = "INSERT INTO brands (brand_name,brand_des, brand_active, brand_status,added_by) VALUES ('$brandName','$brandDes','$brandStatus', 1,'$addedBy')";

		if($connect->query($sql) === TRUE) {
			$sql1 = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Brand name added','$brandName')";
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
