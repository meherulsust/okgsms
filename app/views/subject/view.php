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
			<td width="1%">Title :</td>
			<td>
				<?php echo $title; ?>
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