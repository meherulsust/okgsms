<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link href="<?=isset($tenant_info['favicon']) ? $upload_url.'logo/'.$tenant_info['favicon']: $upload_url.'logo/default_favicon.ico'; ?>" rel="shortcut icon" width="16"/>
  <title><?= isset($tenant_info['title'])?$tenant_info['title']:'AIID' ?> Admin Panel</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="<?php echo $css_url; ?>bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo $css_url; ?>font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo $css_url; ?>app.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo $css_url; ?>login.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div id="bg">
    <img src="<?= isset($tenant_info['login_banner']) ? $upload_url.'login_banner/'.$tenant_info['login_banner']: $upload_url.'login_banner/default_banner.jpg'; ?>" />
  </div>
  <div class="form-box" id="login-box">
    <?php echo $content_for_layout; ?>
  </div>
   <div id="copy-right">
    <p>All rights preserved by <a style="color:#011" href='#'>AIM ICT ACADEMY</a> <?php echo date('Y') - 1 . '-' . date('Y') ?></p>
  </div>
  <script src="<?php echo $js_url; ?>jquery-2.0.2.js"></script>
  <script>
  $(document).ready(function() {
    $(document).on("submit", "#login", function() {
      $('.login_result').html('<i class="fa fa-refresh fa-spin"></i> Login ...');
      form = $("#login").serialize();
      var formURL = $(this).attr("action");
      $.ajax({
        type: "POST",
        url: formURL,
        data: form,
        success: function(data) {
          if(data == 1 ||data==3) {
            $('.login_result').html('<div class="alert alert-success"><strong>Success!</strong> Login successfully...</div>');
            window.location = "<?php echo $site_url; ?>home";
          }else if (data == 2) {
            $('.login_result').html(
              '<div class="alert alert-warning"><strong>Please!</strong> check home menu  access.</div>');
          }else if (data == 5) {
            $('.login_result').html(
              '<div class="alert alert-warning"><strong>Wrong!</strong> url Please check the url.</div>');
          }else {
            $('.login_result').html(
              '<div class="alert alert-danger"></i> <strong>Invalid!</strong> username or password.</div>');
          }
        }
      });
      return false;
    });
  });
  </script>
</body>

</html>