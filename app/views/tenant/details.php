<div class="box box-primary">
  <div class="box-header">
    <i class="fa fa-pencil-square-o"></i>
    <h3 class="box-title"><?php echo $page_title; ?></h3>
      <div class="box-tools pull-right">
        <a class="ajax_link" href="<?=$site_url . $link_action;?>">
          <button class="btn btn-primary btn-xs" type="button"><i class='fa fa-plus'></i>
            <?php echo $link_title; ?></button>
        </a>
      </div>
    </div>
  <form role="form" action="<?php echo $site_url . $active_controller ?>/details/<?php echo encode($id); ?>" method="post"
    enctype="multipart/form-data">
    <table class="form_table">
    <tr>
      <tr>
        <td>Fax :</td>
        <td>
          <input name="fax" type="text" class="form-control" value="<?=set_value('fax',$fax);?>"  />
        </td>
      </tr>
      <tr>
        <td>Website :</td>
        <td>
          <input name="website" type="text" class="form-control" value="<?=set_value('website',$website);?>"  />
        </td>
      </tr>
      <tr>
      <tr>
        <td>Address :</td>
        <td>
          <textarea name="address" class="form-control"><?=set_value('address',$address);?></textarea>
        </td>
      </tr>
      <tr>
        <td>Favicon :</td>
        <td>
          <input type="file" name="favicon"  class='form-control' />
          <?php
          if(!empty($favicon)) : ?>
            <img src="<?=$upload_url.'logo/'.$favicon ;?>"  width="16">
          <?php endif; ?>  
           [Size (16x16 pixels)]
           <span class='error'> <?=(isset($error_favicon))? $error_favicon :''; ?></span>
        </td>
      </tr>
      <tr>
        <td>Logo :</td>
        <td>
          <input type="file" name="logo"  class='form-control' />
          <?php
          if(!empty($logo)) : ?>
            <img src="<?=$upload_url.'logo/'.$logo ;?>"  width="120">
          <?php endif; ?>  
           [Size (220 X 50)]
           <span class='error'> <?=(isset($error_logo))? $error_logo :''; ?></span>
        </td>
      </tr>
      <tr>
        <td>Login Banner :</td>
        <td>
          <input type="file" name="login_banner"  class='form-control' />
          <?php
          if(!empty($login_banner)) : ?>
            <img src="<?=$upload_url.'login_banner/'.$login_banner?>"  width="200">
          <?php endif; ?>  
           [Size (1000 X 500)]
           <span class='error'> <?=(isset($error_login_banner))? $error_login_banner :''; ?></span>
        </td>
      </tr>      
      <tr>
        <td>Description :</td>
        <td>
          <textarea name="description" class="form-control"><?=set_value('description',$description);?></textarea>
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