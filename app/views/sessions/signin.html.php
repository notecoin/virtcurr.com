<div style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat"><br>

<p class="alert alert-danger" style="font-size:16px;font-weight:bold;text-align:center ">
#### Recent Note ####<br>
<?=$Note?>
</p>
<div class="row">
	<div class="col-md-4">
	<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Sign In</h3>
			</div>
			<div class="panel-body">
			<?=$this->form->create(null,array('role'=>'form','class'=>'form-horizontal','style'=>'padding:10px')); ?>
			
			<div class="form-group has-error">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-asterisk" id="UserNameIcon"></i>
<!--						<i class="glyphicon glyphicon-ok"></i>						
						<i class="glyphicon glyphicon-phone"></i>						
						<i class="glyphicon glyphicon-envelope"></i>												
						<i class="glyphicon glyphicon-remove"></i>												
-->
					</span>
				<?=$this->form->field('username', array('label'=>'', 'class'=>'form-control','onBlur'=>'SendPassword();', 'placeholder'=>'username','value'=>$username)); ?>
				</div>
			</div>
				
			<div class="form-group has-error">			
				<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-asterisk"></i>
					</span>
				<?=$this->form->field('password', array('type' => 'password', 'label'=>'', 'class'=>'form-control','placeholder'=>'password')); ?>
				</div>
			</div>				

			<div class="form-group has-error"  style="display:none" id="LoginEmailPassword">
				<div class="alert alert-danger">
					<small>Please check your registered email in 5 seconds. You will receive "<strong>Login Email Password</strong>" use it in the box below.</small>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-envelope"></i>
						</span>
					<?=$this->form->field('loginpassword', array('type' => 'password', 'label'=>'','class'=>'form-control','maxlength'=>'6', 'placeholder'=>'123456')); ?>
					</div>
				</div>
			</div>		
			
			
			<div class="form-group has-error" style="display:none" id="TOTPPassword">
				<div class="alert alert-danger">			
				<small><strong>Time based One Time Password (TOTP) from your smartphone</strong></small>	
					<div class="input-group">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-asterisk"></i>
						</span>
					<?=$this->form->field('totp', array('type' => 'password', 'label'=>'','class'=>'form-control','maxlength'=>'6', 'placeholder'=>'123456')); ?>	
					</div>	
				</div>
			</div>
			
			<?=$this->form->submit('Sign In' ,array('class'=>'btn btn-primary')); ?>
			<?=$this->form->end(); ?>
			<a href="/users/forgotpassword">Forgot password?</a>
			</div>
	</div>
	</div>
	
	<div class="col-md-8">
	<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Sign up / Register</h3>
			</div>
			<div class="panel-body">
		Don't have an account. <a href="/users/signup" class="btn btn-primary">Signup</a><br>
		Please read the <a href="/company/termsofservice">terms of service</a> page before you sign up.<br>
		<h3>Security</h3>
		We use <strong>Two Factor Authentication</strong> for your account to login to <?=COMPANY_URL?>.<br>
		We use <strong>Time-based One-time Password Algorithm (TOTP)</strong> for login, withdrawal/deposits and settings.
		<p><h3>TOTP Project and downloads</h3>
			<ul>
			<li><a href="http://code.google.com/p/google-authenticator/" target="_blank">Google Authenticator</a></li>
			<li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">TOTP Android App</a></li>
			<li><a href="http://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">TOTP iOS App</a></li>
			</ul>
		</p>
	</div>
</div>
</div>
</div>
</div>