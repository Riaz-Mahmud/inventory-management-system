<?php

require_once 'core.php';

$sql = "SELECT id,buy_date,shopname,grand_total,paid,due,status FROM purchase
        WHERE active_status=1 GROUP BY id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) {

 // $row = $result->fetch_array();
$i =0;
 while($row = $result->fetch_array()) {
   $i++;
   $id = $row[0];
   $buy_date = $row[1];
   $companyName = $row[2];
 	 $total = $row[3];
   $paid = $row[4];
   $due = $row[5];
 	// active
 	if($row[6] == 1) {
 		// activate member
 		$active = "<label class='label label-success'>Active</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>Deactivate</label>";
 	} // /else

  $button = '<!-- Single button -->
 <div class="btn-group">
   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     Action <span class="caret"></span>
   </button>
   <ul class="dropdown-menu">
     <li><a type="button" data-toggle="modal" id="editPurchaseModalBtn" data-target="#editPurchaseModel" onclick="editPurchase('.$id.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
     <li><a type="button" data-toggle="modal" data-target="#removePurchaseModalBtn" id="removePurchaseModal" onclick="removePurchase('.$id.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>
   </ul>
 </div>';

 	$output['data'][] = array(
 		$i,
    $buy_date,
    $companyName,
    $total ,
    $paid ,
    $due,
    // active
 		$active,
    $button
 		);
 } // /while

}// if num_rows

$connect->close();

echo json_encode($output);
