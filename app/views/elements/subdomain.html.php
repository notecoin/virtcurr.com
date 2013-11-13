<?php
use app\models\Companies;
		$Companies = Companies::find('all',array(
			'conditions'=>array('CompanyISO'=>strtoupper(SUBDOMAIN))
		));
//print_r($Companies);
?>
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">Registered Companies in <?=$SelectedCountry['Country']?> 
		<img src="/img/Flags/<?=strtolower($SelectedCountry['ISO'])?>.gif" height="24px">
		</h3>
	</div>
	<div class="panel-body">
		<?php if(count($Companies)==0){?>
		<h3>There are no companies registered in <?=$SelectedCountry['Country']?>.</h3>
		<p>If you would like to register a company which will be allowed to do virtual currency trading by your country laws and are willing to submit the documents for verification, then <a href="<?=BASE_SECURE?><?=strtolower($SelectedCountry['ISO'])?>.<?=TL_DOMAIN?>/Companies/register" class="label label-primary">Register</a>.</p>
		<ul>
			<li>Company Name, Registered Address, Registration No. </li>
			<li>Name, Email, Mobile number</li>
			<li>Persons responsible in company for customer verifications (contact page)</li>
		</ul>
		<p>You should be able to submit these documents too, we create these documents with site links on virtcurr.com</p>
		<ul>
			<li>Risk Management</li>
			<li>Verification Process</li>
			<li>Privacy Policy</li>
			<li>Terms of Service</li>
			<li>Legal</li>
			<li>FAQ</li>
			<li>Funding methods</li>
			<li>Government Approvals</li>
		</ul>
		<?php }else{?>
		<h4>Companies</h4>
		
		<table class="table table-bordered table-striped table-hover table-condensed">
			<tr>
				<th>Name</th>
				<th>Domain URL</th>
				<th colspan="3">Actions</th>
			</tr>
			<?php
			foreach ($Companies as $cc){?>
			<tr>
				<td><?=$cc['CompanyName']?></td>
				<td><a href="<?=BASE_SECURE?><?=$cc['subname']?>.<?=TL_DOMAIN?>"><?=$cc['subname']?>.<?=COMPANY_URL?></a></td>				
				<td><a href="<?=BASE_SECURE?><?=$cc['subname']?>.<?=TL_DOMAIN?>/companies/signin" class="btn btn-primary btn-sm">Sign in</a></td>
				<td><a href="<?=BASE_SECURE?><?=$cc['subname']?>.<?=TL_DOMAIN?>/companies/signup" class="btn btn-success btn-sm">Sign up</a></td>
				<td><a href="<?=BASE_SECURE?><?=$cc['subname']?>.<?=TL_DOMAIN?>/companies/admin" class="btn btn-danger btn-sm">Admin</a></td>
			</tr>
			<?php }?>
		</table>
		<p>If you would like to register a company which will be allowed to do virtual currency trading by your country laws and are willing to submit the documents for verification, then <a href="<?=BASE_SECURE?><?=$cc['subname']?>.<?=TL_DOMAIN?>/Companies/register" class="label label-primary">Register</a>.</p>
		<?php }?>
	</div>
</div>
