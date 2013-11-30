	<div class="col-md-4">
		<div class="panel panel-default" >
			<div class="panel-heading">
				<h2 class="panel-title"  style="cursor:pointer;font-weight:bold" onclick="document.getElementById('Graph').style.display='block';"><?=$t('Buy')?> <?=$first_curr?> <?=$t("with")?> <?=$second_curr?> <i class="glyphicon glyphicon-indent-left"></i></h2>
			</div>
<?=$this->form->create(null,array()); ?>
<input type="hidden" id="BuyFirstCurrency" name="BuyFirstCurrency" value="<?=$first_curr?>">
<input type="hidden" id="BuySecondCurrency" name="BuySecondCurrency" value="<?=$second_curr?>">		
<input type="hidden" id="BuyCommission" name="BuyCommission" value="0">
<input type="hidden" id="UserName" name="UserName" value="<?=$details['username']?>">
<input type="hidden" id="BuyCommissionAmount" name="BuyCommissionAmount" value="0">
<input type="hidden" id="BuyCommissionCurrency" name="BuyCommissionCurrency" value="0">		
<input type="hidden" id="Action" name="Action" value="Buy">						
<table class="table table-condensed " >
	<tr>
		<td><?=$t('Your balance')?>:<br>
		<span class="btn btn-info" style="width:80% "><span id="BalanceSecond"><?=$BalanceSecond?></span> <?=$second_curr?></span>
		</td>
		<td><?=$t('Lowest Ask Price')?><br>
		<span class="btn btn-warning" style="width:80% "><span id="LowestAskPrice">0</span> <?=$second_curr?></span>
		</td>
	</tr>
	<tr>
		<td>
		<?=$this->form->field('BuyAmount', array('label'=>'Amount '.$first_curr,'class'=>'col-md-1 form-control', 'value'=>0, 'onBlur'=>'$("#BuySubmitButton").attr("disabled", "disabled");','min'=>'0','max'=>'99999999','maxlength'=>'10')); ?>				
		</td>
		<td>
			<label for="BuyPriceper"><?=$t("Price per ")?><?=$first_curr?></label>
		<div class="input-group">
			<input class="form-control col-md-1" id="BuyPriceper" name="BuyPriceper" type="text" onBlur='$("#BuySubmitButton").attr("disabled", "disabled");' min="0" max="99999999" maxlength="10">
			<span class="input-group-addon"> <strong><?=$second_curr?></strong></span>
		</div>				
		</td>				
	</tr>
	<tr>
		<td>Total: </td>
		<td> <span class="label label-warning"><span id="BuyTotal">0</span> <?=$second_curr?></span></td>
	</tr>
	<tr>
		<td>Fees: </td>
		<td> <span class="label label-success"><span id="BuyFee">0</span> <?=$first_curr?></span></td>
	</tr>
	<tr>
		<td colspan="2"  style="height:50px "><span id="BuySummary"><?=$t('Summary of your order')?></span></td>
	</tr>
	<tr>
		<td><input type="button" onClick="BuyFormCalculate()" class="btn btn-warning" value="Calculate"></td>
		<td><input type="submit" id="BuySubmitButton" class="btn btn-primary" disabled="disabled" value="Submit"></td>
	</tr>
</table>
<?=$this->form->end(); ?>
	</div>
</div>