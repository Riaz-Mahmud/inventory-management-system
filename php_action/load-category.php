<?php
require_once 'core.php';

$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
$result = $connect->query($sql);

while($row = $result->fetch_array()) {
  echo "<option value='".$row[0]."'>".$row[1]."</option>";
} // while

?>
