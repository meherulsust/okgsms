		<div class="header">
		      <img src="<?= isset($tenant_info['logo']) ? $upload_url.'logo/'.$tenant_info['logo']: $upload_url.'logo/logo.png'; ?>" height="80" /> 
		</div>
		<form id="login" action="<?= $site_url ?>login/index" method="post">
		  <div class="body bg-gray">
		    <span class="login_result"></span>
		    <div class="form-group left-inner-addon">
		      <i class="fa fa-user"></i>
		      <input  type="text" name="username" class="form-control login_field"
		        placeholder="Enter Your Username" autocomplete="new-username" required />
		    </div>
		    <div class="form-group left-inner-addon">
		      <i class="fa fa-unlock-alt"></i>
		      <input  type="password" name="password" class="form-control login_field"
		        placeholder="Enter Your Password" autocomplete="new-password" required />
		    </div>
		  </div>
		  <div class="footer">
		  	<input  type="hidden" name="tenant_id" value="<?=isset($tenant_info['id']) ? $tenant_info['id']:'0' ; ?>" />
		    <button  type="submit" class="btn btn-primary btn-block">Login</button>
		  </div>
		</form>