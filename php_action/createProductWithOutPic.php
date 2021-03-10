<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$productName 		= $_POST['productNameWPic'];
	$partNumber     = $_POST['partNumberWpic'];
  $quantity 			= $_POST['quantityWpic'];
  $rate 					= $_POST['rateWpic'];
  $brandName 			= $_POST['brandNameWPic'];
  $categoryName 	= $_POST['categoryNameWPic'];
  $productStatus 	= $_POST['productStatusWPic'];
	$addedBy				=	$_SESSION['userName'];
	
				$sql = "INSERT INTO product (product_name, brand_id, categories_id, quantity, rate, active, status,part_number,added_by)
				VALUES ('$productName', '$brandName', '$categoryName', '$quantity', '$rate', '$productStatus', 1,'$partNumber','$addedBy')";

				if($connect->query($sql) === TRUE) {

					$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Product added','$productName')";
					if($connect->query($sqlActivity) === TRUE)

					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}

	$connect->close();

	echo json_encode($valid);

}
