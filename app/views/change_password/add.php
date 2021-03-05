<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-pencil-square-o"></i><h3 class="box-title">Update Password</h3>
		<span class="delete_message"><?php echo $this->session->flashdata('message'); ?></span>	
	</div>	
	<form class="ajax_submit" role="form" action="<?=$site_url.$active_controller;?>" method="post">
		<table class="form_table">
			<tr>
				<td>Old Password :</td>
				<td>
					<input name="old_password" type="password" class="form-control" value="<?=set_value('old_password'); ?>" />
					<span class='error'>* <?php echo form_error('old_password'); ?></span>
				</td>
			</tr>
			<tr>
				<td>New Password :</td>
				<td>
					<input name="password" type="password" class="form-control" value="<?=set_value('password'); ?>" />
					<span class='error'>* <?php echo form_error('password'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Confirm Password :</td>
				<td>
					<input name="confirm_password" type="password" class="form-control" value="<?=set_value('confirm_password'); ?>" />
					<span class='error'>* <?php echo form_error('confirm_password'); ?></span>
				</td>
			</tr>	
			<tr>
				<td></td>
				<td>
					 <button type="submit" class="btn btn-sm btn-primary">Update</button>
					 <button type="reset" class="btn btn-sm btn-info">Reset</button>
				</td>
			</tr>
		</table>			
	</form>
</div>	
