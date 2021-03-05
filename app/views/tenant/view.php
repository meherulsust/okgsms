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
			<td width="1%">Tenant Name :</td>
			<td>
				<?php echo $title; ?>
			</td>
		</tr>
		<tr>
			<td width="1%">Subdomain :</td>
			<td>
				<?php echo $subdomain; ?>
			</td>
		</tr>
		<tr>
			<td>Login Banner :</td>
			<td><img src="<?=(!empty($login_banner)) ? $upload_url.'login_banner/'.$login_banner : $upload_url.'login_banner/'.'default_banner.png';?>"  width="200"></td>
    	</tr>
		<tr>
			<td>Logo :</td>
			<td><img src="<?=(!empty($logo)) ? $upload_url.'logo/'.$logo : $upload_url.'logo/'.'default_logo.png';?>"  width="120"></td>
    	</tr>
    	<tr>
			<td>Contact number :</td>
			<td>
				<?php echo $contact_number; ?>
			</td>
		</tr>
		<tr>
			<td>Email :</td>
			<td>
				<?php echo $email; ?>
			</td>
		</tr>
		<tr>
			<td>Fax :</td>
			<td>
				<?php echo $fax; ?>
			</td>
		</tr>
		<tr>
			<td>Website :</td>
			<td>
				<?php echo $website; ?>
			</td>
		</tr>
		<tr>
			<td>Favicon :</td>
			<td><img src="<?=(!empty($favicon)) ? $upload_url.'logo/'.$favicon : $upload_url.'logo/'.'default_favicon.ico';?>"  width="30"></td>
    	</tr>			
		<tr>
			<td>Description :</td>
			<td>
				<?php echo $description; ?>
			</td>
		</tr>
		<tr>
			<td>Status :</td>
			<td>
				<?php echo $status; ?>
			</td>
		</tr>		
		<tr>
			<td></td>
			<td>
				<a href="<?= $site_url.$active_controller; ?>"><span class="btn btn-sm btn-primary">Back</span></a>
			</td>
		</tr>	
	</table>	
</div>