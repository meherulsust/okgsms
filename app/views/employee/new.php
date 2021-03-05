<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-pencil-square-o"></i><h3 class="box-title"><?php echo $page_title; ?></h3>
	</div>	
	<form class="ajax_submit" role="form" action="<?=$site_url.$active_controller?>/add" method="post" enctype="multipart/form-data">
		<table class="form_table">
			<tr>
				<td>Category :</td>
				<td>
					<select name='category_id' class='form-control' id="category_id" required>
						<option value="" >---- Select Category ----</option>
						<?php echo html_options($category_options,set_value('category_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('category_id'); ?> </span>
				</td>
			</tr>
			<tr>
				<td>Name :</td>
				<td>
					<input name="name" type="text" class="form-control" value="<?=set_value('name'); ?>" required />
					<span class='error'>* <?php echo form_error('name'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Username :</td>
				<td>
					<input name="username" type="text" class="form-control" value="<?=set_value('username'); ?>"  required/>
					<span class='error'>* <?php echo form_error('username'); ?></span>
				</td>
			</tr>
			
			<tr>
				<td>Password :</td>
				<td>
					<input name="passwd" type="password" class="form-control" value="<?=set_value('passwd'); ?>"/>
				</td>
			</tr>
					
			<tr>
				<td>Designation:</td>
				<td>
					<input name="designation" type="text" class="form-control" value="<?=set_value('designation'); ?>" required />
					<span class='error'>* <?php echo form_error('designation'); ?></span>
					
				</td>
			</tr>
			<tr class="relevant_subject">
				<td>Relevant Subject :</td>
				<td>
					<input name="relevant_subject" id="relevant_subject" type="text" class="form-control" value="<?=set_value('relevant_subject'); ?>" />
				</td>
			</tr>
			<tr>
				<td>Date of Birth :</td>
				<td>
					<input type="text" class="form-control calander"  name="dob" value="<?=set_value('dob'); ?>" required />
					<span class="add-on"><span class="glyphicon glyphicon-calendar"></span>
					<span class="error">* <?php echo form_error('dob'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Gender :</td>
				<td>
					<select name='gender' class='form-control' required>
					<option value="" >---- Select Gender ----</option>
					<?php echo html_options($gender_options,set_value('gender'));  ?>
					</select>
					<span class='error'>* <?php echo form_error('gender'); ?> </span>
				</td>
			</tr>
			<tr>
				<td>Blood group :</td>
				<td>
					<select name='blood_group_id' class='form-control' required>
					<option value="" >---- Select Blood group ----</option>
					<?php echo html_options($blood_group_options,set_value('blood_group_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('blood_group_id'); ?> </span>
				</td>
			</tr>
			
			<tr>
				<td>Religion :</td>
				<td>
					<select name='religion_id' class='form-control' required>
					<option value="" >---- Select Religion ----</option>
					<?php echo html_options($religion_options,set_value('religion_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('religion_id'); ?> </span>
				</td>
			</tr>
			
			<tr>
				<td>Email :</td>
				<td>
					<input name="email" type="text" class="form-control" value="<?=set_value('email'); ?>" required />     
					<span class='error'>* <?php echo form_error('email'); ?></span>   					
				</td>
			</tr>	
			<tr>
				<td>Mobile No. :</td>
				<td>
					<input name="mobile_no" type="text" class="form-control" value="<?=set_value('mobile_no'); ?>" required>
					<span class='error'>* <?php echo form_error('mobile_no'); ?></span>					
				</td>
			</tr>
			<tr>
				<td>Address :</td>
				<td>
					<textarea name="address" class="form-control" required><?php echo set_value('address'); ?> </textarea>
					<span class='error'>* <?php echo form_error('address'); ?></span>
				</td>
			</tr>
			<tr>				
				<td>Teacher Picture :</td>
				<td>
					<input name="photo" type="file" class='form-control'/> [Size (300 X 300)]
					<span class='error'></span> <?php if(!empty($upload_error)) echo $upload_error; ?>
				</td>
			</tr>
			<tr>				
				<td>Uplaod CV :</td>
				<td>
					<input name="cv_upload" type="file" class='form-control'/> [Size (3M)]
					<span class='error'></span> <?php if(!empty($upload_error)) echo $upload_error; ?>
				</td>
			</tr>
			<tr>
				<td>Joining  Date :</td>
				<td>
					<input type="text" class="form-control calander"  name="join_date" value="<?=set_value('join_date'); ?>" required />
					<span class="add-on"><span class="glyphicon glyphicon-calendar"></span>
					<span class="error">* <?php echo form_error('join_date'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Order. :</td>
				<td>
					<input name="serial" type="text" class="form-control" value="<?=set_value('serial'); ?>" required>
					<span class='error'>* <?php echo form_error('serial'); ?></span>					
				</td>
			</tr>
			<tr>
				<td>Status :</td>
				<td>
					<select name='status' class='form-control' required>
					<option value="" >---- Select Status ----</option>
					<?php echo html_options($status_options,set_value('status')); ?>
					</select>
					<span class='error'>* <?php echo form_error('status'); ?> </span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					 <button type="submit" class="btn btn-sm btn-primary">Submit</button>
					 <button type="reset" class="btn btn-sm btn-danger">Reset</button>
				</td>
			</tr>
		</table>			
	</form>
</div>

<script>
$(document).ready(function(){
	$('.relevant_subject').hide();
	$('#category_id').change(function(){
		if($('#category_id').val() == '2') {
			 $('.relevant_subject').hide();
		}else{
			 $('.relevant_subject').show();
		}
	}); 
	
	$('.calander').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});	
}); 
</script>