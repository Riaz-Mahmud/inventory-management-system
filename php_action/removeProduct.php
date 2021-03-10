<?php

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$productId = $_POST['productId'];
$addedBy	 =	$_SESSION['userName'];

if($productId) {

 $sql = "UPDATE product SET active = 2, status = 2 WHERE product_id = {$productId}";

 if($connect->query($sql) === TRUE) {

   $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Removed Product','$productId')";
   if($connect->query($sqlActivity) === TRUE)

 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }

 $connect->close();

 echo json_encode($valid);

} // /if $_POST
