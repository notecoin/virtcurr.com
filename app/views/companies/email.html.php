<br>
<h4>Email verification for new company<small> with virtcurr.com </small></h4>
<div class="row">
	<div class="col-xs-12 col-lg-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Verify now! <i class="glyphicon glyphicon-pencil"></i></h3>
			</div>
			<div class="panel-body">
				<?php echo $msg;?>
				<?=$this->form->create($Companies,array('url'=>'/Companies/confirm/','role'=>'form','class'=>'form-horizontal','style'=>'padding:10px')); ?>
				<div class="form-group has-error">
				<?=$this->form->field('email', array('class'=>'form-control','label'=>'Email','placeholder'=>'name@youremail.com' )); ?>
				</div>
				<div class="form-group has-error">
				<?=$this->form->field('verified', array('class'=>'form-control','type' => 'text', 'label'=>'Verification code','placeholder'=>'50d54d309d5d0c3423000000' )); ?>
				</div>
				<?=$this->form->submit('Verify',array('class'=>'btn btn-primary btn-lg btn-block')); ?>
				<?=$this->form->end(); ?>
				<p>Please check your spam folder too while checking your inbox!</p>
			</div>
		</div>
	</div>
</div>	
