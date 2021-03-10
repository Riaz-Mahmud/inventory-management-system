<?php

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$brandId = $_POST['brandId'];
$addedBy				=	$_SESSION['userName'];

if($brandId) {

 $sql = "UPDATE brands SET brand_status = 2 WHERE brand_id = {$brandId}";

 if($connect->query($sql) === TRUE) {

   $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Removed Brand','$brandId')";
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
