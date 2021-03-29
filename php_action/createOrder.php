<?php
//ALTER TABLE `orders` ADD `payment_place` INT NOT NULL AFTER `payment_status`;
//TER TABLE `orders` ADD `gstn` VARCHAR(255) NOT NULL AFTER `payment_place`;
require_once 'core.php';

$n=5;
function getName($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
// print_r($valid);
if($_POST) {

	$GetOrderDate = $_POST['orderDate'];
	$timestamp = strtotime($GetOrderDate);
	$getMonth = date("m", $timestamp);
	$getYear	= date("Y", $timestamp);

	$orderDate 						= date('Y-m-d', strtotime($_POST['orderDate']));
	$clientName 					= $_POST['clientName'];
  $clientContact 				= $_POST['clientContact'];
  $subTotalValue 				= $_POST['subTotalValue'];
  $vatValue 						=	$_POST['vatValue'];
  $totalAmountValue     = $_POST['totalAmountValue'];
  $discount 						= $_POST['discount'];
  $grandTotalValue 			= $_POST['grandTotalValue'];
  $paid 								= $_POST['paid'];
  $dueValue 						= $_POST['dueValue'];
  $paymentType 					= $_POST['paymentType'];
  $paymentStatus 				= $_POST['paymentStatus'];
  // $paymentPlace 				= $_POST['paymentPlace'];
  $gstn 				= $_POST['gstn'];
  $userid 				= $_SESSION['userId'];
	$addedBy				=	$_SESSION['userName'];



	$sqlInvoice = "SELECT order_id FROM orders GROUP BY order_id DESC LIMIT 1";
	$resultInvoice = mysqli_query($connect,$sqlInvoice);
	$rowInvoice = mysqli_fetch_array($resultInvoice);
	$lastOrderId = 	$rowInvoice['order_id'];
	if (empty($lastOrderId)) {
		//echo getName($n);
		$invoiceId = 'JK-'.getName($n).'-'.'01';
	}else {
		$plusOneInLastOrder = $lastOrderId+1;
		$invoiceId ='JK-0'.getName($n).'-'.$plusOneInLastOrder;
	}

	$sql = "INSERT INTO orders (invoiceId,order_month,order_year,order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_type, payment_status, gstn,order_status,user_id) VALUES ('$invoiceId','$getMonth','$getYear','$orderDate', '$clientName', '$clientContact', '$subTotalValue', '$vatValue', '$totalAmountValue', '$discount', '$grandTotalValue', '$paid', '$dueValue', $paymentType, $paymentStatus,$gstn, 1,$userid)";

	$order_id;
	$orderStatus = false;
	if($connect->query($sql) === true) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;

		$orderStatus = true;

		$sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','New Order added','$order_id')";
		if($connect->query($sqlActivity) === TRUE){}

    // echo $_POST['productName'];
  	$orderItemStatus = false;

  	for($x = 0; $x < count($_POST['productName']); $x++) {
  		$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
  		$updateProductQuantityData = $connect->query($updateProductQuantitySql);


  		while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
  			$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];
  				// update product table
  				$updateProductTable = "UPDATE product SET quantity = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
  				$connect->query($updateProductTable);

  				// add into order_item
  				$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status)
  				VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rate'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

  				$connect->query($orderItemSql);

  				if($x == count($_POST['productName'])) {
  					$orderItemStatus = true;
  				}
  		} // while
  		$valid['success'] = true;
  		$valid['messages'] = "Successfully Added";
  	} // /for quantity


	}






	$connect->close();

	echo json_encode($valid);

} // /if $_POST
// echo json_encode($valid);
