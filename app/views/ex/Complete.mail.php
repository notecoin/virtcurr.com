<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$user['username']?>,</h4>	
<p>Your order is complete, processed and fully executed at <?=COMPANY_URL?>.</p>
<table border="1">
	<tr>
		<td>OrderDate</td>	
		<td>Action</td>
		<td>Amount</td>
		<td>Price</td>
		<td>Total Amount</td>
	</tr>
	<tr>
		<td><?=date('Y-M-d H:i:s',$order['DateTime']->sec)?></td>
		<?php if($compact['order']['Action']=="Buy"){?>
		<td><?=$compact['order']['Action']?> <?=$compact['order']['FirstCurrency']?> with <?=$compact['order']['SecondCurrency']?></td>
		<?php }else{?>
		<td><?=$compact['order']['Action']?> <?=$compact['order']['FirstCurrency']?> get <?=$compact['order']['SecondCurrency']?></td>		
		<?php } ?>
		<td><?=number_format($compact['order']['Amount'],8);?> <?=$compact['order']['FirstCurrency']?></td>
		<td><?=number_format($compact['order']['PerPrice'],8);?></td>
		<td><?=number_format($compact['order']['PerPrice']*$compact['order']['Amount'],8);?> <?=$compact['order']['SecondCurrency']?></td>		
	</tr>
	<tr>
		<td colspan="2">Commission</td>
		<td colspan="2"><?=number_format($compact['order']['Commission.Amount'],8)?></td>
		<td><?=$compact['order']['Commission.Currency']?></td>
	</tr>
	<tr>
		<td colspan="2">Transact Date</td>
		<td colspan="3"><?=date('Y-M-d H:i:s',$compact['order']['Transact.DateTime']->sec)?></td>
	</tr>
</table>

<p>To check order please sign in to https://<?=COMPANY_URL?>.</p>

<p>Thank you,</p>
<p>Support</p>