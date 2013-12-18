	<div class="col-md-4" >
		<div class="panel panel-success">
			<div class="panel panel-heading">
			<h2 class="panel-title"  style="font-weight:bold" ><?=$t('Orders:')?>
			<?=$t('Sell')?> <?=$first_curr?> &gt; <?=$second_curr?></h2>
<?php 
 foreach($TotalSellOrders['result'] as $TSO){
	$SellAmount = $TSO['Amount'];
	$SellTotalAmount = $TSO['TotalAmount'];
}?>			
			</div>
		<div id="SellOrders" style="height:300px;overflow:auto;margin-top:-20px ">
			<table class="table table-condensed table-bordered table-hover" style="font-size:12px ">
				<thead>
					<tr>
					<th style="text-align:center " rowspan="2">#</th>					
					<th style="text-align:center " ><?=$t('Price')?></th>
					<th style="text-align:center " ><?=$first_curr?></th>
					<th style="text-align:center " ><?=$second_curr?></th>					
					</tr>
					<tr>
					<th style="text-align:center " ><?=$t('Total')?> &raquo;</th>
					<th style="text-align:right " ><?=number_format($SellAmount,8)?></th>
					<th style="text-align:right " ><?=number_format($SellTotalAmount,8)?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$SellOrderAmount = 0;
					foreach($SellOrders['result'] as $SO){
						$SellOrderPrice = number_format(round($SO['_id']['PerPrice'],8),8);
						$SellOrderAmount = $SellOrderAmount + number_format(round($SO['Amount'],8),8);
					?>
					<tr onClick="SellOrderFill(<?=$SellOrderPrice?>,<?=$SellOrderAmount?>);"  style="cursor:pointer" 
					 class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Buy <?=$SellOrderAmount?> <?=$first_curr?> at <?=$SellOrderPrice?> <?=$second_curr?>">
						<td style="text-align:right"><?=$SO['No']?><?=$SO['_id']['user_id']?></td>											
						<td style="text-align:right"><?=number_format(round($SO['_id']['PerPrice'],8),8)?></td>						
						<td style="text-align:right"><?=number_format(round($SO['Amount'],8),8)?></td>
						<td style="text-align:right"><?=number_format(round($SO['Amount']*$SO['_id']['PerPrice'],8),8)?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
</div>