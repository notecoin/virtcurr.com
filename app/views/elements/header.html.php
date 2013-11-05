<?php
use lithium\storage\Session;
use app\extensions\action\Functions;
?>
<?php $user = Session::read('member'); ?>
<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<a class="brand" href="<?=BASE_HOST?>/<?=LOCALE?>/"><img src="/img/virtcurr.com.gif" alt="virtcurr.com" style="margin-top:10px "></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"></li>
			</ul>
				<ul class="nav navbar-nav navbar-right">
				<?php echo $this->_render('element', 'language');?>
			<?php if($user!=""){ ?>
			<li ><a href='#' class='dropdown-toggle' data-toggle='dropdown' style="background-color:#eeeeee">
			<?=$user['username']?> <i class=' icon-chevron-down'></i>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/users/settings"><?=$t('Settings')?></a></li>			
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/ex/dashboard"><?=$t('Dashboard')?></a></li>
				<li class="divider"></li>				
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/users/funding_btc"><?=$t('Funding BTC')?></a></li>							
				<li class="divider"></li>
				<li><a href="/<?=$locale?>/logout"><?=$t('Logout')?></a></li>
			</ul>
			<?php }else{?>
					<a href="/<?=$locale?>/login" class="btn btn-sm btn-primary" style="margin-top:10px "><?=$t('Login / Register')?></a>			
			<?php }?>				
				</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>