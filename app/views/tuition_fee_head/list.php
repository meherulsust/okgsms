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
          <td>Title:</td>
          <td>
            <input name="title" type="text" class="form-control" value="<?=set_value('title');?>" required />
            <span class='error'>* <?php echo form_error('title'); ?></span>
          </td>
        </tr>
        <tr>
          <td>Status :</td>
          <td>
            <select class="form-control" name="status" required>
              <?php echo html_options($status_options, set_value('status')); ?>
            </select>
            <span class='error'>* <?php echo form_error('status'); ?></span>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            <button type="reset" class="btn btn-sm btn-danger">Reset</button>
          </td>
        </tr>
      </table>
    <?php $this->load->element('grid_board');?>
  </div>
</form>
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