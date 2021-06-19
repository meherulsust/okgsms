<style type="text/css">

 @media print {
		.custom{
			background-color : gray;
		}
		.no-print{
			display : none !important;
		}
		.not-print{
			display : none !important;
		}		
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<div class="box box-primary">
			<div class="panel-heading">
				<i class="fa fa-table"></i><?php echo $page_title;?>
				<div class="box-tools pull-right">
				    <a class="ajax_link" href="#">
						<button class="btn btn-primary btn-xs print" type="button"><i class='fa fa-print'></i> Print</button>
					</a>
					<div class="box-tools pull-right">
						<a class="ajax_link" href="<?=$site_url . $link_action;?>">
						<button class="btn btn-primary btn-xs" type="button"><i class='fa fa-bars'></i>
							<?php echo $link_title; ?></button>
						</a>
					</div>
				</div>
			</div>
			<div class="panel-body" id="panel-body">
				<div class="row">
					<div class="col-lg-12">						
						<table class="table no-border custom">
							<tr>
								<td> 
								<img src="<?=(!empty($settings['logo'])) ? $upload_url.'logo/'.$settings['logo'] : $upload_url.'logo/'.'logo.png';?>"  width="120">
									<b><h4><?=$settings['name'] ?></h4></b><br/>
									<b><?=$settings['address1'] ?> </b><br/>
									
									<b><h4>Bill To       :</h4></b><br/>
									<b>Tuition fee Month :<?= $month. '-'.$year; ?> </b><br/>
									<b>Student Name      : <?= $full_name; ?> </b><br/>
									<b>Student ID        : <?= $id_no; ?> </b><br/>
									<b>Mobile            : <?= $mobile_no; ?> </b><br/>
									<b>Payment Status    : <?= $status; ?> </b>
									<br/>
								</td>
								<td align="right">
									<b><h2>Invoice</h2></b><hr/>
									<b>Invoice No. :</b> <?= $invoice_no; ?><br/>
									<b>Date :</b>   <?=$created_at; ?><br/>
									<b>Created By : </b> <?= $username; ?><br/><br/>
								</td>
							</tr>
						</table>	
						<table class="table table-striped table-bordered">
							<tr>
								<th align="center" width="2%">SL.</th>
								<th>Iteam Name</th>
								<th>Amount</th>
								
							</tr>
							<?php
							$i = 1;
							foreach ($details as $val) {
							?>
							<tr>			
								<td align="center"><?php echo $i; ?></td>
								<td align="right"><?php echo $val['head']; ?></td>
								<td align="right"><?php echo $val['amount']; ?></td>		
							</tr>
							<?php	
							$i++;
							}			
							?>
							<!-- <tr>			
								<td align="right" colspan="2"><b>Total :</b></td>
								<td align="right"><b><?php echo sprintf('%.2f',$total_amount); ?></b></td>						
							</tr> -->
							<tr>			
								<td align="right" colspan="2"><b>Invoice Total :</b></td>
								<td align="right" colspan="1"><b><?php echo sprintf('%.2f',$total_amount - $total_discount); ?></b></td>			
							</tr>
							<tr>			
								<td align="right" colspan="2"><b>Invoice Due :</b></td>
								<td align="right" colspan="1"><b><?php echo sprintf('%.2f',$total_due); ?></b></td>			
							</tr>	
						</table>
							<h4>Payment History</h4>	
							<span class="message"><?php echo isset($msg) ? $msg : ''; ?></span>	
							<?php if($status == 'Unpaid') : ?>
							<div class="not-print">
								<form id="ajax_form2" role="form" action="<?=$site_url;?>GenerateTuitionFee/view/<?= encode($id); ?>" method="post">
									<table class="table table-bordered">
										<tr>
											<td width="30%"><input class="form-control lg amount is_numeric" name="paid_amount" value="<?php echo sprintf('%.2f',$total_due); ?>"/></td>
											<td><span class="submitting"><button type="submit" class="btn btn-primary btn-sm add_payment">Add Payment</button></span></td>
										</tr>
									</table>
								</form>
							</div>
							<?php endif; ?>
							<table class="table table-striped table-bordered">
								<tr>
									<th align="center" width="2%">SL.</th>
									<th>Payment Date</th>
									<th>Paid Amount</th>				
								</tr>
								<?php
								$count = 1;
								foreach ($payment_list as $pay) {
								?>
								<tr>			
									<td align="center"><?php echo $count; ?></td>
									<td><?php echo $pay['created_at']; ?></td>
									<td align="right"><?php echo $pay['paid_amount']; ?></td>			
								</tr>
								<?php	
								$count++;
								}			
								?>		
							</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

	

<script>		
$(document).ready(function(){	
	$('.add_payment').click(function() {

		var msg = confirm('Are you sure want to confirm this payment!');
		if(msg==true){
			if($('.amount').val() <= 0) {
				alert("Please enter payment amount.");       
				return false;
			}else{
				$('.submitting').html('<span class="btn btn-primary btn-sm"><i class="fa fa-spinner fa-spin fa-lg fa-fw"></i> Submitting...</span>');
				form = $("#ajax_form2").serialize();
				var formURL = $("#ajax_form2").attr("action");
				$.ajax({
					type: "POST",
					url: formURL,
					data: form,
					success: function(data){
						$('.content').html(data);
					}
				});
				return false;
			}
		}else{
			return false;
		}
	});	
	
	var specialKeys = new Array();
    specialKeys.push(8,37,39,46);
		
	$(document).on("keypress",".is_numeric", function (e) {
		var keyCode = e.which ? e.which : e.keyCode
		var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
		return ret;
	});
	

	$(document).bind("paste",".is_numeric", function (e) {
		return false;
	});
	
	$(document).bind("drop",".is_numeric", function (e) {
		return false;
	});	

	$('.print').click(function() {
			
		printDiv = "#panel-body"; // id of the div you want to print
		$("*").addClass("no-print");
		$(printDiv+" *").removeClass("no-print");
		$(printDiv).removeClass("no-print");

		parent =  $(printDiv).parent();
		while($(parent).length)
		{
			$(parent).removeClass("no-print");
			parent =  $(parent).parent();
		}
		window.print();

	});	

});

</script>