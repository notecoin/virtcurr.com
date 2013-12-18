<br>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Add / Edit Bank</h3>
	</div>
	<div class="panel-body">

<div class="row">
	<div class="col-md-12">
<p><?=$t("This will un-set 'verified' status, you will have to verify the bank again.")?></p>
<?php
foreach($details as  $d){
?>
<?=$this->form->create('',array('url'=>'/users/addbankdetails','class'=>'col-md-6')); ?>
<?=$this->form->field('accountname', array('label'=>'1. Account name','placeholder'=>'Account name','value'=>$d['finance']['bank']['accountname'],'class'=>'form-control')); ?>
<?=$this->form->field('sortcode', array('label'=>'2. Sort code / MICR','placeholder'=>'Sort code','value'=>$d['finance']['bank']['sortcode'],'class'=>'form-control' )); ?>
<?=$this->form->field('accountnumber', array('label'=>'3. Account number','placeholder'=>'Account number','value'=>$d['finance']['bank']['accountnumber'],'class'=>'form-control' )); ?>
<?=$this->form->field('bankname', array('label'=>'4. Bank name','placeholder'=>'Bank name','value'=>$d['finance']['bank']['bankname'] ,'class'=>'form-control')); ?>
<?=$this->form->field('branchaddress', array('label'=>'5. Branch address','placeholder'=>'Branch address','value'=>$d['finance']['bank']['branchaddress'] ,'class'=>'form-control')); ?>
<?=$this->form->field('ifsc', array('label'=>'6. NEFT/RTGS/IFSC','placeholder'=>'IFCS Code','value'=>$d['finance']['bank']['ifsc'] ,'class'=>'form-control')); ?><br>

<?=$this->form->submit('Save bank',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<?php }?>
	</div>
	<div class="col-md-6">
		<p><?=$t("Sample bank cheque for adding bank details.")?></p>
		<img src="/img/Cheque.png" alt="sample bank cheque">	<br>
		<img src="/img/Cheque-1.png" alt="sample bank cheque">			
	</div>
</div>
</div>
</div>