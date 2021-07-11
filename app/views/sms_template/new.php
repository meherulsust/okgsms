<div class="box box-primary">
  <div class="box-header">
    <i class="fa fa-pencil-square-o"></i>
    <h3 class="box-title"><?php echo $page_title; ?></h3>
      <div class="box-tools pull-right">
        <a class="ajax_link" href="<?=$site_url . $link_action;?>">
          <button class="btn btn-primary btn-xs" type="button"><i class='fa fa-bars'></i>
            <?php echo $link_title; ?></button>
        </a>
      </div>
    </div>
  <form class="ajax_submit" role="form" action="<?=$site_url . $active_controller?>/add" method="post"
    enctype="multipart/form-data">
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
  </form>
</div>

<script>

$(document).ready(function(){	
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