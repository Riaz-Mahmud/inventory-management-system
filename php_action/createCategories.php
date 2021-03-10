<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$categoriesName = $_POST['categoriesName'];
  $categoriesStatus = $_POST['categoriesStatus'];
	$addedBy				=	$_SESSION['userName'];

	$sql1 = "SELECT * from categories where categories_name = '$categoriesName'";
	$result = mysqli_query($connect,$sql1);

	if(mysqli_num_rows($result)>0){
		$valid['success'] = false;
		$valid['messages'] = "Already Available Category Name";
	}else{

	$sql = "INSERT INTO categories (categories_name, categories_active, categories_status,added_by)
	VALUES ('$categoriesName', '$categoriesStatus', 1,'$addedBy')";

	if($connect->query($sql) === TRUE) {
		$sql1 = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Category name added','$categoriesName')";
		if($connect->query($sql1) === TRUE)
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
}
	$connect->close();

	echo json_encode($valid);

} // /if $_POST
