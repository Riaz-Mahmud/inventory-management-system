<?php

require_once 'includes/header.php';
require_once 'php_action/core.php';


$sql = "SELECT * FROM purchase WHERE status=1 AND active_status=1";

$result = $connect->query($sql);

if($result->num_rows > 0) {
 $GrandTotal=0;
 $totalPaid=0;
 $totalDue=0;
 while($row = $result->fetch_array()) {
   $gTotal = $row['grand_total'];
   $pTotal = $row['paid'];
	 $dTotal = $row['due'];
   $GrandTotal += $gTotal;
	 $totalPaid += $pTotal;
	 $totalDue += $dTotal;
 }
}

?>

<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>
		  <li class="active">Purchases</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-plus"></i> Manage Purchases</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add New </button>
				</div> <!-- /div-action -->

				<table class="table" id="managePruchaseTable">
					<thead>
						<tr>
              <th>SL</th>
							<th>Date</th>
							<th>Company Name</th>
							<th>Total Amount</th>
							<th>Paid</th>
							<th>Due</th>
              <th>Status</th>
              <th style="width:15%;">Options</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->
				<div class="col-md-12">
							<table class="table" id="purchaseAmountDetailsTable" style="margin-top:25px;">
								<thead>
									<tr></tr>
								</thead>
								<tbody>
									<tr>
										<th >Grand Total</th>
										<th style=" text-align: right;"><?php echo $GrandTotal ." BDT"; ?></th>
									</tr>
									<tr>
										<th >Total Paid</th>
										<th style=" text-align: right;"><?php echo $totalPaid ." BDT"; ?></th>
									</tr>
									<tr>
										<th >Total Due</th>
										<th style=" text-align: right;"><?php echo $totalDue ." BDT"; ?></th>
									</tr>
							</tbody>
							</table>
				</div>
			</div> <!-- /panel-body -->
		</div> <!-- /panel -->
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitPurchaseForm" action="php_action/createPurchase.php" method="POST" enctype="multipart/form-data">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Purchases</h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-purchase-messages"></div>


	        <div class="form-group">
	        	<label for="productName" class="col-sm-3 control-label">Date: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" />
				    </div>
	        </div> <!-- /form-group-->

					<div class="form-group">
	        	<label for="companyName" class="col-sm-3 control-label">Company Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="companyName" placeholder="Company Name" name="companyName" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->

	        <div class="form-group">
	        	<label for="totalAmount" class="col-sm-3 control-label">Total: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" min="0" class="form-control" id="totalAmount" placeholder="Total" name="totalAmount" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->

	        <div class="form-group">
	        	<label for="paidAmount" class="col-sm-3 control-label">Paid: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" min="0" class="form-control" id="paidAmount" placeholder="Paid" name="paidAmount" autocomplete="off" onkeyup="AmountPaid()">
				    </div>
	        </div> <!-- /form-group-->

          <div class="form-group">
	        	<label for="dueAmount" class="col-sm-3 control-label">Due: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="dueAmount" placeholder="Due" name="dueAmount" autocomplete="off">
						</div>
	        </div> <!-- /form-group-->

	        <div class="form-group">
	        	<label for="purchaseStatus" class="col-sm-3 control-label">Status: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="purchaseStatus" name="purchaseStatus">
				      	<option value="1">Active</option>
				      	<option value="2">Deactivate</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->
	      </div> <!-- /modal-body -->

	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

	        <button type="submit" class="btn btn-primary" id="createPurchaseBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div> <!-- /modal-footer -->
     	</form> <!-- /.form -->
    </div> <!-- /modal-content -->
  </div> <!-- /modal-dailog -->
</div>
<!-- /add categories -->

<!-- edit brand -->
<div class="modal fade" id="editPurchaseModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="editPurchaseForm" action="php_action/editPurchase.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Purchases</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-purchase-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

					<div class="form-group">
	        	<label for="editDate" class="col-sm-3 control-label">Date: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="editDate" name="editDate" autocomplete="off" />
				    </div>
	        </div> <!-- /form-group-->
		      <div class="edit-brand-result">
		      	<div class="form-group">
		        	<label for="editCompanyName" class="col-sm-3 control-label">Company Name: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editCompanyName" placeholder="Company Name" name="editCompanyName" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->
						<div class="form-group">
		        	<label for="editTotal" class="col-sm-3 control-label">Total: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editTotal" placeholder="Total" name="editTotal" autocomplete="off" onkeyup="editPaidAmount()">
					    </div>
		        </div> <!-- /form-group-->
						<div class="form-group">
		        	<label for="editPaid" class="col-sm-3 control-label">Paid: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editPaid" placeholder="Paid" name="editPaid" autocomplete="off" onkeyup="editPaidAmount()">
					    </div>
		        </div> <!-- /form-group-->
						<div class="form-group">
		        	<label for="editDue" class="col-sm-3 control-label">Due: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editDue" placeholder="Due" name="editDue" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->
		        <div class="form-group">
		        	<label for="editPurchaseStatus" class="col-sm-3 control-label">Status: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <select class="form-control" id="editPurchaseStatus" name="editPurchaseStatus">
					      	<option value="1">Active</option>
					      	<option value="2">Deactivate</option>
					      </select>
					    </div>
		        </div> <!-- /form-group-->
		      </div>
		      <!-- /edit brand result -->

	      </div> <!-- /modal-body -->

	      <div class="modal-footer editBrandFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

	        <button type="submit" class="btn btn-success" id="editPurchaseBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->
<!-- /edit brand -->

<div class="modal fade" tabindex="-1" role="dialog" id="removePurchaseModalBtn">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Brand</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removePurchaseFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removePurchaseBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<script type="text/javascript">
$(function(){
	var totalAmount = $("#totalAmount").val();

	if(totalAmount) {
		var dueAmount = Number($("#totalAmount").val()) - Number($("#paidAmount").val());
		dueAmount = dueAmount.toFixed(2);
		$("#dueAmount").val(dueAmount);
		$("#dueValue").val(dueAmount);
});
</script>

<script src="custom/js/purchases.js"></script>
<?php require_once 'includes/footer.php'; ?>
