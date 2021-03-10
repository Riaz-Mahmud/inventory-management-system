var managePruchaseTable;

$(function(){
	$("#orderDate").datepicker();
});

$(document).ready(function() {
	// top nav bar
	$('#navPurchase').addClass('active');
	// order date picker
	$("#orderDate").datepicker();

	// manage purchases data table
  managePruchaseTable = $('#managePruchaseTable').DataTable({
    'ajax': 'php_action/fetchPurchase.php',
    'order': []
  });

	//Submit Purchases from function
	// submit brand form function
	$("#submitPurchaseForm").unbind('submit').bind('submit', function() {
		var form = $(this);
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		var orderDate = $("#orderDate").val();
		var companyName = $("#companyName").val();
		var totalAmount = $("#totalAmount").val();
		var paidAmount = $("#paidAmount").val();
		var dueAmount = $("#dueAmount").val();
		var purchaseStatus = $("#purchaseStatus").val();

		// if(orderDate == "") {
		// 	$("#orderDate").after('<p class="text-danger"> Date field is required</p>');
		// 	$('#orderDate').closest('.form-group').addClass('has-error');
		// } else {
		// 	// remov error text field
		// 	$("#orderDate").find('.text-danger').remove();
		// 	// success out for form
		// 	$("#orderDate").closest('.form-group').addClass('has-success');
		// }

		if(companyName == "") {
			$("#companyName").after('<p class="text-danger">Company Name field is required</p>');

			$('#companyName').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#companyName").find('.text-danger').remove();
			// success out for form
			$("#companyName").closest('.form-group').addClass('has-success');
		}

		if(totalAmount == "") {
			$("#totalAmount").after('<p class="text-danger">Total Amount field is required</p>');

			$('#totalAmount').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#totalAmount").find('.text-danger').remove();
			// success out for form
			$("#totalAmount").closest('.form-group').addClass('has-success');
		}

		if(paidAmount == "") {
			$("#paidAmount").after('<p class="text-danger">Field is required</p>');

			$('#paidAmount').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#paidAmount").find('.text-danger').remove();
			// success out for form
			$("#paidAmount").closest('.form-group').addClass('has-success');
		}

		if(dueAmount == "") {
			$("#dueAmount").after('<p class="text-danger">Field is required</p>');

			$('#dueAmount').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#dueAmount").find('.text-danger').remove();
			// success out for form
			$("#dueAmount").closest('.form-group').addClass('has-success');
		}

		if(purchaseStatus == "") {
			$("#purchaseStatus").after('<p class="text-danger">Field is required</p>');

			$('#purchaseStatus').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#purchaseStatus").find('.text-danger').remove();
			// success out for form
			$("#purchaseStatus").closest('.form-group').addClass('has-success');
		}

		if(companyName && totalAmount && paidAmount && dueAmount && purchaseStatus) {
			var form = $(this);
			// button loading
			$("#createPurchaseBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createPurchaseBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table
						managePruchaseTable.ajax.reload(null, false);

  	  			// reset the form text
						$("#submitPurchaseForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');

  	  			$('#add-purchase-messages').html('<div class="alert alert-success">'+
            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          '</div>');

  	  			$(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}  // if
					else if(response.success == false){
  	  			$('#add-purchase-messages').html('<div class="alert alert-danger">'+
            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          '</div>');

  	  			$(".alert-danger").delay(600).show(10, function() {
							$(this).delay(4000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}

				} // /success
			}); // /ajax
		} // if

		return false;
	}); // /submit brand form function

}); // document.ready fucntion

function editPurchase(purchaseId = null) {
	if(purchaseId) {
		// remove hidden brand id text
		$('#purchaseId').remove();

		$("#editDate").datepicker();
		// remove the error
		$('.text-danger').remove();
		// remove the form-error
		$('.form-group').removeClass('has-error').removeClass('has-success');

		// modal loading
		$('.modal-loading').removeClass('div-hide');
		// modal result
		$('.edit-brand-result').addClass('div-hide');
		// modal footer
		$('.editBrandFooter').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedPurchase.php',
			type: 'post',
			data: {purchaseId : purchaseId},
			dataType: 'json',
			success:function(response) {
				// modal loading
				$('.modal-loading').addClass('div-hide');
				// modal result
				$('.edit-brand-result').removeClass('div-hide');
				// modal footer
				$('.editBrandFooter').removeClass('div-hide');

				$('#editDate').val(response.buy_date);
				// setting the brand name value
				$('#editCompanyName').val(response.shopname);
				// setting the brand Description value
				$('#editTotal').val(response.grand_total);

				$('#editPaid').val(response.paid);
				$('#editDue').val(response.due);
				// setting the brand status value
				$('#editPurchaseStatus').val(response.status);
				// brand id
				$(".editBrandFooter").after('<input type="hidden" name="purchaseId" id="purchaseId" value="'+response.id+'" />');

				// update brand form
				$('#editPurchaseForm').unbind('submit').bind('submit', function() {

					// remove the error text
					$(".text-danger").remove();
					// remove the form error
					$('.form-group').removeClass('has-error').removeClass('has-success');

					var editDate = $("#editDate").val();
					var editCompanyName = $("#editCompanyName").val();
					var editTotal = $("#editTotal").val();
					var editPaid = $("#editPaid").val();
					var editDue = $("#editDue").val();
					var editPurchaseStatus = $("#editPurchaseStatus").val();

					if(editDate == "") {
						$("#editDate").after('<p class="text-danger">Brand Name field is required</p>');
						$('#editDate').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editDate").find('.text-danger').remove();
						// success out for form
						$("#editDate").closest('.form-group').addClass('has-success');
					}

					if(editCompanyName == "") {
						$("#editCompanyName").after('<p class="text-danger">Company Name field is required</p>');

						$('#editCompanyName').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editCompanyName").find('.text-danger').remove();
						// success out for form
						$("#editCompanyName").closest('.form-group').addClass('has-success');
					}

					if(editTotal == "") {
						$("#editTotal").after('<p class="text-danger">Total Amount field is required</p>');

						$('#editTotal').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editTotal").find('.text-danger').remove();
						// success out for form
						$("#editTotal").closest('.form-group').addClass('has-success');
					}

					if(editPaid == "") {
						$("#editPaid").after('<p class="text-danger">Field is required</p>');

						$('#editPaid').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editPaid").find('.text-danger').remove();
						// success out for form
						$("#editPaid").closest('.form-group').addClass('has-success');
					}

					if(editDue == "") {
						$("#editDue").after('<p class="text-danger">Field is required</p>');

						$('#editDue').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editDue").find('.text-danger').remove();
						// success out for form
						$("#editDue").closest('.form-group').addClass('has-success');
					}

					if(editPurchaseStatus == "") {
						$("#editPurchaseStatus").after('<p class="text-danger">Field is required</p>');

						$('#editPurchaseStatus').closest('.form-group').addClass('has-error');
					} else {
						// remov error text field
						$("#editPurchaseStatus").find('.text-danger').remove();
						// success out for form
						$("#editPurchaseStatus").closest('.form-group').addClass('has-success');
					}

					if(editDate && editCompanyName && editTotal && paidAmount && editDue && editPurchaseStatus) {
						var form = $(this);

						// submit btn
						$('#editPurchaseBtn').button('loading');

						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {

								if(response.success == true) {
									console.log(response);
									// submit btn
									$('#editPurchaseBtn').button('reset');

									// reload the manage member table
									managePruchaseTable.ajax.reload(null, false);
									// remove the error text
									$(".text-danger").remove();
									// remove the form error
									$('.form-group').removeClass('has-error').removeClass('has-success');

			  	  			$('#edit-purchase-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
								} // /if

							}// /success
						});	 // /ajax
					} // /if

					return false;
				}); // /update brand form

			} // /success
		}); // ajax function

	} else {
		alert('error!! Refresh the page again');
	}
} // /edit brands function

