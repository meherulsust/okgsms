<form id="ajax_submit" role="form" action="<?=$site_url.$active_controller.'/'.$this->method;?>" method="post">
	<div class="box box-primary">	
        <div class="box-header">
            <i class="fa fa-search"></i><h3 class="box-title">Search Employee</h3>
        </div>	
        <table class="search_form_table">
            <tr>                
                <td>Employee Type :</td>
                <td>
					<select name='category_id' class='form-control' id="category_id">
						<option value="" >---- Select Category ----</option>
						<?php echo html_options($category_options,set_value('category_id')); ?>
					</select>
				</td>
                <td>Mobile No:</td>
                <td>
                    <input name="mobile_no" type="text" class="form-control small"   value="<?= set_value('mobile_no'); ?>"/>
                </td>   
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    <a href="<?= $site_url . $active_controller.'/'.$this->method; ?>"><span class="btn btn-sm btn-info">Reset</span></a>
                </td>
            </tr>
        </table>    
    </div>
</form>	
<form id="ajax_submit" role="form" action="<?=$site_url.$active_controller;?>" method="post">
	<div class="box box-primary">	
		<div class="box-header">
			<i class="fa fa-table"></i><h3 class="box-title"><?php echo $page_title; ?></h3>
            <div class="box-tools pull-right">
				<a class="ajax_link" href="<?=$site_url.$link_action;?>">
					<button class="btn btn-primary btn-xs" type="button"><i class='fa fa-plus'></i> <?php echo $link_title; ?></button>
				</a>
			</div>
		</div>										
		<span class="delete_message"><?php echo $this->session->flashdata('message'); ?></span>
		<?php $this->load->element('grid_board');?>		
	</div>
</form>
<script type='text/javascript'>
$(document).ready(function() {
	var menuItems=[
					{title:'<i class="fa fa-check-circle text-success"> Active</i>',value:'Active'},
					{title:'<i class="fa fa-times-circle text-danger"> Inactive</i>',value:'Inactive'}				  
				  ];
	$("td.stat_menu a").statusMenu({items:menuItems}); 
});
</script>