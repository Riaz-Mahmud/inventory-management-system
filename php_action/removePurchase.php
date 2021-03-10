<?php

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$purchaseId = $_POST['purchaseId'];
$addedBy				=	$_SESSION['userName'];

if($purchaseId) {

 $sql = "UPDATE purchase SET active_status = 2 WHERE id = {$purchaseId}";

 if($connect->query($sql) === TRUE) {

   $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Removed Purchase','$purchaseId')";
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
