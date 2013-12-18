<div class="col-md-4">
	<div class="panel panel-info">
		<div class="panel-heading">
		<h2 class="panel-title" style="cursor:pointer;font-weight:bold" onclick="document.getElementById('Graph').style.display='block';"><?=$t('Sell')?> <?=$first_curr?> <?=$t("get")?> <?=$second_curr?> <i class="glyphicon glyphicon-indent-left"></i></h2>
		</div>
<?=$this->form->create(null); ?>		
<input type="hidden" id="SellFirstCurrency" name="SellFirstCurrency" value="<?=$first_curr?>">
<input type="hidden" id="SellSecondCurrency" name="SellSecondCurrency" value="<?=$second_curr?>">		
<input type="hidden" id="SellCommission" name="SellCommission" value="0">				
<input type="hidden" id="UserName" name="UserName" value="<?=$details['username']?>">
<input type="hidden" id="SellCommissionAmount" name="SellCommissionAmount" value="0">						
<input type="hidden" id="SellCommissionCurrency" name="SellCommissionCurrency" value="0">								
<input type="hidden" id="Action" name="Action" value="Sell">								
<table class="table table-condensed">
	<tr>
		<td width="50%"><?=$t('Your balance')?>:<br>
		<span class="btn btn-info btn-block" ><span id="BalanceFirst"><?=$BalanceFirst?></span> <?=$first_curr?></span>
		</td>
		<td><?=$t('Highest Bid Price')?><br>
		<span class="btn btn-success btn-block"><span id="HighestBidPrice">0</span> <?=$second_curr?></span>
		</td>
	</tr>
	<tr>
		<td>
		<?=$this->form->field('SellAmount', array('label'=>'Amount '.$first_curr,'class'=>'form-control col-md-1', 'value'=>0, 'onBlur'=>'$("#SellSubmitButton").attr("disabled", "disabled");','min'=>'0','max'=>'99999999','maxlength'=>'10')); ?>				
		</td>
		<td>
			<label for="SellPriceper"><?=$t("Price per ")?><?=$first_curr?></label>
		<div class="input-group">					
			<input class="col-md-1 form-control" id="SellPriceper" name="SellPriceper" type="text"  onBlur='$("#SellSubmitButton").attr("disabled", "disabled");' min="0" max="99999999" maxlength="10">
			<span class="input-group-addon"> <strong><?=$second_curr?></strong></span>
		</div>				
		</td>				
	</tr>
	<tr>
		<td>Total: </td>
		<td> <span class="label label-warning"><span id="SellTotal">0</span> <?=$second_curr?></span></td>
	</tr>
	<tr>
		<td>Fees: </td>
		<td> <span class="label label-success"><span id="SellFee">0</span> <?=$second_curr?></span></td>
	</tr>
	<tr>
		<td colspan="2" style="height:50px "><span id="SellSummary"><?=$t('Summary of your order')?></span></td>
	</tr>
	<tr>
		<td><input type="button" onClick="SellFormCalculate()" class="btn btn-warning btn-block" value="Calculate"></td>
		<td><input type="submit" id="SellSubmitButton" class="btn btn-primary btn-block" disabled="disabled" value="Submit" onClick='$("#SellSubmitButton").attr("disabled", "disabled");'></td>
	</tr>
</table>
<?=$this->form->end(); ?>
		</div>
</div>