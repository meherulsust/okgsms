<form id="ajax_submit" role="form" action="<?=$site_url.$active_controller.'/'.$this->method;?>" method="post">
	<div class="box box-primary">	
        <div class="box-header">
            <i class="fa fa-search"></i><h3 class="box-title">Search Student</h3>
        </div>	
        <table class="search_form_table">
            <tr>                
                <td>Student ID :</td>
                <td>
                    <input name="id_no" class="form-control" type="text" value="<?= set_value('id_no'); ?>"/>                               
                </td>
                <td>Mobile No:</td>
                <td>
                    <input name="mobile_no" type="text" class="form-control small"   value="<?= set_value('mobile_no'); ?>"/>
                </td>   
            </tr>
            <tr>                
                <td>Class:</td>
                <td>
                    <select name='class_id' class='form-control' id="class_id">
						<option value="" >---- Select Class ----</option>
						<?php echo html_options($class_options,set_value('class_id')); ?>
					</select>                               
                </td>
                <td>Form</td>
                <td>
                    <select name='section_id' class='form-control' id="section_id">
						<option value="" >---- Select Form ----</option>
						<?php echo html_options($section_options,set_value('section_id')); ?>
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
    <?php $this->load->element('grid_board');?>
  </div>
</form>

<script>

$('#class_id').selectChain({
    target: $('#section_id'),
    value: 'title',
    url: '<?php echo site_url(); ?>student/get_section',
    type: 'post',
    data: {'class_id': 'class_id'}
});

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