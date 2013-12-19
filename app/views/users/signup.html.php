<br>

<?php $this->form->config(array( 'templates' => array('error' => '<p class="alert alert-danger">{:content}</p>'))); 
?>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Personal Details <i class="glyphicon glyphicon-pencil"></i></h3>
			</div>
			<div class="panel-body">
		<?=$this->form->create($Users, array('role'=>'form','class'=>'form-horizontal','style'=>'padding:10px')); ?>
		<?php if($refer!=""){?>
		<?=$this->form->field('refer', array('label'=>'Refered by bitcoin address','value'=>$refer,'readonly'=>'readonly','class'=>'form-control' )); ?><br>
		<?php }else{?>
		<?=$this->form->field('refer', array('type'=>'hidden','value'=>'')); ?>
		<?=$this->form->field('usercode', array('type'=>'hidden','value'=>gmdate('ymdHis',time()))); ?>		
		<?php }?>
		<?=$this->form->field('subname', array('type'=>'hidden','value'=>SUBDOMAIN)); ?>
		<div class="form-group has-error">
		<?=$this->form->field('firstname', array('label'=>'','placeholder'=>'First Name','class'=>'form-control' )); ?>
		</div>
		<div class="form-group has-error">
		<?=$this->form->field('lastname', array('label'=>'','placeholder'=>'Last Name','class'=>'form-control'  )); ?>
		</div>				<div class="form-group has-error">
		<?=$this->form->field('username', array('label'=>'','placeholder'=>'username' ,'class'=>'form-control' )); ?>
		<p class="label label-danger">Only characters and numbers, NO SPACES</p>
		</div>
		<div class="form-group has-error">
		<?=$this->form->field('email', array('label'=>'','placeholder'=>'name@youremail.com','class'=>'form-control'  )); ?>
		</div>
		<div class="form-group has-error">		
		<?=$this->form->field('password', array('type' => 'password', 'label'=>'','placeholder'=>'Password','class'=>'form-control'  )); ?></div>
		<div class="form-group has-error">
		<?=$this->form->field('password2', array('type' => 'password', 'label'=>'','placeholder'=>'same password as above','class'=>'form-control'  )); ?></div>
		<?php // echo $this->recaptcha->challenge();?>
		<?=$this->form->submit('Sign up' ,array('class'=>'btn btn-primary btn-lg btn-block')); ?>
		<?=$this->form->end(); ?>
		</div>
	</div>
</div>
<?php 
foreach($settings['commissions'] as $key=>$val){
	if($val['base']){$base = $val['base'];}
	if($val['transact']==1){
		$value = (float)$val['percent'] + (float)$base;}
//	break;
}

?>
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Advantages <i class="glyphicon glyphicon-pencil"></i></h3>
			</div>
			<div class="panel-body">
		<h3><?=$companies['CompanyName']?>: <?=$companies['subname']?>.<?=COMPANY_URL?></h3>
		<ul>
			<li>Fees are <strong><?=$value?></strong>% or less per transaction.</li>
			<li>Simple verification means you could be a full customer in a matter of days.</li>
			<li>Security ensured with Cold Storage, SSL 256bit encryption & 2FA.</li>
			<li>Dedicated Server for an enhanced customer experience.</li>
			<li>Deposits & Withdrawals via wire transfers.</li>
			<li>Services only available to UK residents.</li>
			<li>Based and registered within the UK to help build your trust.</li>
		</ul>
	<p>To become IBWT customer and use our platform and services, you must submit the following information:
		<ul>
			<li>Full name.</li>
			<li>Government issued photo identification.</li>
			<li>Proof of address (utility bill, credit statement, or official recognised letter, NOT mobile phone bill).</li>
			For business customers wishing to link a business account, please contact <a href="mailto:support@ibwt.co.uk">support@ibwt.co.uk</a>.
			<li>Bank details for linked bank account, must be in customers own name (account number, sort code, account name).</li>
			<li>Address proof for sending withdrawals.</li>
			<li>Contact telephone number.</li>
			<li>Contact email.</li>
		</ul>
	</p>	
		</div>
	</div>
	</div>
</div>
</div>
