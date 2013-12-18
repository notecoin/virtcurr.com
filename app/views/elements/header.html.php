<?php
use lithium\storage\Session;
use app\extensions\action\Functions;
use app\models\Settings;
use app\models\Details;
$user = Session::read('member');
$settings = Settings::find('first',array(
	'conditions'=>array('subname'=>SUBDOMAIN)
));
$id = $user['_id'];
$details = Details::find('first',
	array('conditions'=>array('user_id'=>$id))
);

?>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if( strlen(SUBDOMAIN)==2 || strlen(SUBDOMAIN)==0){?>
			<a class="brand" href="<?=BASE_HOST?>/<?=LOCALE?>/"><img src="/img/virtcurr.com.gif" alt="virtcurr.com" style="margin-top:10px "></a>
				<?php }else{?>
			<a class="brand" href="<?=BASE_HOST?>/<?=LOCALE?>/"><img src="/img/<?=strtolower(SUBDOMAIN)?>.com.gif" alt="<?=strtolower(SUBDOMAIN)?>.com" style="margin-top:10px "></a>
				<?php }?>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"></li>
			</ul>
				<ul class="nav navbar-nav navbar-right">
				<?php echo $this->_render('element', 'language');?>
			<?php if($user!=""){ ?>
			<li ><a href='#' class='dropdown-toggle' data-toggle='dropdown' style="background-color:#eeeeee">
			<?=$user['username']?> <i class='glyphicon glyphicon-chevron-down'></i>
			</a>
			<ul class="dropdown-menu">
				<?php if($user['admin']==1){?>
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/admin/index"><?=$t('Administor')?></a></li>			
				<?php	}?>
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/users/settings"><?=$t('Settings')?></a></li>			
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/ex/dashboard"><?=$t('Dashboard')?></a></li>
<?php foreach($settings['documents'] as $documents){
				if($documents['required']==true){
					if(strlen($details[$documents['id'].'.verified'])==0){
							$alldocuments[$documents['id']]="No";
					}elseif($details[$documents['id'].'.verified']=='No'){
							$alldocuments[$documents['id']]="Pending";
					}else{
							$alldocuments[$documents['id']]="Yes";						
					}
				}
			}
if($alldocuments['government']=="Yes" && $alldocuments['bank']=="Yes" && $alldocuments['address']=="Yes"){
			?>
				<li class="divider"></li>				
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/users/funding_btc"><?=$t('Funding BTC')?></a></li>							
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/users/funding_ltc"><?=$t('Funding LTC')?></a></li>											
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/users/funding_fiat"><?=$t('Funding Fiat')?></a></li>											
				
<?php }?>				
				<li class="divider"></li>
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/signout"><?=$t('Logout')?></a></li>
			</ul>
			<?php }else{?>
					<a href="<?=BASE_HOST?>/<?=LOCALE?>/signin" class="btn btn-sm btn-primary" style="margin-top:10px "><?=$t('Sign In / Sign Up')?></a>			
			<?php }?>				
				</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>