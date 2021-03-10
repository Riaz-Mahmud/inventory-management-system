<?php

require_once 'php_action/core.php';
$addedBy	=	$_SESSION['userName'];

	if($addedBy !="riazmahmud") {
        $sql1 = "INSERT INTO activity (name,details) VALUES ('$addedBy','Logout')";
        if($connect->query($sql1) === TRUE){}
    }
// remove all session variables
session_unset();

// destroy the session
session_destroy();

header('location: http://localhost/inventory-management-system/index.php');

?>
