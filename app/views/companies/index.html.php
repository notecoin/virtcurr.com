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
					<li><a href="<?=BASE_SECURE?><?=DOMAIN?>/<?=LOCALE?>">VirtCurr.com</a></li>
					<li>IP: <?=$IP?></li>
					<li><a href="<?=BASE_SECURE?><?=$MyCountry['ISO']?>.<?=DOMAIN?>/<?=LOCALE?>/Companies"><?=$MyCountry['ISO']?> (<?=$MyCountry['CurrencyCode']?> - <?=$MyCountry['CurrencyName']?>)</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>