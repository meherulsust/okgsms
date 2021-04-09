<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-pencil-square-o"></i><h3 class="box-title"><?php echo $page_title; ?></h3>
	</div>	
	<form role="form" action="<?php echo $site_url.$active_controller?>/edit/<?= encode($id);?>" method="post" enctype="multipart/form-data">
		<table class="form_table">
			<tr>
				<td>School name :</td>
				<td>
					<input name="name" type="text" class="form-control" value="<?=set_value('name',$name); ?>"/>
					<span class='error'>* <?php echo form_error('name'); ?></span>
				</td>
			</tr>
			<tr>				
				<td>Address :</td>
				<td>
					<textarea name="address1" class='form-control'><?=set_value('address1',$address1); ?></textarea>
					<span class='error'>* <?php echo form_error('address1'); ?></span>	
				</td>
			</tr>	
			<tr>				
				<td>Another Address :</td>
				<td>
					<textarea name="address2" class='form-control'><?=set_value('address2',$address2); ?></textarea>
				</td>
			</tr>
			<tr>
				<td>Establish date :</td>
				<td>
					<input type="text" class="form-control calander"  name="establish_date" value="<?=set_value('establish_date',$establish_date); ?>"/>
					<span class="add-on"><span class="glyphicon glyphicon-calendar"></span>
					<span class="error">* <?php echo form_error('establish_date'); ?></span>
				</td>
			</tr>	
			<tr>				
				<td>Description :</td>
				<td>
					<textarea name="description" class='form-control'><?=set_value('description',$description); ?></textarea>
				</td>
			</tr>
			<tr>				
				<td>Logo :</td>
				<td>
					<input name="logo" type="file" class='form-control'/>
					<?php
					if(!empty($logo)) : ?>
						<img src="<?=$upload_url.'logo/'.$logo ;?>"  width="120">
					<?php endif; ?>  
					[Size (220 X 50)]
					<span class='error'></span> <?php if(!empty($upload_error)) echo $upload_error; ?>
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
			autoclose: true
		});	
}); 
</script>