function removePurchase(purchaseId = null) {
	if(purchaseId) {
		$('#removePurchaseId').remove();
		$.ajax({
			url: 'php_action/fetchSelectedPurchase.php',
			type: 'post',
			data: {purchaseId : purchaseId},
			dataType: 'json',
			success:function(response) {
				$('.removePurchaseFooter').after('<input type="hidden" name="removePurchaseId" id="removePurchaseId" value="'+response.id+'" /> ');

				// click on remove button to remove the brand
				$("#removePurchaseBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removePurchaseBtn").button('loading');

					$.ajax({
						url: 'php_action/removePurchase.php',
						type: 'post',
						data: {purchaseId : purchaseId},
						dataType: 'json',
						success:function(response) {
							console.log(response);
							// button loading
							$("#removePurchaseBtn").button('reset');
							if(response.success == true) {

								// hide the remove modal
								$('#removePurchaseModalBtn').modal('hide');

								// reload the brand table
								managePruchaseTable.ajax.reload(null, false);

								$('.remove-messages').html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

			  	  			$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert
							} else {

							} // /else
						} // /response messages
					}); // /ajax function to remove the brand

				}); // /click on remove button to remove the brand

			} // /success
		}); // /ajax

		$('.removePurchaseFooter').after();
	} else {
		alert('error!! Refresh the page again');
	}
} // /remove brands function

function AmountPaid() {
	var total = $("#totalAmount").val();

	if(total) {
		var due = Number($("#totalAmount").val()) - Number($("#paidAmount").val());
		due = due.toFixed(2);
		$("#dueAmount").val(due);
	} // /if
} // /paid amoutn function

function editPaidAmount() {
	var total = $("#editTotal").val();

	if(total) {
		var due = Number($("#editTotal").val()) - Number($("#editPaid").val());
		due = due.toFixed(2);
		$("#editDue").val(due);
	} // /if
} // /paid amoutn function
