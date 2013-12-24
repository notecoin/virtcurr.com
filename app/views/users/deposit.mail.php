<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$compact['user']['firstname']?>,</h4>

<p>You have requested to deposit money to <?=COMPANY_URL?>.</p>
<p><strong>Make SURE you deposit from your verified account ONLY. Money attempted to be sent to any other account will result in the transaction being blocked and investigated.</strong></p>
<p style="color:red ">Please make SURE you write it clearly and INCLUDE with your deposit.</p>
<blockquote>
<strong>Send the payment to:</strong>
<p>Account Name: <?php echo $compact['CompanyBank']['bank']['accountname'];?><br>
Account Number: <?php echo $compact['CompanyBank']['bank']['accountnumber'];?><br>
Bank Name: <?php echo $compact['CompanyBank']['bank']['bankname'];?><br>
Branch Name: <?php echo $compact['CompanyBank']['bank']['branchaddress'];?><br>
IFSC Code: <?php echo $compact['CompanyBank']['bank']['ifsc'];?><br>
Sort Code: <?php echo $compact['CompanyBank']['bank']['sortcode'];?><br>
</blockquote>
<table style="border:2px solid black ">
		<tr>
			<td>Reference:</td>
			<td><strong><?=$compact['data']['Reference']?></strong></td>
		</tr>
		<tr>
			<td>Amount:</td>
			<td><?=$compact['data']['Amount']?></td>
		</tr>
		<tr>
			<td>Currency:</td>
			<td><?=$compact['data']['Currency']?></td>
		</tr>		
</table>
<p></p>
<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=COMPANY_URL?> with the email address. 
If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>