<br>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Add / Edit Postal Details</h3>
	</div>
	<div class="panel-body">

<p><?=$t("This address will be used to verify your details or cheque sent by mail.")?></p>
<div class="row-fluid">
	<div class="col-md-12">
<?php
foreach($details as  $d){
?>
<?=$this->form->create('',array('url'=>'/users/addpostaldetails','class'=>'col-md-6')); ?>
<?=$this->form->field('Name', array('label'=>'1. Name','placeholder'=>'Name','value'=>$d['finance']['address']['Name'],'class'=>'form-control')); ?>
<?=$this->form->field('Address', array('label'=>'2. Address','placeholder'=>'Address','value'=>$d['finance']['address']['Address'],'class'=>'form-control' )); ?>
<?=$this->form->field('Street', array('label'=>'3. Street','placeholder'=>'Street','value'=>$d['finance']['address']['Street'],'class'=>'form-control' )); ?>
<?=$this->form->field('City', array('label'=>'4. City','placeholder'=>'City','value'=>$d['finance']['address']['City'],'class'=>'form-control' )); ?>
<?=$this->form->field('Zip', array('label'=>'5. Postal / Zip Code','placeholder'=>'Zip Code','value'=>$d['finance']['address']['Zip'],'class'=>'form-control' )); ?>
<?=$this->form->field('State', array('label'=>'5. State','placeholder'=>'State','value'=>$d['finance']['address']['State'],'class'=>'form-control' )); ?>
<?=$this->form->field('Country', array('label'=>'6. Country','placeholder'=>'Country','value'=>$d['finance']['address']['Country'],'class'=>'form-control' )); ?><br>
<?=$this->form->submit('Save Address',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<?php }?>
	</div>
</div>
	</div>
</div>
