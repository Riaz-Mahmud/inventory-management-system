<?php require_once 'includes/header.php'; ?>

<?php

$sql = "SELECT product.product_id,product.brand_id,
 		product.categories_id, product.quantity,product.buyRate, product.rate, product.active, product.status,
 		brands.brand_name, categories.categories_name FROM product
		INNER JOIN brands ON product.brand_id = brands.brand_id
		INNER JOIN categories ON product.categories_id = categories.categories_id
		WHERE product.status = 1 AND product.active = 1";

$result = $connect->query($sql);

if($result->num_rows > 0) {
 $Total=0;
 $TotalBuyRate=0;
 while($row = $result->fetch_array()) {
   $Qun = $row[3];
   $sellRate = $row[5];
   $buyRate = $row[4];

   $TotalProductPrice = $Qun * $sellRate;
   $TotalBuyProductPrice = $Qun * $buyRate;

   $Total += $TotalProductPrice;
   $TotalBuyRate += $TotalBuyProductPrice;
 }
}
?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>
		  <li class="active">Product Report</li>
		</ol>
    <a href="php_action/exportExcel.php" class="btn btn-success" style="float: right; margin-top:4px;margin-right:5px;" title="Click to export">Export</a>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Product</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<table class="table" id="manageProductTable">
					<thead>
						<tr>
							<th style="width:10%; ">Photo</th>
							<th>Product Name</th>
							<th>Parts Number</th>
							<th>Buy Rate</th>
                            <th>Sell Rate</th>
							<th>Quantity</th>
							<th>Product Price</th>
							<th>Status</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->

				<div class="col-md-12">
							<table class="table" id="priceTable" style="margin-top:25px;">
								<thead>
									<tr></tr>
								</thead>
								<tbody>
									<tr>
										<th >Total Sell Price Quantity Left</th>
										<th style=" text-align: right;"><?php echo $Total ." BDT"; ?></th>
									</tr>
									<tr>
										<th >Total Buy Price Quantity Left</th>
										<th style=" text-align: right;"><?php echo $TotalBuyRate ." BDT"; ?></th>
									</tr>
							</tbody>
							</table>
				</div>


			</div> <!-- /panel-body -->
		</div> <!-- /panel -->
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->



<script src="custom/js/productReport.js"></script>

<?php require_once 'includes/footer.php'; ?>
