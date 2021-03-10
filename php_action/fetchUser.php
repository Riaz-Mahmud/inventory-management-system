<?php



require_once 'core.php';

$sql = "SELECT * FROM users WHERE admin_access > 1 GROUP BY user_id DESC";

$result = $connect->query($sql);

$output = array('data' => array());
if($result->num_rows > 0) {

 // $row = $result->fetch_array();
 $active = "";
 $userType = "";
 while($row = $result->fetch_array()) {
 	$userid = $row[0];
 	// active
 	$username = $row[1];


  if($row[4] == 1) {
    $userType = "Admin";
  } else if($row[4] == 2) {
    $userType = "User";
  }

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editUserModalBtn" data-target="#editUserModal" onclick="editUser('.$userid.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeUserModal" id="removeUserModalBtn" onclick="removeUser('.$userid.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>
	  </ul>
	</div>';



 	$output['data'][] = array(
 		// name
 		$username,
    $userType,
    // button
 		$button
 		);
 } // /while

}// if num_rows

$connect->close();

echo json_encode($output);
