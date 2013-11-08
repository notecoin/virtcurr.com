<?php 
use app\models\Countries;
use app\models\Ipaddresses;
use app\models\Companies;

$IP = $_SERVER['REMOTE_ADDR'];
$ips = explode(".",$IP);
$IP_no =  $ips[3] + $ips[2]*256 + $ips[1]*65536 + $ips[0]*16777216;
$Country = Ipaddresses::find('all',array(
	'conditions'=>array(
		'start_no'=>array('$lte'=>$IP_no), 
		'end_no'=>array('$gte'=>$IP_no)
	),
	'limit'=>1
));
foreach($Country as $CC){
	$CountryISO = $CC['ISO'];
}
$MyCountry = Countries::find('first',array(
	'conditions'=>array('ISO'=>$CountryISO)
));

?>
<br>
<h4>Companies <small>registered with virtcurr.com </small></h4>
<div class="row">
	<div class="col-xs-12 col-md-9" >
		<?php if(SUBDOMAIN!=""){?>
		<?php echo $this->_render('element', 'subdomain');?>	
		<?php }?>
	</div>

	<div class="col-xs-7 col-md-3" style="min-height:580px;overflow:auto;height:580px;">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Home</h3>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li><a href="<?=BASE_SECURE?><?=TL_DOMAIN?>/<?=LOCALE?>">VirtCurr.com</a></li>
					<li>IP: <?=$IP?></li>
					<li><a href="<?=BASE_SECURE?><?=$MyCountry['ISO']?>.<?=TL_DOMAIN?>/<?=LOCALE?>/Companies"><?=$MyCountry['Country']?> (<?=$MyCountry['CurrencyCode']?> - <?=$MyCountry['CurrencyName']?>)</a></li>
				</ul>
			</div>
		</div>

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Your selection</h3>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<li><a href="<?=BASE_SECURE?><?=TL_DOMAIN?>/<?=LOCALE?>">VirtCurr.com</a></li>
					<li>IP: <?=$IP?></li>
					<li><a href="<?=BASE_SECURE?><?=$SelectedCountry['ISO']?>.<?=TL_DOMAIN?>/<?=LOCALE?>/Companies"><?=$SelectedCountry['Country']?> (<?=$SelectedCountry['CurrencyCode']?> - <?=$SelectedCountry['CurrencyName']?>)</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>