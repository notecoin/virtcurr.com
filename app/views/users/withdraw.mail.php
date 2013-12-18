<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$user['firstname']?>,</h4>

<p>You have requested to withdraw money from <?=COMPANY_URL?>.</p>
<table>
		<tr>
			<td>Reference:</td>
			<td><strong><?=$data['Reference']?></strong></td>
		</tr>
		<tr>
			<td>Amount:</td>
			<td><?=$data['Amount']?></td>
		</tr>
		<tr>
			<td>Currency:</td>
			<td><?=$data['Currency']?></td>
		</tr>		
		<tr>
			<td>Account Name</td>
			<td><?=$details['bank']['accountname'];?></td>
		</tr>
		<tr>
			<td>Account Number</td>
			<td><?=$details['bank']['accountnumber'];?></td>
		</tr>
		<tr>
			<td>Bank Name</td>
			<td><?=$details['bank']['bankname'];?></td>
		</tr>
		<tr>
			<td>Branch Address</td>
			<td><?=$details['bank']['branchaddress'];?></td>
		</tr>
		<tr>
			<td>IFSC</td>
			<td><?=$details['bank']['ifsc'];?></td>
		</tr>
		<tr>
			<td>Sort Code:</td>
			<td><?=$details['bank']['sortcode'];?></td>
		</tr>
</table>
<p>We will approve the request and send the funds directly to your registered bank. If we are unable to send it directly, we will inform you and send funds to your postal address by cheque.</p>

<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=COMPANY_URL?> with the email address. 
If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>