<?php
use app\models\Settings;
$trades = Settings::find('first',array(
	'conditions'=>array('subname'=>SUBDOMAIN)
));
$sel_curr = $this->_request->params['args'][0];
if($this->_request->params['controller']!='api'){
?>
<br>
<!-- <h4><?php if($sel_curr==""){echo $t('Dashboard');}else{echo strtoupper(str_replace("_","/",$sel_curr));}?></h4> -->
<ul class="nav nav-tabs push-right">
	<?php if(!stristr($_SERVER['REQUEST_URI'],"Admin")){	?>
	<li <?php if($sel_curr==""){echo "class='active'";}?>>
		<a href="<?=BASE_HOST?>/<?=LOCALE?>/ex/dashboard/" style="cursor:pointer"><?=$t('Dashboard')?></a>
	</li>
		<?php foreach($trades['trades'] as $tr){
			if($tr['active']==true){
		?>
			<li <?php if($sel_curr==strtolower(str_replace("/","_",$tr['trade']))){echo "class='active'";}?>>
			<a href="<?=BASE_HOST?>/<?=LOCALE?>/ex/x/<?=strtolower(str_replace("/","_",$tr['trade']))?>" class="tooltip-x" rel="tooltip-x" data-placement="top" title="<?=$tr['trade']?>">
			<img src="/img/Currencies/<?=$tr['First']?>.png" alt="<?=strtoupper(substr($tr['trade'],0,3))?>">&raquo;<img src="/img/Currencies/<?=$tr['Second']?>.png" alt="<?=strtoupper(substr($tr['trade'],4,3))?>">
			</a></li>
		<?php 
			}
		}	?>
	<?php }else{?>
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/index" ><?=$t("Summary")?></a></li>
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/pages" ><?=$t("Pages")?></a></li>		
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/commission" ><?=$t("Commission")?></a></li>		
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/approval"><?=$t("Approval")?></a></li>		
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/transactions"><?=$t("Deposits")?></a></li>				
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/withdrawals"><?=$t("Withdrawals")?></a></li>						
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/user"><?=$t("User")?></a></li>								
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/bitcointransaction"><?=$t("BTC")?></a></li>										
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/litecointransaction"><?=$t("LTC")?></a></li>												
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/orders"><?=$t("Orders")?></a></li>												
		<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/api"><?=$t("API")?></a></li>														
	<?php }	?>	
</ul>
<?php }	?>	