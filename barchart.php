<?php require_once 'includes/header.php'; ?>
<?php

$firstMonth = 0;
$secondMonth = 0;
$thirdMonth = 0;
$fourthMonth = 0;
$fiveMonth = 0;
$sixMonth = 0;
$sevenMonth = 0;
$eightMonth = 0;
$nineMonth = 0;
$tenMonth = 0;
$elevaneMonth = 0;
$twelbeMonth = 0;
for ($i=1; $i <13 ; $i++) {
	$barchartSql = "SELECT * FROM orders WHERE order_month='$i' AND order_year=2021 AND order_status = 1";
	$barchartQuery = $connect->query($barchartSql);
	$barchartOrder = $barchartQuery->num_rows;
	$barcharRevenue=0;
	while ($barchartResult = $barchartQuery->fetch_assoc()) {
		$barcharRevenue += $barchartResult['paid'];
		if ($i==1) {
			$firstMonth += $barchartResult['paid'];;
		}elseif ($i==2) {
			$secondMonth += $barchartResult['paid'];;
		}elseif ($i==3) {
			$thirdMonth += $barchartResult['paid'];;
		}elseif ($i==4) {
			$fourthMonth += $barchartResult['paid'];;
		}elseif ($i==5) {
			$fiveMonth += $barchartResult['paid'];;
		}elseif ($i==6) {
			$sixMonth += $barchartResult['paid'];;
		}elseif ($i==7) {
			$sevenMonth += $barchartResult['paid'];;
		}elseif ($i==8) {
			$eightMonth += $barchartResult['paid'];;
		}elseif ($i==9) {
			$nineMonth += $barchartResult['paid'];;
		}elseif ($i==10) {
			$tenMonth += $barchartResult['paid'];;
		}elseif ($i==11) {
			$elevaneMonth += $barchartResult['paid'];;
		}elseif ($i==12) {
			$twelbeMonth += $barchartResult['paid'];;
		}
	}
}


$dataPoints = array(
	array("y" => $firstMonth, "label" 	=> "January" ),
	array("y" => $secondMonth, "label" => "Febuary" ),
	array("y" => $thirdMonth, "label" => "March" ),
	array("y" => $fourthMonth, "label" => "April" ),
	array("y" => $fiveMonth, "label" => "May" ),
	array("y" => $sixMonth, "label" => "June" ),
	array("y" => $sevenMonth, "label" => "July" ),
	array("y" => $eightMonth, "label" => "August" ),
	array("y" => $nineMonth, "label" 		=> "September" ),
	array("y" => $tenMonth, "label" => "Octobar" ),
	array("y" => $elevaneMonth, "label" => "November" ),
	array("y" => $twelbeMonth, "label" => "December" )
);

$GetOrderDate = "2021-10-01";
$timestamp = strtotime($GetOrderDate);
$getMonth = date("Y", $timestamp);
echo $getMonth;
?>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Total Sell- Report"
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
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php require_once 'includes/footer.php'; ?>
