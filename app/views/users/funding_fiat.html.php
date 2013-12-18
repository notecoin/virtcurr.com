<br>
<style>
.Address_success{background-color: #9FFF9F;font-weight:bold}
</style>
<?php 
foreach($settings['limits'] as $name){
	if($name['name']!='BTC' && $name['name']!='LTC' && $name['allow']==true ){
	$currencies = $currencies . $name['name']. "  " ;
	}
	
}
?>
<h4>Funding - <?=$currencies?></h4>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?=$currencies?> - Deposit / Withdrawal</h3>
  </div>
  <div class="panel-body">
		<div class="row">
		<!-- Deposit -->
			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Deposit <?=$currencies?></h3>
					</div>
					<div class="panel-body">
					<form action="/users/deposit/" method="post" class="form">
						<table class="table table-condensed table-bordered table-hover">
								<tr style="background-color:#CFFDB9">
									<td><?=$t("Balance")?></td>
										<?php
										$i = 1;
										foreach($settings['limits'] as $name){
											if($name['name']!='BTC' && $name['name']!='LTC'  && $name['allow']==true ){
											$balance = 'balance.'.$name['name'];
											$i++;
										?>
											<td style="text-align:right "><?=$details[$balance]?> <?=$name['name']?></td>					
										<?php
											}
										}
										?>									
								</tr>
							<tr>
								<td colspan="1">Reference:</td>
								<?php $Reference = substr($details['username'],0,10).rand(10000,99999);?>
								<td colspan="<?=$i-1?>"><?=$Reference?></td>
							</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Amount should greater than 1">
									<td colspan="1">Amount:</td>
									<td  colspan="<?=$i-1?>"><input type="text" value="" class="form-control" placeholder="1.0" min="1" max="10000" name="AmountFiat" id="AmountFiat" maxlength="5"></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Select a currency">
									<td colspan="1">Currency:</td>
									<td  colspan="<?=$i-1?>"><select name="Currency" id="Currency" class="form-control">
									<option value="">--Select--</option>
										<?php
										foreach($settings['limits'] as $name){
											if($name['name']!='BTC' && $name['name']!='LTC'  && $name['allow']==true ){
										?>
										<option value="<?=$name['name']?>"><?=$name['name']?></option>
										<?php
											}
										}
										?>									
									</select></td>
								</tr>
								<tr>
									<td  colspan="<?=$i?>"><div class="alert alert-warning" id="Alert" style="display:none"></div></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="">
									<td colspan="<?=$i?>" style="text-align:center ">
									<input type="hidden" name="Reference" id="Reference" value="<?=$Reference?>">
										<input type="submit" value="Send email to admin for approval" class="btn btn-primary" onclick="return CheckDeposit();">
									</td>
								</tr>
						</table>
						</form>
					</div>							
				</div>
			</div>
		<!-- Deposit -->
		<!-- Withdrawal -->
			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Withdraw <?=$currencies?></h3>
					</div>
					<div class="panel-body">
						<form action="/users/withdraw/" method="post" class="form">		
						<table class="table table-condensed table-bordered table-hover">
								<tr style="background-color:#CFFDB9">
									<td><?=$t("Balance")?></td>
										<?php
										$i = 1;
										foreach($settings['limits'] as $name){
											if($name['name']!='BTC' && $name['name']!='LTC'  && $name['allow']==true ){
											$balance = 'balance.'.$name['name'];
											$i++;
										?>
											<td style="text-align:right "><?=$details[$balance]?> <?=$name['name']?></td>					
										<?php
											}
										}
										?>									
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Reference number in your transaction">
									<td colspan="1">Reference:</td>
									<?php $Reference = substr($details['username'],0,10).rand(10000,99999);?>
									<td colspan="<?=$i-1?>"><?=$Reference?></td>
								</tr>			
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Amount should be greater than 5">
									<td colspan="1">Amount:</td>
									<td colspan="<?=$i-1?>"><input type="text" value="" class="form-control" placeholder="6.0" min="5" max="10000" name="WithdrawAmountFiat" id="WithdrawAmountFiat" maxlength="5">
									</td>
								</tr>
									<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Select a currency">
									<td colspan="1">Currency:</td>
									<td colspan="<?=$i-1?>"><select name="WithdrawCurrency" id="WithdrawCurrency" class="form-control">
									<option value="">--Select--</option>
										<?php
										foreach($settings['limits'] as $name){
											if($name['name']!='BTC' && $name['name']!='LTC'  && $name['allow']==true ){
										?>
										<option value="<?=$name['name']?>"><?=$name['name']?></option>
										<?php
											}
										}
										?>									
									</select></td>
								</tr>
								<tr>
									<td  colspan="<?=$i?>"><div class="alert alert-warning" id="WithdrawAlert" style="display:none"></div></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Once your email is approved, you will receive the funds in your bank account">
									<td colspan="4" style="text-align:center ">
									<input type="hidden" name="WithdrawReference" id="WithdrawReference" value="<?=$Reference?>">
										<input type="submit" value="Send email to admin for approval" class="btn btn-primary" onclick="return CheckWithdrawal();">
									</td>
								</tr>

						</table>
						</form>
					</div>							
				</div>
			</div>
		<!-- Withdrawal -->
		</div>
	</div>
</div>
