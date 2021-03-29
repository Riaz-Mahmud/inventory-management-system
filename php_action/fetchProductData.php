<?php

require_once 'core.php';

$sql = "SELECT product_id, product_name FROM product WHERE status = 1 AND active = 1 AND quantity != 0 GROUP BY product_name ASC";
$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);
