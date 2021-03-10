<?php
require_once 'php_action/core.php';


if (isset($_POST["title"])) {
  $query = "INSERT INTO events(title,start_event, end_event)
  VALUES(:title, :start_event, :end_event)";

  $statement = $connect->prepare($query);
  $statement->execute(
    array(
      ':tital'        => $_POST['title'],
      ':start_event'  => $_POST['start'],
      ':end_event'    => $_POST['end'],
    )
  );
}


 ?>
