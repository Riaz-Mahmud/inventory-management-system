<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$productId = $_POST['productId'];
	$productName 		= $_POST['editProductName'];
	$partsNumber 		= $_POST['editPartsNumber'];
  $quantity 			= $_POST['editQuantity'];
  $rate 					= $_POST['editRate'];
  $brandName 			= $_POST['editBrandName'];
  $categoryName 	= $_POST['editCategoryName'];
  $productStatus 	= $_POST['editProductStatus'];
	$addedBy				=	$_SESSION['userName'];

	$sql = "UPDATE product SET product_name = '$productName',part_number= '$partsNumber', brand_id = '$brandName', categories_id = '$categoryName', quantity = '$quantity', rate = '$rate', active = '$productStatus', status = 1 WHERE product_id = $productId ";

	if($connect->query($sql) === TRUE) {

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Edit Product','$productName')";
		if($connect->query($sqlActivity) === TRUE)

		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info";
	}

} // /$_POST

$connect->close();

echo json_encode($valid);
