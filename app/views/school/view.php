<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-list-alt"></i><h3 class="box-title">School Details</h3>
	</div>	
	<table class="form_table">
		<tr>
			<td width="1%">School Name :</td>
			<td>
				<?php echo $name; ?>
			</td>
		</tr>
		<tr>
			<td>Logo :</td>
			<td><img src="<?=(!empty($logo)) ? $upload_url.'logo/'.$logo : $upload_url.'logo/'.'logo.png';?>"  width="120"></td>
    	</tr>
		<tr>
			<td>Establish Date :</td>
			<td>
				<?php echo $establish_date; ?>
			</td>
		</tr>		
		<tr>
			<td>Address :</td>
			<td>
				<?php echo $address1; ?>
			</td>
		</tr>
		<tr>
			<td>Another Address :</td>
			<td>
				<?php echo $address2; ?>
			</td>
		</tr>
		<tr>
			<td>Description :</td>
			<td>
				<?php echo $description; ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<a href="<?= $site_url.$active_controller; ?>"><span class="btn btn-sm btn-primary">Back</span></a>
			</td>
		</tr>	
	</table>	
</div>



