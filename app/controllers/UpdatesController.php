<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;
use app\models\Parameters;
use app\models\Details;
use app\models\Trades;
use app\models\Orders;
use app\models\Settings;
use MongoDate;
use lithium\data\Connections;
use lithium\storage\Session;
use app\extensions\action\Bitcoin;
use app\extensions\action\Litecoin;

class UpdatesController extends \lithium\action\Controller {

	public function index() {
		return $this->render(array('layout' => false));
	}

	public function to_string() {
		return "Hello World";
	}

	public function to_json() {
		return $this->render(array('json' => 'Hello World'));
	}

	public function Rates($FirstCurrency="BTC",$SecondCurrency="USD") {

		$title = $FirstCurrency . "/" . $SecondCurrency;
		$back = strtolower($FirstCurrency . "_" . $SecondCurrency);		

		$Refresh = "No";
		
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		if($details['page.refresh']==true || $details['page.refresh']==1){
				$data = array(
				'page.refresh' => false
				);
				Details::find('all',
				array('conditions'=>array('user_id'=>$id))				
				)->save($data);

			$Refresh = "Yes";
		}
		
			$URL = "/".$locale.'ex/x/'.$back;					
			$trades = Trades::find('first',array(
				'conditions' => array('trade'=>$title),
			));
			
			if($trades['refresh']==true || $trades['refresh']==1){
				$data = array(
				'refresh' => false
				);
				Trades::find('all',array(
					'conditions' => array('trade'=>$title)
				))->save($data);
				$Refresh = "Yes";
			}

		$mongodb = Connections::get('default')->connection;
		$Rates = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( 
				'$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'PerPrice'=>'$PerPrice',					
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',
				)),
				array('$match'=>array(
					'Completed'=>'Y',					
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
							'year'=>array('$year' => '$TransactDateTime'),
							'month'=>array('$month' => '$TransactDateTime'),						
							'day'=>array('$dayOfMonth' => '$TransactDateTime'),												
//						'hour'=>array('$hour' => '$TransactDateTime'),
						),
					'min' => array('$min' => '$PerPrice'), 
					'max' => array('$max' => '$PerPrice'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,					
//					'_id.hour'=>-1,					
				)),
				array('$limit'=>1)
			)
		));

//		print_r($Rates['result']);
		foreach($Rates['result'] as $r){
			$Low = $r['min'];
			$High = $r['max'];			
		}

		$Last = Orders::find('all',array(
			'conditions'=>array(
				'Completed'=>'Y',					
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,					
				),
			'limit'=>1,
			'order'=>array('Transact.DateTime'=>'DESC')
		));
		foreach($Last as $l){
			$LastPrice = $l['PerPrice'];
		}
		
		$TotalOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action'=>'$Action',					
					'Amount'=>'$Amount',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),
				)),
				array('$match'=>array(
					'Completed'=>'Y',	
					'Action'=>'Buy',										
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
					'year'=>array('$year' => '$TransactDateTime'),
					'month'=>array('$month' => '$TransactDateTime'),						
					),
					'Amount' => array('$sum' => '$Amount'), 
					'TotalAmount' => array('$sum' => '$TotalAmount'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
				)),
				array('$limit'=>1)
			)
		));
//		print_r($SecondCurrency);
		return $this->render(array('json' => array(
			'Refresh'=> $Refresh,
			'URL'=> $URL,
			'Low'=> number_format($Low,2),
			'High' => number_format($High,2),
			'Last'=> number_format($LastPrice,2),			
			'VolumeFirst'=> number_format($TotalOrders['result'][0]['Amount'],4),
			'VolumeSecond'=> number_format($TotalOrders['result'][0]['TotalAmount'],0),
			'VolumeFirstUnit'=> $FirstCurrency,			
			'VolumeSecondUnit'=> $SecondCurrency,
		)));
	}
	public function Commission($username = null){
		$commissions = Settings::find('first',
			array('conditions'=>array('subname'=>SUBDOMAIN))
		);
		$orders = Orders::find('count',array(
			'conditions'=>array(
				'username'=>$username,
				'Completed'=>'Y'
			)
		));
		foreach($commissions['commissions'] as $commission){
			if($orders<=$commission['transact']){
				$Commission = (float)$commission['percent']+0.1;
				break;
			}
		}
		return $this->render(array('json' => array(
			'Commission' => $Commission
		)));
	}
	public function BuyFormSubmit($BuyAmount,$BuyPricePer,$Fees,$GrandTotal){
	print_r($BuyAmount);
	print_r($BuyPricePer);
	print_r($Fees);
	print_r($GrandTotal);		
	exit;
	}
	
	public function Address($address = null){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
			$verify = $bitcoin->validateaddress($address);
			return $this->render(array('json' => array(
			'verify'=> $verify,
		)));
	}

	public function LTCAddress($address = null){
		$litecoin = new Litecoin('http://'.LITECOIN_WALLET_SERVER.':'.LITECOIN_WALLET_PORT,LITECOIN_WALLET_USERNAME,LITECOIN_WALLET_PASSWORD);
			$verify = $litecoin->validateaddress($address);
			return $this->render(array('json' => array(
			'verify'=> $verify,
		)));
	}

	public function OHLC($FirstCurrency="BTC",$SecondCurrency="GBP"){
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
	
		$mongodb = Connections::get('default')->connection;
		$Rates = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( 
				'$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'PerPrice'=>'$PerPrice',			
					'Amount' => '$Amount',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',
				)),
				array('$match'=>array(
					'Completed'=>'Y',					
					'FirstCurrency'=>$FirstCurrency,
					'SecondCurrency'=>$SecondCurrency,							
					'TransactDateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate )
					)),
				array('$group' => array( '_id' => array(
							'year'=>array('$year' => '$TransactDateTime'),
							'month'=>array('$month' => '$TransactDateTime'),						
							'day'=>array('$dayOfMonth' => '$TransactDateTime'),												
  						'hour'=>array('$hour' => '$TransactDateTime'),
							'FirstCurrency'=>'$FirstCurrency',
							'SecondCurrency'=>'$SecondCurrency',							
						),
					'Open' => array('$first' => '$PerPrice'), 						
					'High' => array('$max' => '$PerPrice'), 
					'Low' => array('$min' => '$PerPrice'), 
					'Close' => array('$last' => '$PerPrice'), 					
					'Volume'=> array('$sum'=>'$Amount'),
				)),
				array('$sort'=>array(
					'_id.year'=>1,
					'_id.month'=>1,
					'_id.day'=>1,					
					'_id.hour'=>1,					
				)),
//				array('$limit'=>1)
			)
		));

			return $Rates;
	
	}


}

?>