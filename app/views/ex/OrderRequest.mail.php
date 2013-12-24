<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$compact['user']['username']?>,</h4>
<p>Your order is placed at <?=COMPANY_URL?>.</p>
<table border="1">
	<tr>
		<td>Action</td>
		<td>Amount</td>
		<td>Price</td>
		<td>Total Amount</td>
	</tr>
	<tr>
		<?php if($compact['order']['Action']=="Buy"){?>
		<td><?=$compact['order']['Action']?> <?=$compact['order']['FirstCurrency']?> with <?=$compact['order']['SecondCurrency']?></td>
		<?php }else{?>
		<td><?=$compact['order']['Action']?> <?=$compact['order']['FirstCurrency']?> get <?=$compact['order']['SecondCurrency']?></td>		
		<?php } ?>
		<td><?=number_format($compact['order']['Amount'],8);?></td>
		<td><?=number_format($compact['order']['PerPrice'],8);?></td>
		<td><?=number_format($compact['order']['PerPrice']*$compact['order']['Amount'],8);?></td>		
	</tr>
</table>
<p>To view your order please sign in. </p>

<p>Thank you,</p>
<p>Support</p>