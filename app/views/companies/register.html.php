<br>
<h4>Register a new company<small> with virtcurr.com </small></h4>
<?php
//print_r($Companies);
?>
<?php $this->form->config(array( 'templates' => array('error' => '<p class="alert alert-danger">{:content}</p>'))); 
?>
<div class="row">
	<div class="col-xs-12 col-lg-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Personal / Company Details <i class="glyphicon glyphicon-pencil"></i></h3>
			</div>
			<div class="panel-body">
				<?=$this->form->create($Companies, array('role'=>'form','class'=>'form-horizontal','style'=>'padding:10px')); ?>
				<div class="form-group has-error">
					<?=$this->form->field('subname',array('class'=>'form-control','label'=>'','placeholder'=>'sub-domain name' ));?>
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('firstname', array('class'=>'form-control','label'=>'','placeholder'=>'First Name' )); ?>	
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('lastname', array('class'=>'form-control','label'=>'','placeholder'=>'Last Name' )); ?>	
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('email', array('class'=>'form-control','label'=>'','placeholder'=>'email@domain.com' )); ?>	
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('mobile', array('class'=>'form-control','label'=>'','placeholder'=>'Mobile number for SMS verification' )); ?>	
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('CompanyName', array('class'=>'form-control','label'=>'','placeholder'=>'Company Name' )); ?>	
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('CompanyAddress', array('class'=>'form-control','label'=>'','placeholder'=>'Address' )); ?>
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('CompanyStreet', array('class'=>'form-control','label'=>'','placeholder'=>'Street' )); ?>
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('CompanyCity', array('class'=>'form-control','label'=>'','placeholder'=>'City' )); ?>
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('CompanyZip', array('class'=>'form-control','label'=>'','placeholder'=>'Zip' )); ?>
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('CompanyCountry', array('class'=>'form-control','label'=>'','placeholder'=>'Country','value'=>$SelectedCountry['Country'],'readonly'=>'readonly' )); ?>
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('password', array('type'=>'password','class'=>'form-control','label'=>'','placeholder'=>'Password','value'=>'')); ?>
				</div>
				<div class="form-group has-error">
					<?=$this->form->field('password2', array('type'=>'password','class'=>'form-control','label'=>'','placeholder'=>'same as Password','value'=>'')); ?>
				</div>				
					<?=$this->form->field('CompanyISO',array('type'=>'hidden','value'=>$SelectedCountry['ISO']))?>
		<?=$this->form->submit('Add Company', array('class'=>'btn btn-primary btn-lg btn-block'));?>
		<?=$this->form->end();?>
				</div>
			</div>
		</div>
	
	<div class="col-xs-12 col-sm-6 col-lg-8" >
		<?php if(SUBDOMAIN!=""){?>
		<?php echo $this->_render('element', 'subdomain_register');?>	
		<?php }?>
	</div>
	
</div>
