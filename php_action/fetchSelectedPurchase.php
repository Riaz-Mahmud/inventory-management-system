<?php

require_once 'core.php';

$purchaseId = $_POST['purchaseId'];

$sql = "SELECT id, buy_date,shopname, grand_total, paid, due, status FROM purchase WHERE id = $purchaseId";
$result = $connect->query($sql);

if($result->num_rows > 0) {
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);
