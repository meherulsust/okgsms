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
				<td>Admission  Date :</td>
				<td>
					<input type="text" class="form-control calander"  name="admission_date" value="<?=set_value('admission_date',current_date_bd()); ?>" required autocomplete="off"/>
					<span class="add-on"><span class="glyphicon glyphicon-calendar"></span>
					<span class="error">* <?php echo form_error('admission_date'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Session :</td>
				<td>
					<input type="text" class="form-control"  name="session" value="<?=set_value('session',current_year()); ?>" required autocomplete="off"/>
					<span class="error">* <?php echo form_error('session'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Student Type :</td>
				<td>
					<select name='student_type_id' class='form-control' id="student_type_id" required>
						<?php echo html_options($student_type_options,set_value('student_type_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('student_type_id'); ?> </span>
				</td>
			</tr>
			<tr>
				<td>Name :</td>
				<td>
					<input name="full_name" type="text" class="form-control" value="<?=set_value('full_name'); ?>" autocomplete="off" required/>
					<span class='error'>* <?php echo form_error('full_name'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Class :</td>
				<td>
					<select name='class_id' class='form-control' id="class_id" required>
						<option value="" >---- Select Class ----</option>
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
					<span class='error'> <?php echo form_error('id_no'); ?> </span>
				</td>
			</tr>
			<tr>
				<td>Admission Roll :</td>
				<td>
					<input name="admission_roll" type="text" id="admission_roll" class="form-control" value="<?=set_value('admission_roll'); ?>" readonly/>
					<span class='error'> <?php echo form_error('admission_roll'); ?> </span>
				</td>
			</tr>
			<tr>
				<td>Class Roll :</td>
				<td>
					<input name="class_roll" type="text" id="class_roll" class="form-control" value="<?=set_value('class_roll'); ?>" required />
					<span class='error'>* <?php echo form_error('class_roll'); ?> </span>
				</td>
			</tr>
			<tr>
                <td>Has Siblings :</td>
                <td>
                    <input  style="width:20px;" class="form-control has_sibling" type="radio" name="has_sibling" value="yes" <?php echo set_value('has_sibling') == 'yes' ? "checked" : ""; ?> /> Yes
                    <input style="width:20px;margin-left:20px;" class="form-control has_sibling" type="radio" name="has_sibling" value="no" <?php echo set_value('has_sibling') == 'no' ? "checked" : ""; ?> /> No
                    <span class='error' style="margin-left:193px;">* <?php echo form_error('has_sibling'); ?></span>	
                </td>
            </tr>
			<tr class="has_sibling_no">
				<td>Father NID No :</td>
				<td>
					<input name="father_nid" id="father_nid" type="text" class="form-control" value="<?=set_value('father_nid'); ?>" />
					<span class='error'> <?php echo form_error('father_nid'); ?> </span>
				</td>
			</tr>
			<tr class="has_sibling_no">
				<td>Mother NID No :</td>
				<td>
					<input name="mother_nid" id="mother_nid" type="text" class="form-control" value="<?=set_value('mother_nid'); ?>" />
					<span class='error'> <?php echo form_error('mother_nid'); ?> </span>
				</td>
			</tr>
			<tr class="has_sibling_yes">
				<td>Siblings Class :</td>
				<td>
					<select name='sibling_class_id' class='form-control' id="sibling_class_id">
						<option value="" >---- Select Siblings Class ----</option>
						<?php echo html_options($class_options,set_value('sibling_class_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('sibling_class_id'); ?> </span>
				</td>
				<input type="hidden" name="class_code" id="class_code" />
			</tr>
			<tr  class="has_sibling_yes">
				<td>Siblings Form:</td>
				<td>
					<select name='sibling_section_id' class='form-control' id="sibling_section_id">
						<option value="" >---- Select Siblings Form ----</option>
						<?php echo html_options($section_options,set_value('sibling_section_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('sibling_section_id'); ?> </span>
				</td>
			</tr>
			<tr class="has_sibling_yes">
				<td>Siblings :</td>
				<td>
				<select class="form-control" name="sibling_id" id ="sibling_id">
					<option value="">---- Select Siblings ----</option>
					<?php echo html_options($student_options, set_value('sibling_id')); ?>
				</select>
				<span class='error'>* <?php echo form_error('sibling_id'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Birth Certificate No :</td>
				<td>
					<input name="birth_certificate_no" id="birth_certificate_no" type="number" class="form-control" value="<?=set_value('birth_certificate_no'); ?>" />
					<span class='error'> <?php echo form_error('birth_certificate_no'); ?> </span>
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
					<select name='blood_group_id' class='form-control'>
					<option value="" >---- Select Blood group ----</option>
					<?php echo html_options($blood_group_options,set_value('blood_group_id')); ?>
					</select>
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
				<td>Mobile No. :</td>
				<td>
					<input name="mobile_no" type="text" class="form-control" value="<?=set_value('mobile_no'); ?>" required>
					<span class='error'>* <?php echo form_error('mobile_no'); ?> [ Will use for sms sending ]</span>					
				</td>
			</tr>
			<tr>
				<td>Mobile No Owner :</td>
				<td>
					<input name="mobile_no_owner" type="text" class="form-control" value="<?=set_value('mobile_no_owner'); ?>" >				
				</td>
			</tr>
			<tr>				
				<td>Photo :</td>
				<td>
					<input name="photo" type="file" class='form-control'/> 
					<span class='error'> <?=(isset($error_photo))? $error_photo :''; ?>[Size (300 X 300)]</span>
				</td>
			</tr>
			<tr>
				<td>Status :</td>
				<td>
					<select name='status' class='form-control' required>
					<?php echo html_options($status_options,set_value('status')); ?>
					</select>
					<span class='error'>* <?php echo form_error('status'); ?> </span>
				</td>
			</tr>
			<tr>
				<td>Special Note :</td>
				<td>
					<textarea name="description" class="form-control" required><?php echo set_value('description'); ?> </textarea>
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

		$(".chosen").chosen();

		$('.has_sibling_yes').hide();
		$('.has_sibling_no').hide();
		var has_sibling = $("input[name='has_sibling']:checked").val();
		if(has_sibling =='yes'){
				$('.has_sibling_yes').show();
				$('.has_sibling_no').hide();
			}else if(has_sibling =='no'){
				$('.has_sibling_yes').hide();
				$('.has_sibling_no').show();
			}
		$(".has_sibling").change(function() {
			var has_sibling = $("input[name='has_sibling']:checked").val();
			if(has_sibling =='yes'){
				$('.has_sibling_yes').show();
				$('.has_sibling_no').hide();
			}else if(has_sibling =='no'){
				$('.has_sibling_yes').hide();
				$('.has_sibling_no').show();
			}
		});

		$('#sibling_class_id').selectChain({
          target: $('#sibling_section_id'),
          value: 'title',
          url: '<?php echo site_url(); ?>student/get_section',
          type: 'post',
          data: {'class_id': 'sibling_class_id'}
      	});

		$('#sibling_section_id').selectChain({
          target: $('#sibling_id'),
          value: 'title',
          url: '<?php echo site_url(); ?>student/get_student',
          type: 'post',
          data: {'section_id': 'sibling_section_id'}
      	});

		$('.calander').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true
		});	

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
					if(obj == null)
					{
						var defaultCode   	     = $('#class_code').val();
						var defaultStudentID 	 = currentYear + defaultCode + defaultRoll;
						var defaultAdmissionRoll = defaultCode + defaultRoll;
						
						$('#id_no').val(defaultStudentID);	
						$('#admission_roll').val(defaultAdmissionRoll);
						$('#class_roll').val(defaultRoll);		
					}else{
						var newStudentID          = parseInt(obj.id_no) + 1;
						var newAdmissionRoll      = parseInt(obj.admission_roll) + 1;
						var newClassRoll      	  = parseInt(obj.class_roll) + 1;
						
						$('#id_no').val(newStudentID);
						$('#admission_roll').val(newAdmissionRoll);	
						$('#class_roll').val(newClassRoll);	
					}
				}
			}); 
			return false;				
		});

    });
</script>