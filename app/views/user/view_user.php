<div class="box box-primary">
  <div class="box-header">
    <i class="fa fa-list-alt"></i>
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
			<td>Image :</td>
			<td class="user-img">
         		<img src="<?= (!empty($image)) ? $upload_url.'user_image/'.$image : $upload_url.'user_image/'.'default.png';?>"
                alt="User profile picture" class="profile-user-img">  
			</td>
		</tr>		
		<tr>
			<td>Name :</td>
			<td>
				<?php echo $full_name; ?>
			</td>
		</tr>
		<tr>
			<td>Username :</td>
			<td>
				<?php echo $username; ?>
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
				<?php echo $mobile; ?>
			</td>
		</tr>
		<tr>
			<td>Address :</td>
			<td>
				<?php echo $address; ?>
			</td>
		</tr>
		<tr>
			<td>Group :</td>
			<td>
				<?php echo $admin_type; ?>				
			</td>
		</tr>
    <tr>
        <td></td>
        <td>
          <a href="<?=$site_url . $active_controller ;?>"><span class="btn btn-sm btn-primary">Back</span></a>
        </td>
      </tr>			
	</table>	
</div>