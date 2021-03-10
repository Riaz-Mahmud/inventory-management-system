<?php

require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
 		product.categories_id, product.quantity, product.rate, product.active, product.status,
 		brands.brand_name, categories.categories_name,product.part_number FROM product
		INNER JOIN brands ON product.brand_id = brands.brand_id
		INNER JOIN categories ON product.categories_id = categories.categories_id
		WHERE product.status = 1 GROUP BY  product.product_id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) {

 // $row = $result->fetch_array();
 $active = "";
 $demoTotal=0;

 while($row = $result->fetch_array()) {

   $Qun = $row[5];
   $Rate = $row[6];
   $TotalProductPrice = $Qun * $Rate;

  $demoTotal = $demoTotal + $TotalProductPrice;

 	$productId = $row[0];
 	// active
 	if($row[7] == 1) {
 		// activate member
 		$active = "<label class='label label-success'>Available</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>Not Available</label>";
 	} // /else


	$brand = $row[9];
	$category = $row[10];
	$partNum = $row[1];

	$imageUrl = substr($row[2], 3);
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array(
 		// image
 		$productImage,
 		// product name
 		$row[1],
    $row[11],
 		// rate
 		$row[6],
 		// quantity
 		$row[5],


    $TotalProductPrice,
    // active
 		$active
 		);
 } // /while

}// if num_rows

$connect->close();

echo json_encode($output);
