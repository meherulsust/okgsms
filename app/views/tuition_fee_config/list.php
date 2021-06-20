<form class="ajax_submit" role="form" action="<?=$site_url . $active_controller?>/add" method="post"
  enctype="multipart/form-data">
  <div class="box box-primary">
  <div class="box-header">
    <i class="fa fa-pencil-square-o"></i>
    <h3 class="box-title"><?php echo $page_title; ?></h3>
      <div class="box-tools pull-right">
        <!-- <a class="ajax_link" href="<?=$site_url . $link_action;?>">
          <button class="btn btn-primary btn-xs" type="button"><i class='fa fa-plus'></i>
            <?php echo $link_title; ?></button>
        </a> -->
      </div>
    </div>
    <span class="delete_message"><?php echo $this->session->flashdata('message'); ?></span>
    <table class="form_table">
      <tr>
				<td>Class :</td>
				<td>
					<select name='class_id' class='form-control' id="class_id" required>
						<option value="" >---- Select Class ----</option>
						<?php echo html_options($class_options,set_value('class_id')); ?>
					</select>
					<span class='error'>* <?php echo form_error('class_id'); ?> </span>
				</td>
				<input type="hidden" name="class_code" id="class_code" />
			</tr>
      <tr>
        <td>Tuition Fee Head :</td>
        <td>
          <select class="form-control" name="tuition_fee_head_id" required>
            <option value="" >---- Select Tuition fee head ----</option>
            <?php echo html_options($tuition_fee_head_options, set_value('tuition_fee_head_id')); ?>
          </select>
          <span class='error'>* <?php echo form_error('tuition_fee_head_id'); ?></span>
        </td>
      </tr>
      <tr>
        <td>Month :</td>
        <td>
          <select class="form-control" name="month_id" required>
            <option value="" >---- Select month ----</option>
            <?php echo html_options($month_option, set_value('month_id')); ?>
          </select>
          <span class='error'>* <?php echo form_error('month_id'); ?></span>
        </td>
      </tr>
      <tr>
				<td>Amount :</td>
				<td>
					<input name="amount" type="number" class="form-control" value="<?=set_value('amount'); ?>" autocomplete="off" required/>
					<span class='error'>* <?php echo form_error('amount'); ?></span>
				</td>
			</tr>
      <!-- <tr>
        <td>Status :</td>
        <td>
          <select class="form-control" name="status" required>
            <?php echo html_options($status_options, set_value('status')); ?>
          </select>
          <span class='error'>* <?php echo form_error('status'); ?></span>
        </td>
      </tr> -->
      <tr>
        <td></td>
        <td>
          <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          <button type="reset" class="btn btn-sm btn-danger">Reset</button>
        </td>
      </tr>
    </table>
    </form>
    <form id="ajax_submit" role="form" action="<?=$site_url . $active_controller;?>" method="post">
    <div class="box box-primary">	
        <div class="box-header">
            <i class="fa fa-search"></i><h3 class="box-title">Search</h3>
        </div>	
        <table class="search_form_table">
            <tr>                
                <td>Class :</td>
                <td>
                    <select name='class_id' class='form-control' id="class_id">
                      <option value="" >---- Select Class ----</option>
                      <?php echo html_options($class_options,set_value('class_id')); ?>
					          </select>
                </td>
                <td>Month:</td>
                <td>
                    <select name='month_id' class='form-control' id="month_id">
                      <option value="" >---- Select Month ----</option>
                      <?php echo html_options($month_option,set_value('month_id')); ?>
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
      <?php $this->load->element('grid_board');?>
    </form>
  </div>
<script type='text/javascript'>
$(document).ready(function() {
  var menuItems = [{
      title: '<i class="fa fa-check-circle text-success"> Active</i>',
      value: 'Active'
    },
    {
      title: '<i class="fa fa-times-circle text-danger"> Inactive</i>',
      value: 'Inactive'
    }
  ];
  $("td.stat_menu a").statusMenu({
    items: menuItems
  });
});
</script>