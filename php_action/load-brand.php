<?php
require_once 'core.php';

$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
$result = $connect->query($sql);

while($row = $result->fetch_array()) {
  echo "<option value='".$row[0]."'>".$row[1]."</option>";
} // while

?>
