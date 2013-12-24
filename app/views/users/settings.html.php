<?php use lithium\core\Environment; 
if(substr(Environment::get('locale'),0,2)=="en"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<?php
use li3_qrcode\extensions\action\QRcode;
?>
<br>
<h4>Settings: 
<?php
	if($user['subname']==$company['subname'] && $user['admin']==true){
		echo $company['CompanyName'];
	}else{
		echo $user['firstname']." ".$user['lastname'];
	}
?>
</h4>

<div class="panel-group" id="accordion">
<?php
	if($user['subname']==$company['subname'] && $user['admin']==true){

	?>
<!--------- Company ----------->

  <div class="panel panel-default">
    <div class="panel-heading"  style="background-color:#D5E2C5">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseCompany">
					<strong><?=$company['CompanyName']?></strong>
        </a>
      </h4>
    </div>
    <div id="collapseCompany" class="panel-collapse <?php if($option=="company"){?><?php }else{?>collapse<?php }?>">
      <div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<!--Friends-->
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title">Friends</h3>
						</div>
						<div class="panel-body">
								<?=$this->form->create("",array('url'=>'/company/friends/')); ?>
								<table class="table table-condensed">
									<thead>
										<tr>
											<td>Name</td>
											<td>Allow</td>
											<td>Description</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Allow
											</td>
											<td><input type="checkbox" name="allow" id="allow" class="form-control" <?php if($settings['friends']['allow']){echo " checked ";}?>>
											</td>
											<td>Allowing friends will enable users to select friends from the list of completed orders, they will receive emails, when friends post a new order. Interaction with Facebook feature.</td>
										</tr>
									</tbody>
								</table>
								<input type="submit" value="Save friends" class="btn btn-primary">
								</form>
						</div>
					</div>
					<!--Friends-->
					</div>
			</div>				
			<hr>
			<div class="row">
				<div class="col-md-6">
					<!--Commissions-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Commissions</h3>
						</div>
						<div class="panel-body">
								<?=$this->form->create("",array('url'=>'/company/commissions/')); ?>
								<table class="table table-condensed">
									<thead>
										<tr>
											<td># Trades</td>
											<td>Percent</td>
										</tr>
									</thead>
									<tbody>
								<?php $i = 0;foreach($settings['commissions'] as $sc){
									if($sc['transact']){
								?>
										<tr>
											<td># of trades <?=$sc['transact']?>
											<input type="hidden" name="transact[<?=$i?>]" id="transact[<?=$i?>]" value="<?=$sc['transact']?>">
											</td>
											<td><input type="text" class="form-control" name="percent[<?=$i?>]" id="percent[<?=$i?>]" placeholder="percent[<?=$i?>]" value="<?=$sc['percent']?>">
											
											</td>
										</tr>
								<?php	}else{?>
									<input type="hidden" name="base" id="base" value="<?=$sc['base']?>">
								<?php
									}
									$i++;
								} ?>
									</tbody>
								</table>
								<input type="submit" value="Save commissions" class="btn btn-primary">
								</form>
						</div>
					</div>
					<!--Commissions-->
					</div>
					<div class="col-md-6">
					<!--Trades-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Trade pairs</h3>
						</div>
						<div class="panel-body">
								<?=$this->form->create("",array('url'=>'/company/trades/')); ?>
								<table class="table table-condensed">
									<thead>
										<tr>
											<td>Trade pair</td>
											<td>Actives</td>
										</tr>
									</thead>
									<tbody>
								<?php $i = 0;foreach($settings['trades'] as $sc){?>
										<tr>
											<td><?=$sc['trade']?> (<?=$sc['First']?>/<?=$sc['Second']?>)
											<input type="hidden" name="trade[<?=$i?>]" id="trade[<?=$i?>]" value="<?=$sc['trade']?>">
											<input type="hidden" name="refresh[<?=$i?>]" id="refresh[<?=$i?>]" value="<?=$sc['refresh']?>">						
											<input type="hidden" name="First[<?=$i?>]" id="First[<?=$i?>]" value="<?=$sc['First']?>">						
											<input type="hidden" name="Second[<?=$i?>]" id="Second[<?=$i?>]" value="<?=$sc['Second']?>">
											</td>
											<td><input type="checkbox" name="active[<?=$i?>]" id="active[<?=$i?>]" class="form-control" <?php if($sc['active']){echo " checked ";}?>>
											</td>
										</tr>
								<?php	$i++;} ?>
									</tbody>
								</table>
								<input type="submit" value="Save trades" class="btn btn-primary">
								</form>
						</div>
					</div>
					<!--Trades-->
					</div>
			</div>				
			<hr>
			<div class="row">
				<div class="col-md-6">
					<!--txFees-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Transaction Fees</h3>
						</div>
						<div class="panel-body">
								<?=$this->form->create("",array('url'=>'/company/txfees/')); ?>
								<table class="table table-condensed">
									<thead>
										<tr>
											<td>Currency</td>
											<td>Fees</td>
										</tr>
									</thead>
									<tbody>
								<?php $i = 0;foreach($settings['txfees'] as $sc){?>
										<tr>
											<td><?=$sc['name']?>
											<input type="hidden" name="name[<?=$i?>]" id="name[<?=$i?>]" value="<?=$sc['name']?>">
											</td>
											<td><input type="text" class="form-control" name="fee[<?=$i?>]" id="fee[<?=$i?>]" placeholder="0.0001" value="<?=$sc['fee']?>"></td>
										</tr>
								<?php	$i++;} ?>
									</tbody>
								</table>
								<input type="submit" value="Save transaction fees" class="btn btn-primary">
								</form>
						</div>
					</div>
					<!--txFees-->
				</div>
				<div class="col-md-6">
					
					<!--Documents Required-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Documents Required</h3>
						</div>
						<div class="panel-body">
								<?=$this->form->create("",array('url'=>'/company/documents/')); ?>
								<table class="table table-condensed">
									<thead>
										<tr>
											<td>Name</td>
											<td>Required</td>
											<td>Alias</td>
										</tr>
									</thead>
									<tbody>
								<?php $i = 0;foreach($settings['documents'] as $sc){?>
										<tr>
											<td><?=$sc['name']?>
											<input type="hidden" name="name[<?=$i?>]" id="name[<?=$i?>]" value="<?=$sc['name']?>">
											<input type="hidden" name="id[<?=$i?>]" id="id[<?=$i?>]" value="<?=$sc['id']?>">						
											</td>
											<td><input type="checkbox" name="required[<?=$i?>]" id="required[<?=$i?>]" class="form-control" <?php if($sc['required']){echo " checked ";}?>></td>
											<td><input type="text" class="form-control" name="alias[<?=$i?>]" id="alias[<?=$i?>]" placeholder="alias" value="<?=$sc['alias']?>"></td>
										</tr>
								<?php	$i++;} ?>
									</tbody>
								</table>
								<input type="submit" value="Save documents required" class="btn btn-primary">
								</form>
						</div>
					</div>
					<!--Documents Required-->
					</div>
				</div>
				<hr>
			<div class="row">
				<div class="col-md-6">
					<!--Limits-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Deposit / Withdrawal Limits</h3>
						</div>
						<div class="panel-body">
								<?=$this->form->create("",array('url'=>'/company/limits/')); ?>
								<table class="table table-condensed">
									<thead>
										<tr>
											<td>Currency</td>
											<td>Deposit</td>
											<td>Withdrawal</td>
											<td>Allow</td>											
										</tr>
									</thead>
									<tbody>
								<?php $i = 0;foreach($settings['limits'] as $sc){?>
										<tr>
											<td><?=$sc['name']?>
											<input type="hidden" name="name[<?=$i?>]" id="name[<?=$i?>]" value="<?=$sc['name']?>"></td>
											<td><input type="text" name="deposit[<?=$i?>]" id="deposit[<?=$i?>]" value="<?=$sc['deposit']?>" class="form-control"></td>
											<td><input type="text" name="withdrawal[<?=$i?>]" id="withdrawal[<?=$i?>]" value="<?=$sc['withdrawal']?>" class="form-control"></td>	
											<td><input type="checkbox" name="allow[<?=$i?>]" id="allow[<?=$i?>]" class="form-control" <?php if($sc['allow']){echo " checked ";}?>></td>
											</tr>
								<?php	$i++;} ?>
									</tbody>
								</table>
								<p>Zero (0) - means "No Limit"</p>
								<input type="submit" value="Save limits" class="btn btn-primary">
								</form>
						</div>
					</div>
					<!--Limits-->
					</div>
				<div class="col-md-6">
					<!--Denominations-->
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Denominations</h3>
						</div>
						<div class="panel-body">
								<?=$this->form->create("",array('url'=>'/company/denominations/')); ?>
								<table class="table table-condensed">
									<thead>
										<tr>
											<td>Name</td>
											<td>Value</td>
											<td>Active</td>
										</tr>
									</thead>
									<tbody>
								<?php $i = 0;foreach($settings['denominations'] as $sc){?>
										<tr>
											<td><input type="text" name="name[<?=$i?>]" id="name[<?=$i?>]" value="<?=$sc['name']?>" class="form-control"></td>
											<td><input type="text" name="value[<?=$i?>]" id="value[<?=$i?>]" value="<?=$sc['value']?>" class="form-control"></td>
											<td><input type="checkbox" name="active[<?=$i?>]" id="active[<?=$i?>]" class="form-control" <?php if($sc['active']){echo " checked ";}?>></td>
											</tr>
								<?php	$i++;} ?>
									</tbody>
								</table>
								<input type="submit" value="Save denominations" class="btn btn-primary">
								</form>
						</div>
					</div>
					<!--Denominations-->
					</div>
					<div class="col-md-6">
					</div>
				</div>
      </div>
    </div>
  </div>
<!--------- Company ----------->
<?php }?>

<!--------- Personal ----------->
  <div class="panel panel-default">
    <div class="panel-heading"  style="background-color:#D5E2C5">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePersonal">
					Personal Details
        </a>
      </h4>
    </div>
    <div id="collapsePersonal" class="panel-collapse <?php if($option=="personal"){?><?php }else{?>collapse<?php }?>">
      <div class="panel-body">
				<h3>Personal Details</h3>
		<p>Your personal details are used for signing in to <?=COMPANY_URL?> and accessing your account. </p>
		<table class="table">
			<tr>
				<td>Name:</td>
				<td><?=$user['firstname']?> <?=$user['lastname']?></td>
			</tr>
			<tr>
				<td>Username:</td>
				<td><?=$user['username']?></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><?=$user['email']?> <?php 
					if($details['email']['verified']=='Yes'){
						echo '<a href="#" class="label label-success">Verified</a>';
						}else{
						echo '<a href="/'.$locale.'/users/email"  class="label label-important">Verify</a>';
						}?></td>
			</tr>
			<tr>
				<td>Password change:</td>
				<td>
					<?=$this->form->create("",array('url'=>'/users/password/','class'=>'col-md-4')); ?>
					<?=$this->form->field('oldpassword', array('type' => 'password', 'label'=>'Old Password','placeholder'=>'Password','class'=>'form-control')); ?>					
					<?=$this->form->field('password', array('type' => 'password', 'label'=>'New Password','placeholder'=>'Password','class'=>'form-control' )); ?>
					<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Repeat new password','placeholder'=>'same as above','class'=>'form-control' )); ?>
					<?=$this->form->hidden('key', array('value'=>$details['key']))?><br>
					<?=$this->form->submit('Change' ,array('class'=>'btn btn-primary')); ?>					
					<?=$this->form->end(); ?>
				</td>
			</tr>
			<?php
				if($details['email']['verified']=='Yes'){
			?>
			<tr>
				<td>Mobile:</td>
				<td>
				<?=$this->form->create("",array('url'=>'/users/mobile/','class'=>'col-md-4')); ?>
				<input type="text" name="mobile" id="mobile" placeholder="+44 12323894" value="<?=$details['mobile']['number']?>" class="form-control"><br>
					<?=$this->form->submit('Save' ,array('class'=>'btn btn-primary')); ?>									
				<?php 
					if($details['mobile']['verified']=='' || $details['mobile']['verified']=='No'){
						echo "<span  class='label label-important'>Not Verified</span>";
						}else{
						echo "<span  class='label label-success'>Verified</span>";						
					}?>
				</form>	
					</td>
			</tr>
			<?php }?>
<!--
			<tr>
				<td>Bitcoin Adresses: <br>
				<td>
				<?php 
					$qrcode = new QRcode();
				foreach($details['bitcoinaddress'] as $a){
						$qrcode->png($a, QR_OUTPUT_DIR.$a.'.png', 'H', 7, 2);
						echo $a;
						echo " <img src='".QR_OUTPUT_RELATIVE_DIR.$a.".png'>";
				}
				?>
				</td>
			</tr>
-->			
		</table>

      </div>
    </div>
  </div>
<!--------- Personal ----------->
<!--------- Bank ----------->
  <div class="panel panel-default">
    <div class="panel-heading"  style="background-color:#D5E2C5">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseBank">
					Financial Details
        </a>
      </h4>
    </div>
    <div id="collapseBank" class="panel-collapse <?php if($option=="bankhome"){?><?php }else{?>collapse<?php }?>">
      <div class="panel-body">
				<h3>Financial Details</h3>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Add / Edit Bank</h3>
						</div>
						<div class="panel-body">
				
				<a href="/<?=$locale?>/users/addbank">Add/Edit bank details</a>
				<table class="table">
					<tr>
						<td>Account name:</td>
						<td><?=$details['finance']['bank']['accountname']?></td>
					</tr>
					<tr>
						<td>Sort Code:</td>
						<td><?=$details['finance']['bank']['sortcode']?></td>
					</tr>
					<tr>
						<td>Account number:</td>
						<td><?=$details['finance']['bank']['accountnumber']?></td>
					</tr>
					<tr>
						<td>Bank name:</td>
						<td><?=$details['finance']['bank']['bankname']?></td>
					</tr>
					<tr>
						<td>Branch address:</td>
						<td><?=$details['finance']['bank']['branchaddress']?></td>
					</tr>
					<tr>
						<td>NEFT/RTGS/IFSC:</td>
						<td><?=$details['finance']['bank']['ifsc']?></td>
					</tr>
					<tr>
						<td>Verified:</td>
						<td><?=$details['finance']['bank']['verified']?>
						<?php 
							if($details['finance']['bank']['verified']=='Yes'){
								echo '<a href="#" class="label label-success">Verified</a>';
								}else{
								echo '<a href="/users/funding_fiat"  class="label label-important">Funding Fiat</a>';
								}?>
						</td>
					</tr>
				</table>
				</div></div>
				</div>
				<div class="col-md-6">

				<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Add/Edit Postal Address</h3>
						</div>
						<div class="panel-body">
				<a href="/<?=$locale?>/users/addpostal">Add/Edit Postal address</a>
				<table class="table">
					<tr>
						<td>Name:</td>
						<td><?=$details['finance']['address']['Name']?></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><?=$details['finance']['address']['Address']?></td>
					</tr>
					<tr>
						<td>Street:</td>
						<td><?=$details['finance']['address']['Street']?></td>
					</tr>
					<tr>
						<td>City:</td>
						<td><?=$details['finance']['address']['City']?></td>
					</tr>
					<tr>
						<td>Postal / Zip Code:</td>
						<td><?=$details['finance']['address']['Zip']?></td>
					</tr>
					<tr>
						<td>State:</td>
						<td><?=$details['finance']['address']['State']?></td>
					</tr>
					<tr>
						<td>Country:</td>
						<td><?=$details['finance']['address']['Country']?></td>
					</tr>
				</table>
				</div></div>
					</div>
      	</div>
    	</div>
		</div>
  </div>
<!--------- Bank ----------->
<?php
foreach ($settings['documents'] as $document){
	if($document['required']){
?>
  <div class="panel panel-default">
    <div class="panel-heading"  style="background-color:#D5E2C5">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$document['id']?>">
					<?=$document['name']?> - <?=$document['alias']?>
        </a>
      </h4>
    </div>
    <div id="collapse<?=$document['id']?>" class="panel-collapse <?php if($option==$document['id']){?><?php }else{?>collapse<?php }?>">
      <div class="panel-body">
				<h3><?=$document['name']?> - <?=$document['alias']?></h3>
						<p>Upload a JPG file with a maximum size of 1MB.</p>
						<?=$this->form->create(null, array('type' => 'file')); ?>
						<?=$this->form->field('file', array('type' => 'file','label'=>'')); ?><br>
						<?=$this->form->field('option',array('type'=>'hidden','value'=>$document['id'])); ?>												
						<?=$this->form->submit('Save',array('class'=>'btn btn-primary')); ?>
						<?=$this->form->end(); ?>
							<?php if($details[$document['id'].'.verified']=="No"){?>
							<p class="label label-warning">Waiting for approval</p>
							<?php	}else{?>
							<p class="label label-success">Approved</p>
							<p>If you upload another image, your current image will be deleted and your status will become "Waiting for approval".</p>
							<?php }?>
						<?php	
						$filename = "imagename_".$document['id'];
						if($$filename!=""){?>
							<img src="/documents/<?=$$filename?>" width="300px" style="padding:1px;border:1px solid black ">					
						<?php }?>						
      </div>
    </div>
  </div>
<?php }
}?>

<!--------- Security ----------->
  <div class="panel panel-default">
    <div class="panel-heading"  style="background-color:#D5E2C5">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSecurity">
					Security
        </a>
      </h4>
    </div>
    <div id="collapseSecurity" class="panel-collapse <?php if($option=="security"){?><?php }else{?>collapse<?php }?>">
      <div class="panel-body">
				<h3>Security</h3>
		<?php 
		if($details['TOTP.Security']==false || $details['TOTP.Security']==""){?>
		<table class="table">
			<tr>
				<td colspan="2">
					Security keys are used for withdrawals and deposits to your account with <?=COMPANY_URL?>. <br>
					Download / Install the app from <a href="http://code.google.com/p/google-authenticator/" target="_blank">Google Authenticator</a><br>
					Scan the QR code and enter a (Time based One Time Password) to enable security on withdrawals / deposits and password recovery.
					<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Best practice</strong> is to select all Login, Withdrawals/Deposits and Security for TOTP.
					</div>
				</td>
			</tr>
			<tr>
				<td>

		<div class="control-group">
			<div class="controls">
					<strong>Use TOTP for</strong>:<br>
				<label class="checkbox">
				<input type="checkbox" name="Login" id="Login" checked=true> Login
				</label>
				<label class="checkbox">
				<input type="checkbox" name="Withdrawal" id="Withdrawal" checked=true> Withdrawal / Deposits
				</label>
				<label class="checkbox">
				<input type="checkbox" name="Security" id="Security" checked=true> Security
				</label>
			</div>				
		</div>	
		<div class="control-group">
			<label class="control-label" for="ScannedCode">Scanned code</label>
			<div class="controls">
				<input type="text" id="ScannedCode" name="ScannedCode" placeholder="123456" class="span1"  maxlength="6">
			</div><br>
			<div class="controls">			
				<button type="button" class="btn btn-primary" onClick="return SaveTOTP();">Save</button>										
				<button type="button" class="btn btn-danger"  onClick="return DeleteTOTP();">Delete</button>														
			</div>
		</div>

				</td>
				<td>
					<iframe frameborder="0" src="<?=$qrCodeUrl?>" scrolling="no" height="200px"></iframe>
				</td>
			</tr>
			<tr>
				<td>API Key:</td>
				<td><?=$details['key']?></td>
			</tr>
			<tr>
				<td>API Secret:</td>
				<td><?=$details['secret']?></td>
			</tr>
		</table>
		<?php }else{?>
		<table class="table">
			<tr>
				<td colspan="2">
					You have enabled TOTP Security for <?=COMPANY_URL?>. <br>
					Please enter the code below to modify the security level.
					
					<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Warning! </strong> Once you click on the "Check" button with the correct code, you will have to delete your current TOTP from your mobile and rescan the code on the next page.
					</div>
					
				</td>
			</tr>
			<tr>
				<td colspan="2">
				You have enabled:<br>
				Validate: <strong><?=$details['TOTP.Validate']?></strong><br>
				Login: <strong><?=$details['TOTP.Login']?></strong><br>
				Withdrawal / Deposit: <strong><?=$details['TOTP.Withdrawal']?></strong><br>				
				Security: <strong><?=$details['TOTP.Security']?></strong><br>				
				</td>
			</tr>
			<tr>
				<td>
				<?=$this->form->create(null, array('class'=>'form-horizontal')); ?>
				<div class="control-group">
					<label class="control-label" for="CheckCode">Scanned code</label>
					<div class="controls">
						<input type="text" id="CheckCode" name="CheckCode" placeholder="123456" class="span1" maxlength="6">
					</div><br>
					<div class="controls">			
						<button type="button" class="btn btn-primary" onClick="CheckTOTP();">Reset TOTP</button>										
					</div>
				</div>

				<?=$this->form->end(); ?>
				</td>
		</table>
		<?php	}?>
      </div>
    </div>
  </div>
<!--------- Security ----------->	
<!--------- Delete ----------->
<!--
  <div class="panel panel-default">
    <div class="panel-heading"  style="background-color:#D5E2C5">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseDelete">
					Delete Account
        </a>
      </h4>
    </div>
    <div id="collapseDelete" class="panel-collapse <?php if($option=="delete"){?><?php }else{?>collapse<?php }?>">
      <div class="panel-body">
				<h3>Delete Account</h3>
		<?=$this->form->create('',array('url'=>'/users/deleteaccount')); ?>
		<?=$this->form->field('username', array('label'=>'Username','placeholder'=>'username','class'=>'form-control')); ?>
		<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'email','class'=>'form-control')); ?><br>
		<?=$this->form->submit('Delete Account',array('class'=>'btn btn-danger','onclick'=>'return DeleteAccount();')); ?>
		<?=$this->form->end(); ?>
      </div>
    </div>
  </div>
	-->
<!--------- Delete ----------->
</div>
