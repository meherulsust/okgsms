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
        <td>Country Name :</td>
        <td>
          <input name="country" type="text" class="form-control" value="<?=set_value('country');?>" required />
          <span class='error'>* <?php echo form_error('country'); ?></span>
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