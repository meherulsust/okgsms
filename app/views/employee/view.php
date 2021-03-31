<div class="box box-primary">	
	<div class="box-header">
    	<i class="fa fa-pencil-square-o"></i>
    	<h3 class="box-title"><?php echo $page_title; ?></h3>
		<div class="box-tools pull-right">
			<a class="ajax_link" href="<?=$site_url . $link_action;?>">
			<button class="btn btn-primary btn-xs" type="button"><i class='fa fa-plus'></i>
				<?php echo $link_title; ?></button>
			</a>
		</div>
    </div>	
	<table class="form_table">
		<tr>
			<td width="1%">Name :</td>
			<td>
				<?php echo $name; ?>
			</td>
		</tr>
		<?php if(!empty($photo)):?>
		<tr>
			<td>Photo :</td>
			<td>
			<img src="<?= (!empty($photo)) ? $upload_url.'employee_images/'.$photo : $upload_url.'user_image/'.'default.png';?>"
                alt="User profile picture" class="profile-user-img">  
				<br/><a href="<?= $upload_url.'employee_images/'.$photo ?>"><button class="btn btn-primary btn-xs" type="button"><i class='fa fa-download'></i> View </button></a></td>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td>Designation :</td>
			<td>
				<?php echo $designation; ?>
			</td>
		</tr>
		<tr>
			<td>Relevant Subject :</td>
			<td>
				<?php echo $relevant_subject; ?>
			</td>
		</tr>	
		<tr>
			<td>Email :</td>
			<td>
				<?php echo $email; ?>				
			</td>
		</tr>	
		<tr>
			<td>Mobile No. :</td>
			<td>
				<?php echo $mobile_no; ?>
			</td>
		</tr>
		<tr>
			<td>Address :</td>
			<td>
				<?php echo $address; ?>
			</td>
		</tr>
		<?php if(!empty($cv)):?>
		<tr>
			<td>CV File :</td>
			<td>
				<a href="<?= $upload_url.'employee_cv/'.$cv ?>"><button class="btn btn-primary btn-xs" type="button"><i class='fa fa-download'></i> Download </button></a>
			</td>
		</tr>
		<?php endif;?>	
		<tr>
			<td></td>
			<td>
				<a href="<?= $site_url . $active_controller; ?>"><span class="btn btn-sm btn-primary">Back</span></a>
			</td>
		</tr>	
	</table>	
</div>



