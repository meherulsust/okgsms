<div class="box box-primary">	
	<div class="box-header">
		<i class="fa fa-list-alt"></i><h3 class="box-title"><?php echo $page_title; ?></h3>
		<div class="box-tools pull-right">
				<a class="ajax_link" href="<?=$site_url.$link_action;?>">
					<button class="btn btn-primary btn-xs" type="button"><i class='fa fa-bars'></i> <?php echo $link_title; ?></button>
				</a>
		</div>
	</div>	
	<table class="form_table">
		<tr>
			<td>Clsss Name :</td>
			<td>
				<?php echo $title;?> 
			</td>
		</tr>
		<tr>
			<td>Clsss Code :</td>
			<td>
				<?php echo $code;?> 
			</td>
		</tr>
		<tr>
			<td>Clsss Order :</td>
			<td>
				<?php echo $serial;?> 
			</td>
		</tr>
		
		<tr>
			<td>Status :</td>
			<td>
				<?php echo $status;?> 
			</td>
		</tr>	
	</table>	
</div>

<div class="box box-primary">
  <div class="box-header">
    <i class="fa fa-table"></i>
    <h3 class="box-title">Form List</h3>
    <div class="box-tools pull-right">
      <a href="<?=$site_url;?>classes/add_section/<?=encode($id);?>">
        <button class="btn btn-primary btn-xs" type="button"><i class='fa fa-plus'></i> Add Form</button>
        <a href="<?=$site_url . $active_controller;?>"><span class="btn btn-danger btn-xs">Cancel</span></a>
      </a>
    </div>
  </div>
  <span class="delete_message"><?php echo $this->session->flashdata('message'); ?></span>
  <?php $this->load->element('grid_board');?>
</div>
<script type='text/javascript'>
$(document).ready(function() {
  var menuItems = [{
      title: '<i class="fa fa-check-circle text-success"> Active</i>',
      value: 'active'
    },
    {
      title: '<i class="fa fa-times-circle text-danger"> Inactive</i>',
      value: 'inactive'
    }
  ];
  $("td.stat_menu a").statusMenu({
    items: menuItems
  });
});
</script>
