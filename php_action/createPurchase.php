<?php

require_once 'core.php';
date_default_timezone_set("Asia/Dhaka");
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

  $orderDate       = date('Y-m-d', strtotime($_POST['orderDate']));
	$compnayName     = $_POST['companyName'];
	$Total           = $_POST['totalAmount'];
  $Paid            = $_POST['paidAmount'];
  $Due             = $_POST['dueAmount'];
  $Status          = $_POST['purchaseStatus'];
	$addedBy				=	$_SESSION['userName'];

  if ($_POST['orderDate']=="") {
    $orderDate = date("Y-m-d");
  }

		$sql = "INSERT INTO purchase (buy_date,shopname, grand_total, paid,due,status)
    VALUES ('$orderDate','$compnayName','$Total', '$Paid','$Due','$Status ')";

		if($connect->query($sql) === TRUE) {

      $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Purchase added','$compnayName')";
      if($connect->query($sqlActivity) === TRUE)

		 	$valid['success'] = true;
			$valid['messages'] = "Successfully Added";
		} else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Error while adding the members";
		}
} // /if $_POST
$connect->close();

echo json_encode($valid);
