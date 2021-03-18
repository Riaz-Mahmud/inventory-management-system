<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$productName 		= $_POST['productName'];
	$partNumber     = $_POST['partNumber'];
  // $productImage 	= $_POST['productImage'];
  $quantity 			= $_POST['quantity'];
	$unit 					= $_POST['unit'];
  $rate 					= $_POST['rate'];
	$buyRate 					= $_POST['buyRate'];
  $brandName 			= $_POST['brandName'];
  $categoryName 	= $_POST['categoryName'];
  $productStatus 	= $_POST['productStatus'];
	$addedBy				=	$_SESSION['userName'];


if($_FILES['productImage']['name'] == "") {
	$sql = "INSERT INTO product (product_name, brand_id, categories_id, quantity, unit, rate,buyRate, active, status,part_number,added_by)
	VALUES ('$productName', '$brandName', '$categoryName', '$quantity', '$unit', '$rate', '$buyRate', '$productStatus', 1,'$partNumber','$addedBy')";

	if($connect->query($sql) === TRUE) {

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Product added','$productName')";
		if($connect->query($sqlActivity) === TRUE)

		$valid['success'] = true;
		$valid['messages'] = "Successfully Added";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while adding the members";
	}
}else {
	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type)-1];
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {
			if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {

				$sql = "INSERT INTO product (product_name, product_image, brand_id, categories_id, quantity,unit, rate, buyRate, active, status,part_number,added_by)
				VALUES ('$productName', '$url', '$brandName', '$categoryName', '$quantity', '$unit','$rate', '$buyRate', '$productStatus', 1,'$partNumber','$addedBy')";

				if($connect->query($sql) === TRUE) {

					$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Product added','$productName')";
					if($connect->query($sqlActivity) === TRUE)

					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}

			}	else {
				return false;
			}	// /else
		} // if

	} // if in_array
}

	$connect->close();

	echo json_encode($valid);

} // /if $_POST
