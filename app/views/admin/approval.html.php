<br>
<h3>User Approval</h3>
<form name="User_Approval" method="post" action="/Admin/approval" class="form-vertical">
<div class="row">
<div class="col-md-3">
	<select name="UserApproval" id="UserApproval" class="form-control">
		<option value="All" <?php if($UserApproval=='All'){echo " selected";}?>>All</option>
		<optgroup label="Verified">		
		<option value="VEmail" <?php if($UserApproval=='VEmail'){echo " selected";}?>>Email</option>
		<option value="VPhone" <?php if($UserApproval=='VPhone'){echo " selected";}?>>Mobile/Phone</option>		
<?php foreach($settings['documents'] as $sc)		{?>
		<option value="V<?=$sc['id']?>" <?php if($UserApproval=='V'.$sc['id']){echo " selected";}?>><?=$sc['name']?></option>				
<?php }?>
		</optgroup>
		<optgroup label="Not Verified">		
		<option value="NVEmail" <?php if($UserApproval=='NVEmail'){echo " selected";}?>>Email</option>
		<option value="NVPhone" <?php if($UserApproval=='NVPhone'){echo " selected";}?>>Mobile/Phone</option>		

<?php foreach($settings['documents'] as $sc)		{?>
		<option value="NV<?=$sc['id']?>" <?php if($UserApproval=='NV'.$sc['id']){echo " selected";}?>><?=$sc['name']?></option>				
<?php }?>
		</optgroup>
		<optgroup label="Waiting Verification">		
		<option value="WVEmail" <?php if($UserApproval=='WVEmail'){echo " selected";}?>>Email</option>
		<option value="WVPhone" <?php if($UserApproval=='WVPhone'){echo " selected";}?>>Mobile/Phone</option>		
<?php foreach($settings['documents'] as $sc)		{?>
		<option value="WV<?=$sc['id']?>" <?php if($UserApproval=='WV'.$sc['id']){echo " selected";}?>><?=$sc['name']?></option>				
<?php }?>
		</optgroup>
	</select>
</div>

<div class="col-md-3">
		<input type="text" name="UserSearch" id="UserSearch" placeholder="Username" value="" class="form-control">
</div>
<div class="col-md-3">
		<input type="text" name="EmailSearch" id="EmailSearch" placeholder="Email" value="" class="form-control">		
</div>
<div class="col-md-3">		
	<input type="submit" value="Go..." class="btn btn-primary ">
</div>
</form>
</div>
<div class="row">
<div class="col-md-12">
<table class="table table-condensed table-bordered table-hover" style=" ">
	<tr>
		<th width="16%" style="text-align:center;"><?=$t("Username")?></th>
		<th width="16%" style="text-align:center "><?=$t("Email")?></th>
		<th width="16%" style="text-align:center "><?=$t("Mobile")?></th>
<?php foreach($settings['documents'] as $documents){
				if($documents['required']==true){?>
		<th width="16%" style="text-align:center "><?=$documents["name"]?></th>		
<?php }
}?>	</tr>
<?php 
if(count($details)!=0){
$i = 1;
	foreach($details as $detail){
?>
	<tr>
		<td><?=$i?> <a href="/Admin/detail/<?=$detail['username']?>" target="_blank"><?=$detail['username']?></a></td>
		<td style="text-align:center "><?=$detail['email.verified']?></td>		
		<td style="text-align:center "><?=$detail['phone.verified']?></td>				
<?php foreach($settings['documents'] as $documents){
				if($documents['required']==true){?>
		<td style="text-align:center "><a href="/Admin/approve/<?=$documents['id']?>/<?=$detail['_id']?>" target="_blank"><?=$detail[$documents["id"].'.verified']?></a></td>
<?php }
}?>
	</tr>

<?php $i++;	}

} ?>
</table>
</div>
</div>
