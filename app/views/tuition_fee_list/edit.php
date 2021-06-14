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
  <form role="form" action="<?php echo $site_url . $active_controller ?>/edit/<?php echo encode($id); ?>" method="post"
    enctype="multipart/form-data">
    <table class="form_table">
    <tr>
				<td>Class :</td>
				<td>
					<select name='class_id' class='form-control' id="class_id" required>
						<option value="" >---- Select Class ----</option>
						<?php echo html_options($class_options,set_value('class_id',$class_id)); ?>
					</select>
					<span class='error'>* <?php echo form_error('class_id'); ?> </span>
				</td>
				<input type="hidden" name="class_code" id="class_code" />
			</tr>
      <tr>
        <td>Month :</td>
        <td>
          <select class="form-control" name="month" required>
            <option value="" >---- Select month ----</option>
            <?php echo html_options($month_option, set_value('month',$month)); ?>
          </select>
          <span class='error'>* <?php echo form_error('month'); ?></span>
        </td>
      </tr>
      <tr>
        <td>Year :</td>
        <td>
          <select class="form-control" name="year" required>
            <option value="" >---- Select year ----</option>
            <?php echo html_options($year_option, set_value('year',$year)); ?>
          </select>
          <span class='error'>* <?php echo form_error('year'); ?></span>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <button type="submit" class="btn btn-sm btn-primary">Update</button>
          <a href="<?=$site_url . $active_controller;?>"><span class="btn btn-sm btn-danger">Cancel</span></a>
        </td>
      </tr>
    </table>
  </form>
</div>