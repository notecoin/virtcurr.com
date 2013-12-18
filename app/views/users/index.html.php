<br>
<?php
if($company['Active']==false){
?>
<p class="alert alert-danger" style="font-size:16px;font-weight:bold;text-align:center ">
The status of <?=$company['CompanyName']?> is still <strong>INACTIVE</strong>!
</p>
<?php
	if($user['subname']==$company['subname']){
?>
<p class="alert alert-success" style="font-size:16px;font-weight:bold;text-align:center ">
	Please click on <a href="<?=BASE_SECURE?><?=$company['subname']?>.<?=TL_DOMAIN?>/users/settings">settings</a> to upload all information for us to verify! Once the verification is complete we shall make the company <strong>ACTIVE</strong>
	</p>
<?php
	}
}
?>
