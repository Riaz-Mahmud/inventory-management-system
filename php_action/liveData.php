<?php require_once 'core.php';
?>

<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading">
      <i class="glyphicon glyphicon-calendar"></i> User Wise Order
      <img src="http://localhost/inventory-management-system/assests/images/liveLogo.png" alt="Paris" class="pull-right" style="margin-right: auto;width:40px;">
    </div>
    <div class="panel-body">
      <table class="table" id="productTable">
        <thead>
          <tr>
            <th style="width:40%;">Name</th>
            <th style="width:20%;">Orders in BDT</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $userwisesql = "SELECT users.username , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
        $userwiseQuery = $connect->query($userwisesql);
        $userwieseOrder = $userwiseQuery->num_rows;
        while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $orderResult['username']?></td>
            <td><?php echo $orderResult['totalorder']?></td>

          </tr>
        <?php } ?>
      </tbody>
      </table>
    </div>
  </div>
  <?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1 && $_SESSION['userName'] =="admin" && $_SESSION['adminAccess'] == 1) { ?>
  <div class="col-md-16">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="glyphicon glyphicon-eye-open"></i> User Activity
        <img src="http://localhost/inventory-management-system/assests/images/liveLogo.png" alt="Paris" class="pull-right" style="margin-right: auto;width:40px;">
      </div>
      <div class="panel-body">
        <table class="table" id="productTable">
          <thead>
            <tr>
              <th style="width:10%;">Username</th>
              <th style="width:20%;">Details</th>
              <th style="width:20%;">Name/ID</th>
              <th style="width:30%;">Date & Time</th>
            </tr>
          </thead>
          <tbody>
          <?php

          $lastTrans="SELECT * FROM activity group BY id DESC LIMIT 15";
          $lastTransQuery = $connect->query($lastTrans);

          while ($lastTransResult = $lastTransQuery->fetch_assoc()) { ?>
            <tr>
              <td><?php echo $lastTransResult['name']?></td>
              <td><?php echo $lastTransResult['details']?></td>
              <td><?php echo $lastTransResult['itemName']?></td>
              <td><?php echo $lastTransResult['createTime']?></td>
            </tr>
          <?php } ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php } ?>

</div>

<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading">
      <i class="glyphicon glyphicon-usd"></i> Last 5 Transaction
      <img src="http://localhost/inventory-management-system/assests/images/liveLogo.png" alt="Paris" class="pull-right" style="margin-right: auto;width:40px;">
    </div>
    <div class="panel-body">
      <table class="table" id="productTable">
        <thead>
          <tr>
            <th style="width:40%;">Name</th>
            <th style="width:20%;">Amount</th>
            <th style="width:20%;">Paid</th>
            <th style="width:20%;">Due</th>
          </tr>
        </thead>
        <tbody>
        <?php

        $lastTrans="SELECT client_name, grand_total,paid,due FROM orders group BY order_id DESC LIMIT 5";
        $lastTransQuery = $connect->query($lastTrans);

        while ($lastTransResult = $lastTransQuery->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $lastTransResult['client_name']?></td>
            <td><?php echo $lastTransResult['grand_total']?></td>
            <td><?php echo $lastTransResult['paid']?></td>
            <td><?php echo $lastTransResult['due']?></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
    </div>
  </div>
</div>


<?php
$connect->close();
 ?>
