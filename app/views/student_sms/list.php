<form id="ajax_submit" role="form" action="<?=$site_url.$active_controller.'/'.$this->method;?>" method="post">
	<div class="box box-primary">	
        <div class="box-header">
            <i class="fa fa-search"></i><h3 class="box-title">Search</h3>
        </div>	
        <table class="search_form_table">
            <tr>                
                <td>Mobile No:</td>
                <td>
                    <input name="mobile_no" type="text" class="form-control small"   value="<?= set_value('mobile_no'); ?>"/>
                </td>
                <td>Class:</td>
                <td>
                    <select name='class_id' class='form-control' id="class_id">
                      <option value="" >---- Select Class ----</option>
                      <?php echo html_options($class_options,set_value('class_id')); ?>
					          </select>                               
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