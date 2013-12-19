<?php
use lithium\util\String;
?>
<?php use lithium\core\Environment; 
if(Environment::get('locale')=="en_US"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Dashboard: <?=$user['firstname']?> <?=$user['lastname']?></h3>
  </div>
  <div class="panel-body">
		<div class="row">
		<!--Options-->
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Your status</h3>
					</div>
					<div class="panel-body">
					<table class="table">
						<tr>
							<td width="20%">
<!-- Email start-->					
					<?php 
					if($details['email.verified']=='Yes'){
					?><a href="#" class="btn btn-success   btn-sm btn-block tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="glyphicon glyphicon-ok "></i> <?=$t("Email")?></a><?php }else{
					?><a href="/users/email/" class="btn btn-warning   btn-sm btn-block tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="glyphicon glyphicon-remove"></i> <?=$t("Email")?></a><?php }
					?>
						</td>
<!-- Email end-->										
						<?php 
						$alldocuments = array();
						$i=0;		
						foreach($settings['documents'] as $documents){
							if($documents['required']==true){
									if($documents['alias']==""){
										$name = $documents['name'];
									}else{
										$name = $documents['alias'];
									}
								if(strlen($details[$documents['id'].'.verified'])==0){
										$alldocuments[$documents['id']]="No";
						?>
					<td width="20%"><a href="/users/settings/<?=$documents['id']?>" class="btn   btn-sm btn-block btn-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="glyphicon glyphicon-remove"></i> <?=$name?></a></td>
					<?php }elseif($details[$documents['id'].'.verified']=='No'){
							$alldocuments[$documents['id']]="Pending";
					?>
	<td width="20%"><a href="#" class="btn btn-danger   btn-sm btn-block tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="glyphicon glyphicon-edit"></i> <?=$name?></a></td>
					<?php }else{
						$alldocuments[$documents['id']]="Yes";
					?>
					<td width="20%"><a href="#" class="btn btn-success   btn-sm btn-block tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="glyphicon-ok glyphicon"></i> <?=$name?></a></td>
	<?php }
			}
			$i++;
		}
?>
<!-- Mobile start-->			
				<td width="20%">
					<?php 
					if($details['mobile.verified']=='Yes'){
					?><a href="#" class="btn btn-success   btn-sm btn-block tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="glyphicon glyphicon-ok"></i> <?=$t("Mobile/Phone")?></a><?php }else{
					?><a href="/users/mobile/" class="btn  btn-sm btn-block btn-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Optional!"><i class="glyphicon glyphicon-remove"></i> <?=$t("Mobile/Phone")?></a><?php }
					?>
					</td>
<!-- Mobile end-->															
		</tr>
		<tr>
<?php	

		$all = true;
			foreach($alldocuments as $key=>$val){						

			if($val!='Yes'){
			$all = false;
			}
		}
		if($all){
		?>
		<td width="20%"><a href="/users/funding_btc" class="btn btn-primary  btn-sm btn-block"><?=$t("Funding BTC")?></a></td>
		<td width="20%"><a href="/users/funding_ltc" class="btn btn-primary btn-sm btn-block"><?=$t("Funding LTC")?></a></td>
		<td width="20%"><a href="/users/funding_fiat" class="btn btn-primary btn-sm btn-block"><?=$t("Funding Fiat")?></a></td>	
		<td width="20%"><a href="/<?=$locale?>/users/transactions" class="btn btn-primary btn-sm btn-block"><?=$t("Transactions")?></a></td>
		<td width="20%"><a href="/<?=$locale?>/users/settings" class="btn btn-primary btn-sm btn-block"><?=$t("Settings")?></a></td>
	</tr>
<?php }?>	
		</table>
					</div>
				</div>
			</div>
		<!-- Options -->
		<!--Summary-->
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Summary of accounts</h3>
					</div>
					<div class="panel-body">
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th><?=$t("Currency")?></th>
					<?php foreach($settings['limits'] as $currency){?>
					<th style="text-align:center"><?=$currency['name']?></th>
					<?php }?>
				</tr>
			</thead>
<?php 
foreach($YourOrders['Buy']['result'] as $YO){
	$Buy[$YO['_id']['FirstCurrency']] = $Buy[$YO['_id']['FirstCurrency']] + $YO['Amount'];
	$BuyWith[$YO['_id']['SecondCurrency']] = $BuyWith[$YO['_id']['SecondCurrency']] + $YO['TotalAmount'];					
}					
foreach($YourOrders['Sell']['result'] as $YO){
	$Sell[$YO['_id']['FirstCurrency']] = $Sell[$YO['_id']['FirstCurrency']] + $YO['Amount'];
	$SellWith[$YO['_id']['SecondCurrency']] = $SellWith[$YO['_id']['SecondCurrency']] + $YO['TotalAmount'];					
}					
foreach($YourCompleteOrders['Buy']['result'] as $YCO){
	$ComBuy[$YCO['_id']['FirstCurrency']] = $ComBuy[$YCO['_id']['FirstCurrency']] + $YCO['Amount'];
	$ComBuyWith[$YCO['_id']['SecondCurrency']] = $ComBuyWith[$YCO['_id']['SecondCurrency']] + $YCO['TotalAmount'];					
}					
foreach($YourCompleteOrders['Sell']['result'] as $YCO){
	$ComSell[$YCO['_id']['FirstCurrency']] = $ComSell[$YCO['_id']['FirstCurrency']] + $YCO['Amount'];
	$ComSellWith[$YCO['_id']['SecondCurrency']] = $ComSellWith[$YCO['_id']['SecondCurrency']] + $YCO['TotalAmount'];					
}					
?>			
<?php
foreach($Commissions['result'] as $C){
	foreach($settings['limits'] as $currency){
		if($C['_id']['CommissionCurrency']==$currency['name']){
			$variablename = $currency['name']."Comm";
			$$variablename = $C['Commission'];		
		}
	}
}
foreach($CompletedCommissions['result'] as $C){
	foreach($settings['limits'] as $currency){
		if($C['_id']['CommissionCurrency']==$currency['name']){
			$variablename = "Completed".$currency['name']."Comm";
			$$variablename = $C['Commission'];		
		}
	}
}
?>
			<tbody>
				<tr>
					<td><strong><?=$t('Opening Balance')?></strong></td>
					<?php foreach($settings['limits'] as $currency){?>
					<td style="text-align:right"><?=number_format($details['balance.'.$currency['name']]+$Sell[$currency['name']],8)?></td>					
					<?php }?>
				</tr>
				<tr>
					<td><strong><?=$t('Current Balance')?></strong><br>
					<?=$t("(including pending orders)")?></td>
					<?php foreach($settings['limits'] as $currency){?>
						<td style="text-align:right "><?=number_format($details['balance.'.$currency['name']],8)?></td>
					<?php }?>
				</tr>
				<tr>
					<td><strong><?=$t('Pending Buy Orders')?></strong></td>
					<?php foreach($settings['limits'] as $currency){
						if($currency['name']=='BTC' || $currency['name'] = 'LTC'){
						?>
					<td style="text-align:right ">+<?=number_format($Buy[$currency['name']],8)?></td>
					<?php }else{?>
					<td style="text-align:right ">-<?=number_format($BuyWith[$currency['name']],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td><strong><?=$t('Pending Sell Orders')?></strong></td>
					<?php foreach($settings['limits'] as $currency){
						if($currency['name']=='BTC' || $currency['name'] = 'LTC'){
						?>
					<td style="text-align:right ">-<?=number_format($Sell[$currency['name']],8)?></td>
					<?php }else{?>
					<td style="text-align:right ">+<?=number_format($SellWith[$currency['name']],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td><strong><?=$t('After Execution')?></strong></td>
					<?php foreach($settings['limits'] as $currency){
						if($currency['name']=='BTC' || $currency['name'] = 'LTC'){
						$variablename = $currency['name']."Comm";
						?>
					<td style="text-align:right "><?=number_format($details['balance.'.$currency['name']]+$Buy[$currency['name']]-$$variablename,8)?></td>
					<?php }else{?>
					<td style="text-align:right "><?=number_format($details['balance.'.$currency['name']]+$SellWith[$currency['name']]-$$variablename,4)?></td>					
					<?php }
					}?>					
				</tr>
				<tr>
					<td><strong><?=$t('Commissions')?></strong></td>
					<?php foreach($settings['limits'] as $currency){
						$variablename = $currency['name']."Comm";
						?>
					<td style="text-align:right "><?=number_format($$variablename,8)?></td>
					<?php }?>					
				</tr>
				<tr>
					<td><strong><?=$t('Complete Buy Orders')?></strong></td>
					<?php foreach($settings['limits'] as $currency){
						if($currency['name']=='BTC' || $currency['name'] = 'LTC'){
						?>
					<td style="text-align:right "><?=number_format($ComBuy[$currency['name']],8)?></td>
					<?php }else{?>
					<td style="text-align:right "><?=number_format($ComBuyWith[$currency['name']],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td><strong><?=$t('Complete Sell Orders')?></strong></td>
					<?php foreach($settings['limits'] as $currency){
						if($currency['name']=='BTC' || $currency['name'] = 'LTC'){
						?>
					<td style="text-align:right "><?=number_format($ComSell[$currency['name']],8)?></td>
					<?php }else{?>
					<td style="text-align:right "><?=number_format($ComSellWith[$currency['name']],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td><strong><?=$t('Completed Order Commissions')?></strong></td>
					<?php foreach($settings['limits'] as $currency){
							$variablename = "Completed".$currency['name']."Comm";
						?>
					<td style="text-align:right "><?=number_format($$variablename,8)?></td>
					<?php }?>					
				</tr>
			</tbody>
		</table>
					</div>
				</div>
			</div>		
		<!--Summary-->
		<!-- final summary-->
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title"><?=$t('Users')?>: <?=$UsersRegistered?> / <?=$t('Online')?>: <?=$OnlineUsers?></h3>
					</div>
					<div class="panel-body">
		<table class="table table-condensed table-bordered table-hover">
				<tr>
					<th><?=$t("Status")?></th>
					<th><?=$t("BTC")?></th>
					<th><?=$t("Amount")?></th>					
					<th><?=$t("Avg Price")?></th>										
				</tr>
				<tr>
					<th colspan="4"><?=$t("Pending orders")?></th>
				</tr>
				<?php foreach ($TotalOrders['Buy']['result'] as $r){ ?>
					<tr>
						<td><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></td>
						<td style="text-align:right "><?=number_format($r['Amount'],8)?></td>
						<td style="text-align:right "><?=number_format($r['TotalAmount'],8)?></td>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>												
					</tr>
				<?php }?>
				<?php foreach ($TotalOrders['Sell']['result'] as $r){ ?>
					<tr>
						<td><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></td>
						<td style="text-align:right "><?=number_format($r['Amount'],8)?></td>
						<td style="text-align:right "><?=number_format($r['TotalAmount'],8)?></td>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>																		
					</tr>
				<?php }?>
				<tr>
					<th colspan="4"><?=$t("Completed orders")?></th>
				</tr>
				<?php foreach ($TotalCompleteOrders['Buy']['result'] as $r){ ?>
					<tr>
						<th><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></th>
						<th style="text-align:right "><?=number_format($r['Amount'],8)?></th>
						<th style="text-align:right "><?=number_format($r['TotalAmount'],8)?></th>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>																		
					</tr>
				<?php }?>
				<?php foreach ($TotalCompleteOrders['Sell']['result'] as $r){ ?>
					<tr>
						<th><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></th>
						<th style="text-align:right "><?=number_format($r['Amount'],8)?></th>
						<th style="text-align:right "><?=number_format($r['TotalAmount'],8)?></th>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>																		
					</tr>
				<?php }?>
		</table>
					</div>
				</div>
			</div>		
		<!-- final summary-->		
<?php 
if($settings['friends']['allow']==true){
?>
		<!-- Friends-->
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Users you transacted with</h3>
					</div>
					<div class="panel-body">
			<?php foreach($RequestFriends['result'] as $RF){
			$friend = array();
			if($details['Friend']!=""){
				foreach($details['Friend'] as $f){
					array_push($friend, $f);
				}
			}
			if(!in_array($RF['_id']['TransactUsercode'],$friend,TRUE)){
			  ?><a href="/<?=$locale?>/ex/AddFriend/<?=String::hash($RF['_id']['TransactUser_id'])?>/<?=$RF['_id']['TransactUser_id']?>/<?=$RF['_id']['TransactUsercode']?>"
				class=" tooltip-x label label-success" rel="tooltip-x" data-placement="top" title="Add to receive alerts from <?=$RF['_id']['TransactUsercode']?>"
				style="font-weight:bold "><i class="glyphicon glyphicon-plus"></i> <?=$RF['_id']['TransactUsercode']?></a>
			<?php }else{?>
			<a  href="/<?=$locale?>/ex/RemoveFriend/<?=String::hash($RF['_id']['TransactUser_id'])?>/<?=$RF['_id']['TransactUser_id']?>/<?=$RF['_id']['TransactUsercode']?>" class="tooltip-x label label-warning" rel="tooltip-x" data-placement="top" title="Already a friend <?=$RF['_id']['TransactUsercode']?> Remove!">
<i class="glyphicon glyphicon-minus"></i>			<?=$RF['_id']['TransactUsercode']?></a>
			<?php }?>
			<?php }?>
					</div>
				</div>
			</div>		
		<!-- Friends-->		
<?php }?>
		</div>
	</div>
</div>