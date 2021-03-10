<?php
session_start();

if(isset($_SESSION['userId'])) {
	header('location: ../../dashboard.php');
}else {
  header("Location: ../../index.php");
  exit();
}
 ?>
