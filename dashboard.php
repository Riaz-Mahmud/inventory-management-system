<?php require_once 'includes/header.php';

date_default_timezone_set('Asia/Dhaka');
$Todaydate = date('Y-m-d');
$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = 0;
$totalDUE=0;
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
	$totalDUE += $orderResult['due'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 2 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;



$todayPaidSql = "SELECT paid,due FROM orders WHERE order_date = '$Todaydate' AND order_status = 1";
$todayPaidQuery = $connect->query($todayPaidSql);
$todayPaidcountOrder = $todayPaidQuery->num_rows;
$totalTodayPAID=0;
$totalTodayDUE=0;
while ($todayPaidResult = $todayPaidQuery->fetch_assoc()) {
	$totalTodayPAID += $todayPaidResult['paid'];
	$totalTodayDUE += $todayPaidResult['due'];
}

$thisMonthSql = "SELECT * FROM orders WHERE MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE()) AND order_status = 1";
$thisMonthQuery = $connect->query($thisMonthSql);
$thisMonthcountOrder = $thisMonthQuery->num_rows;
$thisMonthPAID=0;
while ($thisMonthResult = $thisMonthQuery->fetch_assoc()) {
	$thisMonthPAID += $thisMonthResult['paid'];
}

$January = 0;
$February = 0;
$March = 0;
$April = 0;
$May = 0;
$June = 0;
$July = 0;
$August = 0;
$September = 0;
$October = 0;
$November = 0;
$December = 0;
for ($i=1; $i <13 ; $i++) {
	$barchartSql = "SELECT * FROM orders WHERE order_month='$i' AND order_year=2021 AND order_status = 1";
	$barchartQuery = $connect->query($barchartSql);
	$barchartOrder = $barchartQuery->num_rows;
	$barcharRevenue=0;
	while ($barchartResult = $barchartQuery->fetch_assoc()) {
		$barcharRevenue += $barchartResult['paid'];
		if ($i==1) {
			$January += $barchartResult['paid'];;
		}elseif ($i==2) {
			$February += $barchartResult['paid'];;
		}elseif ($i==3) {
			$March += $barchartResult['paid'];;
		}elseif ($i==4) {
			$April += $barchartResult['paid'];;
		}elseif ($i==5) {
			$May += $barchartResult['paid'];;
		}elseif ($i==6) {
			$June += $barchartResult['paid'];;
		}elseif ($i==7) {
			$July += $barchartResult['paid'];;
		}elseif ($i==8) {
			$August += $barchartResult['paid'];;
		}elseif ($i==9) {
			$September += $barchartResult['paid'];;
		}elseif ($i==10) {
			$October += $barchartResult['paid'];;
		}elseif ($i==11) {
			$November += $barchartResult['paid'];;
		}elseif ($i==12) {
			$December += $barchartResult['paid'];;
		}
	}
}


$dataPoints = array(
	array("y" => $January, "label" 	=> "January" ),
	array("y" => $February, "label" => "February" ),
	array("y" => $March, "label" => "March" ),
	array("y" => $April, "label" => "April" ),
	array("y" => $May, "label" => "May" ),
	array("y" => $June, "label" => "June" ),
	array("y" => $July, "label" => "July" ),
	array("y" => $August, "label" => "August" ),
	array("y" => $September, "label" 		=> "September" ),
	array("y" => $October, "label" => "October" ),
	array("y" => $November, "label" => "November" ),
	array("y" => $December, "label" => "December" )
);
//$connect->close();
?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">

<div class="row">
	<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">

				<a href="product.php" style="text-decoration:none;color:black;">
					Total Product
					<span class="badge pull pull-right"><?php echo $countProduct; ?></span>
				</a>

			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<a href="product.php" style="text-decoration:none;color:black;">
					Low Stock
					<span class="badge pull pull-right"><?php echo $countLowStock; ?></span>
				</a>

			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->



		<div class="col-md-4">
			<div class="panel panel-info">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Total Orders
					<span class="badge pull pull-right"><?php echo $countOrder; ?></span>
				</a>

			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->
<?php } ?>
<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
		<div class="col-md-4">
			<div class="card">
				<div class="cardHeader">
					<h1><?php echo date('d'); ?></h1>
				</div>

				<div class="cardContainer">
					<p><?php echo date('l') .' '.date('d').'-'.date('m').'-'.date('Y'); ?></p>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<div class="cardHeader" style="background-color:#3498DB;">
					<h1><?php if($totalTodayPAID) {
						echo $totalTodayPAID;
						} else {
							echo '0';
							} ?></h1>
				</div>

				<div class="cardContainer">
					<p> Today Total Sell</p>
				</div>
			</div>
		</div> <!--/col-md-4-->

		<div class="col-md-4">
			<div class="card">
			  <div class="cardHeader" style="background-color:#F1C40F;">
			    <h1><?php if($totalTodayDUE) {
			    	echo $totalTodayDUE;
			    	} else {
			    		echo '0';
			    		} ?></h1>
			  </div>

			  <div class="cardContainer">
			    <p> Today Total Due</p>
			  </div>
			</div>
		</div> <!--/col-md-4-->

		<div class="col-md-4">
			<div class="card">
			  <div class="cardHeader" style="background-color:#117864;margin-top:20px">
			    <h1><?php if($thisMonthPAID) {
			    	echo $thisMonthPAID;
			    	} else {
			    		echo '0';
			    		} ?></h1>
			  </div>

			  <div class="cardContainer" >
			    <p> Total Sell of This Month</p>
			  </div>
			</div>
		</div> <!--/col-md-4-->
		<div class="col-md-4">
			<div class="card" >
				<div class="cardHeader" style="background-color:#D35400;margin-top:20px">
					<h1><?php if($totalDUE) {
						echo $totalDUE;
						} else {
							echo '0';
							} ?></h1>
				</div>

				<div class="cardContainer" >
					<p> BDT Total DUE</p>
				</div>
			</div>
		</div> <!--/col-md-4-->
		<div class="col-md-4">
			<div class="card"	>
				<div class="cardHeader" style="background-color:#21618C;margin-top:20px">
					<h1><?php if($totalRevenue) {
						echo $totalRevenue;
						} else {
							echo '0';
							} ?></h1>
				</div>

				<div class="cardContainer" >
					<p> BDT Total Revenue</p>
				</div>
			</div>
		</div> <!--/col-md-4-->
	<?php } ?>

