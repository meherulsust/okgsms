<div class="box box-primary">	
	<div class="box-header">
    	<i class="fa fa-pencil-square-o"></i>
    	<h3 class="box-title"><?php echo $page_title; ?></h3>
		<div class="box-tools pull-right">
			<a class="ajax_link" href="<?=$site_url . $link_action;?>">
			<button class="btn btn-primary btn-xs" type="button"><i class='fa fa-bars'></i>
				<?php echo $link_title; ?></button>
			</a>
        </div>
    </div>	
	<table class="form_table">
		<tr>
			<td>Name :</td>
			<td>
				<?php echo $full_name; ?>
			</td>
		</tr>
		<?php if(!empty($photo)):?>
		<tr>
			<td>Photo :</td>
			<td>
			<img src="<?= (!empty($photo)) ? $upload_url.'student_images/'.$photo : $upload_url.'user_image/'.'default.png';?>"
                alt="User profile picture" class="profile-user-img">  
				<br/><a href="<?= $upload_url.'student_images/'.$photo ?>"><button class="btn btn-primary btn-xs" type="button"><i class='fa fa-download'></i> View </button></a></td>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td>Class :</td>
			<td>
				<?php echo $class; ?>
			</td>
		</tr>
		<tr>
			<td>Form :</td>
			<td>
				<?php echo $section; ?>
			</td>
		</tr>	
		<tr>
			<td>Student ID :</td>
			<td>
				<?php echo $id_no; ?>				
			</td>
		</tr>	
		<tr>
			<td>Mobile No. :</td>
			<td>
				<?php echo $mobile_no; ?>
			</td>
		</tr>	
		<tr>
			<td></td>
			<td>
				<a href="<?= $site_url . $active_controller; ?>"><span class="btn btn-sm btn-primary">Back</span></a>
			</td>
		</tr>	
	</table>	
</div>



