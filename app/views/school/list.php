<form id="ajax_submit" role="form" action="<?php echo $site_url.$active_controller;?>" method="post">
	<div class="box box-primary">	
		<div class="box-header">
			<i class="fa fa-table"></i><h3 class="box-title">School List</h3>
		</div>										
		<span class="delete_message"><?php echo $this->session->flashdata('message'); ?></span>
		<?php $this->load->element('grid_board');?>		
	</div>
</form>
