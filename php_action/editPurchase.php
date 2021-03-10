<?php

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

  $purchaseId = $_POST['purchaseId'];

	$date = date('Y-m-d', strtotime($_POST['editDate']));
	$companyName = $_POST['editCompanyName'];
  $totalAmount = $_POST['editTotal'];
  $paidAmount = $_POST['editPaid'];
	$dueAmount = $_POST['editDue'];
  $status = $_POST['editPurchaseStatus'];
	$addedBy				=	$_SESSION['userName'];

	$sql = "UPDATE purchase SET buy_date = '$date', shopname = '$companyName',grand_total='$totalAmount',paid='$paidAmount',due='$dueAmount',status='$status' WHERE id = '$purchaseId'";

	if($connect->query($sql) === TRUE) {

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Edit Purchase','$purchaseId')";
		if($connect->query($sqlActivity) === TRUE)

	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}

	$connect->close();

	echo json_encode($valid);

} // /if $_POST
