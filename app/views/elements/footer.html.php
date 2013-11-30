<?php
use app\models\Templates;
$templates = Templates::find('all');
?>
<div id="footer" style="padding:1px 20px; margin-top:20px;border-top:1px solid gray;">
	<div class="container">
		<ul class="nav navbar-nav" style="font-size:12px ">
			<li><a href="#">&copy; VirtCurr 2013</a></li>
			<?php 
			foreach($templates as $tt){
				if($tt['name']!='tagline'){
			?>
				<li><a href="<?=BASE_HOST?>/<?=LOCALE?>/companies/page/<?=$tt['name']?>"><?=$tt['name']?></a></li>
			<?php	
				}
			}?>
		</ul>
	</div>
</div>
<div class="container">
	<p class="nav" style="font-size:11px;border-top:1px solid black ">
		<?=$t("VirtCurr is a virtual currency trading software developed by ")?><strong>First CyberKing Network Co. Ltd.</strong>. <?=$t("Registered in Mauritius.")?> 
		<?=$t("Registered office: FairFax House, 21 Mgr Gonin Street, Port Louis, Mauritius")?>
	</p>
</div>