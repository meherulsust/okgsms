<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-pencil-square-o"></i><h3 class="box-title"><?php echo $page_title; ?></h3>
		<div class="box-tools pull-right">
			<a class="ajax_link" href="<?=$site_url . $link_action;?>">
			<button class="btn btn-primary btn-xs" type="button"><i class='fa fa-bars'></i>
				<?php echo $link_title; ?></button>
			</a>
        </div>
	</div>	
	<form class="ajax_submit" role="form" action="<?=$site_url.$active_controller?>/add" method="post" enctype="multipart/form-data">
		<table class="form_table">
			<tr>
				<td>Student Type :</td>
				<td>
					<select name='student_type_id' class='form-control' id="student_type_id" required>
						<option value="" >---- Select Student Type ----</option>
						<?php echo html_options($student_type_options,set_value('student_type_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('student_type_id'); ?> </span>
				</td>
			</tr>
			<tr>
				<td>Name :</td>
				<td>
					<input name="name" type="text" class="form-control" value="<?=set_value('name'); ?>" autocomplete="off" />
					<span class='error'>* <?php echo form_error('name'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Class :</td>
				<td>
					<select name='class_id' class='form-control' id="class_id" required>
						<option value="" >---- Select class ----</option>
						<?php echo html_options($class_options,set_value('class_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('class_id'); ?> </span>
				</td>
				<input type="hidden" name="class_code" id="class_code" />
			</tr>
			<tr>
				<td>Form:</td>
				<td>
					<select name='section_id' class='form-control' id="section_id" required>
						<option value="" >---- Select Form ----</option>
						<?php echo html_options($section_options,set_value('section_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('section_id'); ?> </span>
				</td>
			</tr>
			
			<tr>
				<td>Student ID :</td>
				<td>
					<input name="id_no" type="text" id="id_no" class="form-control" value="<?=set_value('id_no'); ?>" readonly/>
				</td>
			</tr>
			<tr>
				<td>Admission Roll :</td>
				<td>
					<input name="admission_roll" type="text" id="admission_roll" class="form-control" value="<?=set_value('admission_roll'); ?>" readonly/>
				</td>
			</tr>
			<tr class="teaching_staff">
				<td>Group :</td>
				<td>
				<select class="form-control" name="id_admin_group" id ="id_admin_group">
					<option value="">---- Select Group ----</option>
					<?php echo html_options($admin_group_options, set_value('id_admin_group')); ?>
				</select>
				<span class='error'>* <?php echo form_error('id_admin_group'); ?></span>
				</td>
			</tr>
					
			<tr>
				<td>Designation:</td>
				<td>
					<input name="designation" type="text" class="form-control" value="<?=set_value('designation'); ?>" required />
					<span class='error'>* <?php echo form_error('designation'); ?></span>
					
				</td>
			</tr>
			<tr class="teaching_staff">
				<td>Relevant Subject :</td>
				<td>
					<input name="relevant_subject" id="relevant_subject" type="text" class="form-control" value="<?=set_value('relevant_subject'); ?>" />
				</td>
			</tr>
			<tr>
				<td>Date of Birth :</td>
				<td>
					<input type="text" class="form-control calander"  name="dob" value="<?=set_value('dob'); ?>" required  autocomplete="off"/>
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
			
			<tr class="teaching_staff">
				<td>Email :</td>
				<td>
					<input name="email" type="text" class="form-control" value="<?=set_value('email'); ?>" />     
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
				<td>Employee Picture :</td>
				<td>
					<input name="photo" type="file" class='form-control'/> [Size (300 X 300)]
					<span class='error'> <?=(isset($error_photo))? $error_photo :''; ?></span>
				</td>
			</tr>
			<tr>				
				<td>Uplaod CV :</td>
				<td>
					<input name="cv" type="file" class='form-control'/> [Max Size (3M)]
					<span class='error'> <?=(isset($error_cv))? $error_cv :''; ?></span>
				</td>
			</tr>
			<tr>
				<td>Joining  Date :</td>
				<td>
					<input type="text" class="form-control calander"  name="join_date" value="<?=set_value('join_date'); ?>" required autocomplete="off"/>
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
    $(document).ready(function () {
      $('#class_id').selectChain({
          target: $('#section_id'),
          value: 'title',
          url: '<?php echo site_url(); ?>student/get_section',
          type: 'post',
          data: {'class_id': 'class_id'}
      });
	 
	  $("#class_id").change(function() {				
			var classID = $(this).val();
			var currentDate = new Date();
  			var currentYear = currentDate.getFullYear();
			var defaultRoll   = '001';

			$.ajax({
				type: "POST",
				url: '<?php echo $site_url;?>student/class_details',
				data: 'class_id='+classID,
				cache: false, 
				success: function(response){
					var obj  = jQuery.parseJSON(response);
					$('#class_code').val(obj.code);
					}
			});   
		
			$.ajax({
				type: "POST",
				url: '<?php echo $site_url;?>student/student_details',
				data: 'class_id='+classID,
				cache: false, 
				success: function(response){
				
					var obj = jQuery.parseJSON(response);
					
					
					if(obj == "")
					{
						var defaultCode   	     = $('#class_code').val();
						var defaultStudentID 	 = currentYear + defaultCode + defaultRoll;
						var defaultAdmissionRoll = defaultCode + defaultRoll;
						
						$('#id_no').val(defaultStudentID);	
						$('#admission_roll').val(defaultAdmissionRoll);	
					}else{
						var newStudentID          = parseInt(obj.id_no) + 1;
						var newAdmissionRoll    = parseInt(obj.admission_roll) + 1;
						
						$('#id_no').val(newStudentID);
						$('#admission_roll').val(newAdmissionRoll);	
					}
				}
			}); 
			return false;				
		});
    });
</script>