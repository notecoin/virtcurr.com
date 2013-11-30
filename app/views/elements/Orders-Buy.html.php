	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel panel-heading">
			<h2 class="panel-title"  style="font-weight:bold"  href="#"><?=$t('Orders:')?>
			 <?=$t('Buy')?> <?=$first_curr?> &lt; <?=$second_curr?></h2>
<?php  foreach($TotalBuyOrders['result'] as $TBO){
	$BuyAmount = $TBO['Amount'];
	$BuyTotalAmount = $TBO['TotalAmount'];
}?>			
			</div>
		<div id="BuyOrders" style="height:300px;overflow:auto;margin-top:-20px  ">			
			<table class="table table-condensed table-bordered table-hover"  style="font-size:12px ">
				<thead>
					<tr>
					<th style="text-align:center " rowspan="2">#</th>										
					<th style="text-align:center "><?=$t('Price')?></th>
					<th style="text-align:center "><?=$first_curr?></th>
					<th style="text-align:center "><?=$second_curr?></th>					
					</tr>
					<tr>
					<th style="text-align:center " ><?=$t('Total')?> &raquo;</th>
					<th style="text-align:right " ><?=number_format($BuyAmount,8)?></th>
					<th style="text-align:right " ><?=number_format($BuyTotalAmount,8)?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$BuyOrderAmount = 0;
					foreach($BuyOrders['result'] as $BO){
						$BuyOrderPrice = number_format(round($BO['_id']['PerPrice'],8),8);
						$BuyOrderAmount = $BuyOrderAmount + number_format(round($BO['Amount'],8),8);
					
					?>
					<tr onClick="BuyOrderFill(<?=$BuyOrderPrice?>,<?=$BuyOrderAmount?>);" style="cursor:pointer" 
					 class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Sell <?=$BuyOrderAmount?> <?=$first_curr?> at <?=$BuyOrderPrice?> <?=$second_curr?>">
						<td style="text-align:right"><?=$BO['No']?><?=$BO['_id']['username']?></td>											
						<td style="text-align:right"><?=number_format(round($BO['_id']['PerPrice'],8),8)?></td>
						<td style="text-align:right"><?=number_format(round($BO['Amount'],8),8)?></td>
						<td style="text-align:right"><?=number_format(round($BO['_id']['PerPrice']*$BO['Amount'],8),8)?></td>																	
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>	
	</div>
</div>