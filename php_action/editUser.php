<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$edituserName = $_POST['edituserName'];
	$editPassword 		= md5($_POST['editPassword']);
	$userid 		= $_POST['userid'];
	$userType 		= $_POST['editUserType'];
	$addedBy				=	$_SESSION['userName'];

	$sql = "UPDATE users SET username = '$edituserName', password = '$editPassword', user_type='$userType' WHERE user_id = $userid ";

	if($connect->query($sql) === TRUE) {

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Edit Userinfo','$userid')";
		if($connect->query($sqlActivity) === TRUE)

		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating user info";
	}

} // /$_POST

$connect->close();

echo json_encode($valid);
