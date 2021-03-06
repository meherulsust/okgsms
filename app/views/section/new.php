<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-pencil-square-o"></i><h3 class="box-title"><?php echo $page_title;?></h3>
		<div class="box-tools pull-right">
			<a class="ajax_link" href="<?=$site_url.$link_action;?>">
				<button class="btn btn-primary btn-xs" type="button"><i class='fa fa-bars'></i> <?php echo $link_title; ?></button>
			</a>
		</div>
	</div>	
	<form class="ajax_submit" role="form" action="<?=$site_url.$active_controller?>/add_section" method="post" enctype="multipart/form-data">
		<table class="form_table">
			<tr>
				<td>Version :</td>
				<td>
					<select class="form-control" name="version_id" required>
						<option value="" >---- Select version ----</option>
						<?php echo html_options($version_options,set_value('version_id')) ;?>
					</select> 
					<span class='error'>* <?php echo form_error('version_id'); ?></span>	
				</td>
			</tr>
			<tr>
				<td>Section Name :</td>
				<td>
					<input name="title" type="text" class="form-control" value="<?=set_value('title'); ?>" required/>
					<span class='error'>* <?php echo form_error('title'); ?></span>
				</td>
			</tr>
			<tr>
				<td>Room Number :</td>
				<td>
					<input name="room_number" class="form-control" type="text" value="<?=set_value('room_number'); ?>"/>
					<!--<span class='error'>* <?php echo form_error('room_number'); ?></span>-->				
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
				<td>Description :</td>
				<td>
					<textarea name="description" class='form-control'><?=set_value('description'); ?></textarea>
					<!--<span class='error'>* <?php echo form_error('description'); ?></span>-->	
				</td>
			</tr>
			<tr>
				<td>
					<input name="class_id" type="hidden" class="form-control" value="<?=decode($class_id); ?>" />
				</td>
				<td>
					 <button type="submit" class="btn btn-sm btn-primary">Submit</button>
					 <button type="reset" class="btn btn-sm btn-danger">Reset</button>
				</td>
			</tr>
		</table>			
	</form>
</div>



