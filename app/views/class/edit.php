<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-pencil-square-o"></i><h3 class="box-title"><?php echo $page_title;?></h3>
	</div>	
	<form class="ajax_submit" role="form" action="<?=$site_url.$active_controller?>/edit/<?= encode($id);?>" method="post" enctype="multipart/form-data">
		<table class="form_table">
			<tr>
				<td>Class Name :</td>
				<td>
					<input name="title" type="text" class="form-control" value="<?=set_value('title',$title); ?>" required />
					<span class='error'>* <?php echo form_error('title'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Class Code :</td>
				<td>
					<input name="code" class="form-control" type="text" value="<?=set_value('code',$code); ?>"/>
					<!--<span class='error'>* <?php echo form_error('code'); ?></span>-->				
				</td>
			</tr>		
			<tr>
				<td>Serial No :</td>
				<td>
					<input name="serial" type="text" class="form-control" value="<?=set_value('serial',$serial); ?>" required/>
					<span class='error'>* <?php echo form_error('serial'); ?></span>
					
				</td>
			</tr>
			<tr>
				<td>First Working Day :</td>
				<td>
					<input type="text" class="form-control calander"  name="start_date" value="<?=set_value('start_date',$start_date); ?>" required/>
					<span class="add-on"><span class="glyphicon glyphicon-calendar"></span>
					<span class="error">* <?php echo form_error('start_date'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Last Working Day :</td>
				<td>
					<input type="text" class="form-control calander"  name="end_date" value="<?=set_value('end_date',$end_date); ?>" required/>
					<span class="add-on"><span class="glyphicon glyphicon-calendar"></span>
					<span class="error">* <?php echo form_error('end_date'); ?></span>
				</td>
			</tr>		
			<tr>
				<td>Result Scale :</td>
				<td>
					<select class="form-control" name="result_scale_id" required >
						<!--<option value="" >---- Select Rsult Scale ----</option>-->
						<option value="1" > Defualt </option>
						<?php echo html_options($scale_options,set_value('result_scale_id',$result_scale_id)) ;?>
					</select> 
					<span class='error'>* <?php echo form_error('result_scale_id'); ?></span>	
				</td>
			</tr>
			<tr>
				<td>Result :</td>
				<td>
					<select class="form-control" name="is_result_publish" required>
						<option value="" >---- Select Result ----</option>
						<?php echo html_options($result_options,set_value('is_result_publish',$is_result_publish)) ;?>
					</select> 
					<span class='error'>* <?php echo form_error('is_result_publish'); ?></span>	
				</td>
			</tr>
			<tr>
				<td>Status :</td>
				<td>
					<select name='status' class='form-control' required>
					<option value="" >---- Select Status ----</option>
					<?php echo html_options($status_options,set_value('status',$status)); ?>
					</select>
					<span class='error'>* <?php echo form_error('status'); ?> </span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					 <button type="submit" class="btn btn-sm btn-primary">Update</button>
					 <a href="<?= $site_url . $active_controller; ?>"><span class="btn btn-sm btn-danger">Cancel</span></a>
				</td>
			</tr>
		</table>			
	</form>
</div>
<script>
$(document).ready(function(){
		$('.calander').datepicker({
			format: 'yyyy-mm-dd',
			todayHighlight:true,
			autoclose: true
		});	
}); 
</script>



