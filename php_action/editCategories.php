<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$brandName = $_POST['editCategoriesName'];
  $brandStatus = $_POST['editCategoriesStatus'];
  $categoriesId = $_POST['editCategoriesId'];
	$addedBy				=	$_SESSION['userName'];

	$sql = "UPDATE categories SET categories_name = '$brandName', categories_active = '$brandStatus' WHERE categories_id = '$categoriesId'";

	if($connect->query($sql) === TRUE) {

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Edit Categorie','$brandName')";
		if($connect->query($sqlActivity) === TRUE)

	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while updating the categories";
	}

	$connect->close();

	echo json_encode($valid);

} // /if $_POST
