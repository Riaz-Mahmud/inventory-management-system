<?php

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$orderId = $_POST['orderId'];
$addedBy				=	$_SESSION['userName'];

if($orderId) {

 $sql = "UPDATE orders SET order_status = 2 WHERE order_id = {$orderId}";

 $orderItem = "UPDATE order_item SET order_item_status = 2 WHERE  order_id = {$orderId}";

 if($connect->query($sql) === TRUE && $connect->query($orderItem) === TRUE) {

   $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Removed Order','$orderId')";
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
