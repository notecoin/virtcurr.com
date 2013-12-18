<br>
<h4>Deposit</h4>
<p>You have requested to deposit money to <?=COMPANY_URL?>.</p>
<p><strong>Make SURE you deposit from your verified account. Money attempted to be sent to any other account will result in the transaction being blocked and investigated.</strong></p>
<p style="color:red ">Please make SURE you copy/paste and print the boxed information, or write it clearly and INCLUDE either with your deposit.</p>
<p style="color:red "><strong>Check your registered email for detailed deposit instructions.</strong></p>
<div class="row">
<div class="col-md-5">
<table class="table table-condensed table-bordered ">
		<tr>
			<td style="padding:5px ">Reference:</td>
			<td style="padding:5px "><strong><?=$data['Reference']?></strong></td>
		</tr>
		<tr>
			<td style="padding:5px ">Amount:</td>
			<td style="padding:5px "><?=$data['Amount']?></td>
		</tr>
		<tr>
			<td style="padding:5px ">Currency:</td>
			<td style="padding:5px "><?=$data['Currency']?></td>
		</tr>		
</table>
</div>
</div>
<a href="/users/funding_btc" class="btn btn-primary">Funding BTC</a>
<a href="/users/funding_ltc" class="btn btn-primary">Funding LTC</a>
<a href="/users/funding_fiat" class="btn btn-primary">Funding Fiat</a>
<a href="/users/transactions" class="btn btn-primary">Transactions</a>