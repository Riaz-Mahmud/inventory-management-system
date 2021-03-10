<?php

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$categoriesId = $_POST['categoriesId'];
$addedBy				=	$_SESSION['userName'];

if($categoriesId) {

 $sql = "UPDATE categories SET categories_status = 2 WHERE categories_id = {$categoriesId}";

 if($connect->query($sql) === TRUE) {

   $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Removed Category','$categoriesId')";
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
