<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-list-alt"></i><h3 class="box-title"><?php echo $page_title; ?></h3>
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
				<img src="<?=$base_url;?>upload_images/teacher_image/<?php echo $photo;?>"  width="120">
				<br/><a href="<?php echo $site_url.$active_controller;?>/download_photo/<?php echo $id?>"><button class="btn btn-primary btn-xs" type="button"><i class='fa fa-download'></i> Download </button></a></td>
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
				<?php echo $designation; ?>
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
		<?php if(!empty($cv_upload)):?>
		<tr>
			<td>CV File :</td>
			<td>
				<a href="<?php echo $site_url.$active_controller;?>/download_cv/<?php echo $id?>"><button class="btn btn-primary btn-xs" type="button"><i class='fa fa-download'></i> Download </button></a>
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