<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==2) { ?>

	<div class="col-md-4">

		<div class="panel panel-danger">
			<div class="panel-heading">
				<a style="text-decoration:none;color:black;">
					Low Stock
					<span class="badge pull pull-right"><?php echo $countLowStock; ?></span>
				</a>

			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->

		<div class="panel panel-info">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Total Orders
					<span class="badge pull pull-right"><?php echo $countOrder; ?></span>
				</a>

			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->

	</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="card">
				<div class="cardHeader">
					<h1><?php echo date('d'); ?></h1>
				</div>

				<div class="cardContainer">
					<p><?php echo date('l') .' '.date('d').'-'.date('m').'-'.date('Y'); ?></p>
				</div>
			</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="cardHeader" style="background-color:#3498DB; ">
				<h1><?php if($totalTodayPAID) {
					echo $totalTodayPAID;
					} else {
						echo '0';
						} ?></h1>
			</div>

			<div class="cardContainer">
				<p> Today Total Sell</p>
			</div>
	</div>
	</div>

	<div class="col-md-4">
			<div class="card">
				<div class="cardHeader" style="background-color:#F1C40F; margin-top:20px">
					<h1><?php if($totalTodayDUE) {
						echo $totalTodayDUE;
						} else {
							echo '0';
							} ?></h1>
				</div>

				<div class="cardContainer">
					<p> Today Total Due</p>
				</div>
			</div>
		</div>

		<div class="col-md-4">
				<div class="card">
				  <div class="cardHeader" style="background-color:#117864;margin-top:20px">
				    <h1><?php if($thisMonthPAID) {
				    	echo $thisMonthPAID;
				    	} else {
				    		echo '0';
				    		} ?></h1>
				  </div>

				  <div class="cardContainer">
				    <p> Total Sell of This Month</p>
				  </div>
				</div>
		</div>

		<div class="col-md-4">
				<div class="card" style="margin-bottom:20px;">
				  <div class="cardHeader" style="background-color:#D35400;margin-top:20px">
				    <h1><?php if($totalDUE) {
				    	echo $totalDUE;
				    	} else {
				    		echo '0';
				    		} ?></h1>
				  </div>

				  <div class="cardContainer" >
				    <p> BDT Total DUE</p>
				  </div>
				</div>
			</div>

			<div class="col-md-6">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <i class="glyphicon glyphicon-list-alt"></i> Low Stock
						<h6 alt="Paris" class="pull-right" style="margin-right: auto;">Last 15 Item</h6>
			    </div>
			    <div class="panel-body">
			      <table class="table" id="productTable">
			        <thead>
			          <tr>
			            <th style="width:30%;">Name</th>
			            <th style="width:30%;">Parts Number</th>
									<th style="width:10%;">Quantity</th>
									<th style="width:10%;">Price</th>
			          </tr>
			        </thead>
			        <tbody>
			        <?php
			        $userwisesql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1 ORDER BY product_id DESC Limit 15";
			        $userwiseQuery = $connect->query($userwisesql);
			        $userwieseOrder = $userwiseQuery->num_rows;
			        while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
			          <tr>
			            <td><?php echo $orderResult['product_name']?></td>
			            <td><?php echo $orderResult['part_number']?></td>
									<td><?php echo $orderResult['quantity']?></td>
									<td><?php echo $orderResult['rate']?></td>
			          </tr>
			        <?php } ?>
			      </tbody>
			      </table>
			    </div>
			  </div>
			</div>

<?php } ?>


	<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
	<div class="col-md-12" style="margin-top:20px">
		<div class="panel panel-default">
			<div class="panel-heading">
	      <i class="glyphicon glyphicon-stats"></i> Total Sell- Report 2021
	    </div>

			<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		</div>
	</div>

	<div id="link_wrapper">

	</div>

	<?php  } ?>
</div> <!--/row-->



<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>

<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');
    });
</script>

<!-- Live data change -->
<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("link_wrapper").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "php_action/liveData.php", true);
  xhttp.send();
}
setInterval(function(){
	loadXMLDoc();
},1000);

window.onload= loadXMLDoc;
</script>


<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light3",
	title:{
		text: ""
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## BDT",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

}
</script>
<script src="http://localhost/inventory-management-system/assests/script/canvasjs.min.js"></script>



<?php require_once 'includes/footer.php'; ?>
