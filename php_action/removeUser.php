<?php

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$userid = $_POST['userid'];
$addedBy=	$_SESSION['userName'];

if($userid) {

 $sql = "DELETE FROM users  WHERE user_id = {$userid}";

 if($connect->query($sql) === TRUE) {

   $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Removed User','$userid')";
   if($connect->query($sqlActivity) === TRUE)

 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the user";
 }

 $connect->close();

 echo json_encode($valid);

} // /if $_POST
