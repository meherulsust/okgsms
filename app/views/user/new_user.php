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
        <td>Username :</td>
        <td>
          <input name="username" type="text" class="form-control" value="<?=set_value('username');?>" required autocomplete="new-username"/>
          <span class='error'>* <?php echo form_error('username'); ?></span>
        </td>
      </tr>
      <tr>
        <td>Password :</td>
        <td>
          <input name="password" class="form-control" type="password" value="<?=set_value('password');?>" autocomplete="new-password"/>
          <span class='error'>* <?php echo form_error('password'); ?></span>
        </td>
      </tr>
      <tr>
        <td>Retype Password :</td>
        <td>
          <input name="confirm_password" class="form-control" type="password"
            value="<?=set_value('confirm_password');?>" />
          <span class='error'>* <?php echo form_error('confirm_password'); ?></span>
        </td>
      </tr>
      <tr>
        <td>Full Name :</td>
        <td>
          <input name="full_name" type="text" class="form-control" value="<?=set_value('full_name');?>" required />
          <span class='error'>* <?php echo form_error('full_name'); ?></span>

        </td>
      </tr>
      <tr>
        <td>Email :</td>
        <td>
          <input name="email" type="text" class="form-control" value="<?=set_value('email');?>" required />
          <span class='error'>* <?php echo form_error('email'); ?></span>
        </td>
      </tr>
      <tr>
        <td>Mobile No. :</td>
        <td>
          <input name="mobile" type="text" class="form-control" value="<?=set_value('mobile');?>" required />
          <span class='error'>* <?php echo form_error('mobile'); ?></span>
        </td>
      </tr>
      <tr>
        <td>Address :</td>
        <td>
          <textarea name="address" class="form-control"><?=set_value('address');?></textarea>
        </td>
      </tr>
      <tr>
        <td>Profile Picture :</td>
        <td>
          <input name="image_file" type="file" class='form-control' /> [Size (300 X 300)]
          <span class='error'><?= !empty($upload_error) ? $upload_error :'';?></span>
        </td>
      </tr>
      <tr>
        <td>Group :</td>
        <td>
          <select class="form-control" name="id_admin_group" id ="id_admin_group" required>
            <option value="">---- Select Group ----</option>
            <?php echo html_options($admin_group_options, set_value('id_admin_group')); ?>
          </select>
          <span class='error'>* <?php echo form_error('id_admin_group'); ?></span>
        </td>
      </tr>
      <!-- <?php if($this->session->userdata('admin_group_id')==1): ?>
        <tr id="tenant">
          <td>Tenant :</td>
          <td>
            <select class="form-control" name="tenant_id">
              <option value="">---- Select tenant ----</option>
              <?php echo html_options($tenant_options, set_value('tenant_id')); ?>
            </select>
            <span class='error'>* <?php echo form_error('tenant_id'); ?></span>
          </td>
        </tr>
      <?php endif;?> -->
      <tr>
        <td>Status :</td>
        <td>
          <select class="form-control" name="status" required>
            <option value="">---- Select status ----</option>
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
    $('#tenant').hide();
    $('#id_admin_group').change(function(){
      if($('#id_admin_group').val() == '1' || $('#id_admin_group').val() == '2') {
        $('#tenant').hide();
      }else{
        $('#tenant').hide();
      }
    }); 
  }); 
</script>