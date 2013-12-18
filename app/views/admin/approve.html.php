<div class="well" style="text-align:center ">
<img src="/documents/<?=$imagename_utility?>"><br>
<a href="/documents/<?=$imagename_utility?>" target="_blank">Download and view!</a>
<br>
<a href="/Admin/approve/<?=$media?>/<?=$id?>/Approve" class="btn btn-primary">Approve</a>
<a href="/Admin/approve/<?=$media?>/<?=$id?>/Reject" class="btn btn-warning">Reject</a>
<a href="#" onclick="javascript:window.close();" class="btn">Close</a>
<?php
if($media=='address'){
?>
				<table class="table">
					<tr>
						<td>Name:</td>
						<td><?=$details['finance']['address']['Name']?></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><?=$details['finance']['address']['Address']?></td>
					</tr>
					<tr>
						<td>Street:</td>
						<td><?=$details['finance']['address']['Street']?></td>
					</tr>
					<tr>
						<td>City:</td>
						<td><?=$details['finance']['address']['City']?></td>
					</tr>
					<tr>
						<td>Postal / Zip Code:</td>
						<td><?=$details['finance']['address']['Zip']?></td>
					</tr>
					<tr>
						<td>State:</td>
						<td><?=$details['finance']['address']['State']?></td>
					</tr>
					<tr>
						<td>Country:</td>
						<td><?=$details['finance']['address']['Country']?></td>
					</tr>
				</table>
<?php
}
if($media=='bank'){
?>
				<table class="table">
					<tr>
						<td>Account name:</td>
						<td><?=$details['finance']['bank']['accountname']?></td>
					</tr>
					<tr>
						<td>Sort Code:</td>
						<td><?=$details['finance']['bank']['sortcode']?></td>
					</tr>
					<tr>
						<td>Account number:</td>
						<td><?=$details['finance']['bank']['accountnumber']?></td>
					</tr>
					<tr>
						<td>Bank name:</td>
						<td><?=$details['finance']['bank']['bankname']?></td>
					</tr>
					<tr>
						<td>Branch address:</td>
						<td><?=$details['finance']['bank']['branchaddress']?></td>
					</tr>
					<tr>
						<td>NEFT/RTGS/IFSC:</td>
						<td><?=$details['finance']['bank']['ifsc']?></td>
					</tr>
			</table>
<?php
}
?>
</div>