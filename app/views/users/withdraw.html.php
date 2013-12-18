<br>
<h4>Withdraw <?=$data['Currency']?></h4>

<p>You have requested to withdraw money from <?=COMPANY_URL?>.</p>
<p><strong>Thank you, your request has been sent for clearance.</strong></p>
<div class="row">
<div class="col-md-5">
<table class="table table-condensed table-bordered ">
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
</div>
</div>
<p>We will approve the request and send the funds directly to your registered bank. If we are unable to send it directly, we will inform you and send funds to your postal address by cheque.</p>

<a href="/users/funding_btc" class="btn btn-primary">Funding BTC</a>
<a href="/users/funding_ltc" class="btn btn-primary">Funding LTC</a>
<a href="/users/funding_fiat" class="btn btn-primary">Funding Fiat</a>
<a href="/users/transactions" class="btn btn-primary">Transactions</a>