<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$userName 			= $_POST['userName'];
  $upassword 			= md5($_POST['upassword']);
  $uemail 				= $_POST['uemail'];
	$utype 					= $_POST['uType'];
	$addedBy				=	$_SESSION['userName'];

	$sql1 = "SELECT * from users where username = '$userName'";
	$result = mysqli_query($connect,$sql1);

	if(mysqli_num_rows($result)>0){
		$valid['success'] = false;
		$valid['messages'] = "Username Already Taken! Try Different Username";
}else {
	$sql = "INSERT INTO users (username, password,email,user_type)
	VALUES ('$userName', '$upassword' , '$uemail' , '$utype')";
	if($connect->query($sql) === TRUE) {

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New User created','$userName')";
		if($connect->query($sqlActivity) === TRUE)

		$valid['success'] = true;
		$valid['messages'] = "Successfully Added";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while adding the members";
	}
}
// /else
} // if in_array

	$connect->close();

	echo json_encode($valid);
