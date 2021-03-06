<?php
use app\models\Countries;
use app\models\Ipaddresses;
use app\models\Companies;
use app\models\Commissions;

$ActiveCountries = Countries::find('all',array(
	'conditions' => array('active'=>true),
	'order'=> array('ISO'=>1)
));
$AvaliableCountries = Countries::find('all',array(
	'conditions' => array('active'=>false),
	'order'=> array('Country'=>1)
));
$IP = $_SERVER['REMOTE_ADDR'];
$ips = explode(".",$IP);
$IP_no =  $ips[3] + $ips[2]*256 + $ips[1]*65536 + $ips[0]*16777216;
$Country = Ipaddresses::find('all',array(
	'conditions'=>array(
		'start_no'=>array('$lte'=>$IP_no), 
		'end_no'=>array('$gte'=>$IP_no)
	),
	'fields'=>array('ISO'),
	'limit'=>1
));

if(count($Country)!=0){
	foreach($Country as $CC){
		$CountryISO = $CC['ISO'];
	}
}

$MyCountry = Countries::find('first',array(
	'conditions'=>array('ISO'=>strtoupper($CountryISO))
));
$commissions = Commissions::find('all');
foreach($commissions as $key=>$val){
	if($val['base']){$base = $val['base'];}
	print_r($base);
	if($val['transact']==1){
		$value = (float)$val['percent'] + (float)$base;}
	break;
}

?>
<?php if( strlen(SUBDOMAIN)==2 || strlen(SUBDOMAIN)==0){?>
<div class="row">
	<div class="col-xs-12 col-md-9" >
		<h3>International Trading Platform</h3>
		<blockquote>We have build a software which can be configured to meet requirements of all country specific virtual currency (bitcoin/litecoin) trading platform.<small>VirtCurr.com</small></blockquote>
		<?php if(SUBDOMAIN!=""){?>
			<?php echo $this->_render('element', 'subdomain',array('SelectedCountry'=>$MyCountry));?>	
		<?php }else{?>
		<h4>VirtCurr.com is a Virtual Currency (Bitcoin / Litecoin) exchange or a trading platform, offering a fully regulated, secure method, for businesses to start their own buy or sell virtual currencies platform.</h4>
		<ul>
				<li>Fees are <strong><?=$value?></strong>% per transaction</li>
				<li>Simple verification means you could be a full customer in a matter of days</li>
				<li>Security ensured with Cold Storage, SSL 256bit encryption & 3FA</li>
				<li>Dedicated Server for an enhanced customer experience</li>
				<li>Deposits & Withdrawals via secure mail services.</li>
		</ul>
		<h3>About Bitcoin</h3>
		<ul>
			<li><a href="http://www.coindesk.com/information/" target="_blank">Information from Coindesk</a></li>
			<li><a href="http://bitcoin.org/en/" target="_blank">Bitcoin Organization</a></li>
			<li><a href="https://en.bitcoin.it/wiki/Main_Page" target="_blank">Bitcoin Wiki</a></li>
		</ul>
		<h3>Security</h3>
		<ul>
			<li>We use <strong>Three Factor Authentication</strong> for your account to login to <?=COMPANY_URL?>.</li>
			<li>We use <strong>Time-based One-time Password Algorithm (TOTP)</strong> for login, withdrawal/deposits and settings.</li>
		</ul>
		<?php }?>
	</div>
	<div class="col-xs-7 col-md-3" style="min-height:580px;overflow:auto;height:580px;margin-top:20px">

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
	
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Active Countries</h3>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<?php foreach($ActiveCountries as $AC){?>
					<li><a href="<?=BASE_SECURE?><?=$AC['ISO']?>.<?=TL_DOMAIN?>/<?=LOCALE?>/Companies"><?=$AC['Country']?> (<?=$AC['CurrencyCode']?> - <small><?=$AC['CurrencyName']?></small>)</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Available Countries</h3>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<?php foreach($AvaliableCountries as $AC){?>
					<li><a href="<?=BASE_SECURE?><?=$AC['ISO']?>.<?=TL_DOMAIN?>/<?=LOCALE?>/Companies"><?=$AC['Country']?> (<?=$AC['CurrencyCode']?> - <small><?=$AC['CurrencyName']?></small>)</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php }else{?>
<div class="row">
	<div class="col-xs-12 col-md-9" >
	<h2><?=SUBDOMAIN?></h2>	
	</div>
</div>
<?php }?>