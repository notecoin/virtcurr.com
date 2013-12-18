<?php
namespace app\controllers;
use app\extensions\action\Bitcoin;

class DustController extends \lithium\action\Controller {
	public function index(){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$getinfo = $bitcoin->getinfo();
		$accounts = $bitcoin->listunspent();
		$i = 0;
		$data = array();
		foreach($accounts as $acc){
			$addresses = $bitcoin->getaddressesbyaccount($acc['account']);
//			print_r("<br>XXXXXXXXXXXXXXXX<br>".$i);
//			print_r("<br>Account: ".$uu['account']);
			if($acc['amount']>0.0001){
			foreach($addresses as $address){
				$key = $bitcoin->dumpprivkey($address);
//				print_r("<br>A : ".$address);
//				print_r("<br>K : ".$key);
			$data[$acc['account']] = array(
				'amount'=>$acc['amount'],
				'priv' => $key,
				'addr' => $address
			);
			}
			$i++;
		}}
			print_r($data);
			//		
	}




}
?>
