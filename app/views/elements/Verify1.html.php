	<div class="col-md-4">
		<div class="panel panel-default" style="min-height:350px ">
			<div class="panel-heading">
			<h2 class="panel-title"  style="cursor:pointer;font-weight:bold" onclick="document.getElementById('Graph').style.display='block';">No funds in <?=$second_curr?>  
<i class="glyphicon glyphicon-indent-left"></i></h2>
			</div>
<table class="table table-condensed" height:"334px">
	<?php 
	$alldocuments = array();
	?>
	<tr>
		<td colspan="2">
			You should verify:
		</td>
	</tr>
		<?php 
	$i=0;		
		foreach($settings['documents'] as $documents){

			if($documents['required']==true){
					if($documents['alias']==""){
						$name = $documents['name'];
					}else{
						$name = $documents['alias'];
					}

				if(strlen($details[$documents['id'].'.verified'])==0){

						$alldocuments[$documents['id']]="";
				?>
	<tr>
		<td colspan="2">
					<a href="/users/settings/<?=$documents['id']?>" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="glyphicon glyphicon-remove"></i> <?=$name?></a>				
		</td>
		</tr>
					<?php }elseif($details[$documents['id'].'.verified']=='No'){
							$alldocuments[$documents['id']]="Yes";
					?>
	<tr>
		<td colspan="2">
	<a href="#" class="label label-danger tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="glyphicon glyphicon-edit"></i> <?=$name?></a>
		</td>
		</tr>
					<?php }else{


						$alldocuments[$documents['id']]="Yes";
					?>
	<tr>
		<td colspan="2">
					<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="glyphicon-ok glyphicon"></i> <?=$name?></a>					
		</td>
		</tr>
	<?php }
			}
			$i++;
		}

		?>
	<tr>
		<td colspan="2">If all the above are verified, add BTC/LTC or Fiat currency through the link below:	</td>
	</tr>
	<tr>
		<td><a href="/users/funding_btc" class="btn btn-primary"><?=$t("Funding BTC")?></a></td>
		<td><a href="/users/funding_ltc" class="btn btn-primary"><?=$t("Funding LTC")?></a></td>
	</tr>
	<tr>
		<td colspan="2">		<a href="/users/funding_fiat" class="btn btn-primary"><?=$t("Funding Fiat")?></a></td>	
	</tr>
</table>			
	</div>
</div>
