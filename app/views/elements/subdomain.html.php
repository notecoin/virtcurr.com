<?php
use app\models\Countries;
use app\models\Companies;
$SubDomainCountry = strtoupper(SUBDOMAIN);
$MySubDomainCountry = Countries::find('first',array(
	'conditions'=>array('ISO'=>$SubDomainCountry)
));
$Companies = Companies::find('all',array(
	'conditions'=>array('ISO'=>$SubDomainCountry)
));
?>
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">Registered Companies in <?=$MySubDomainCountry['Country']?> 
		<img src="/img/Flags/<?=strtolower($MySubDomainCountry['ISO'])?>.gif" height="24px">
		</h3>
	</div>
	<div class="panel-body">
		<?php if(count($Companies)==0){?>
		<h3>There are no companies registered in <?=$MySubDomainCountry['Country']?>.</h3>
		<p>If you would like to register a company which will be allowed to do virtual currency trading by your country laws and are willing to submit the documents for verification, then <a href="Companies/Register" class="label label-primary">Register</a>.</p>
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
		<?php }?>
	</div>
</div>
