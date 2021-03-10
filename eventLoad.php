<?php
require_once 'php_action/core.php';

$data = array();

$query = "SELECT * FROM events order by id";

$statement = $connect->prepare($query);

$result = $statement->fetchAll();

foreach($result as $row)
{
  $data[]= array(
    'id'    => $row['id'],
    'title' => $row['title'],
    'start' => $row['start_event'],
    'end'   => $row['end_event']
  );

}

echo json_encode($data);

 ?>
