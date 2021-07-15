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
				<td>Full Message :</td>
				<td>
					<textarea type="text" class="form-control message" rows="10" name="description"><?=set_value('description'); ?></textarea>
					<span class="error">* <?php echo form_error('description'); ?></span>
					<div id="charNum">(Maximum 480 characters)</div> 
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
    </form>  
    <form id="ajax_submit" role="form" action="<?=$site_url . $active_controller;?>" method="post">  
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

    $('.message').on("change input paste keyup", function() {
      var max = 480;
      var len = $(this).val().length;
      if (len >= max) {
        $('#charNum').html('<span style="color:red">You have reached the limit.</span>');
      } else {
        var char = max - len;
        $('#charNum').html('<span style="color:green">'+ char + ' characters left.</span>');
      }
    });

  });

</script>