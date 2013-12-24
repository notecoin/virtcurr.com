<?php
namespace app\controllers;
use app\models\Users;
use app\models\Details;
use app\models\Companies;
use app\models\Countries;
use app\models\Settings;
use app\models\Transactions;
use app\models\File;
use app\extensions\action\GoogleAuthenticator;

use app\extensions\action\Functions;

use lithium\security\Auth;
use lithium\storage\Session;
use lithium\util\String;
use MongoID;

use app\extensions\action\Bitcoin;
use app\extensions\action\Litecoin;


class UsersController extends \lithium\action\Controller {

	public function index(){
		$user = Session::read('member');
		if ($user==""){		return $this->redirect('/signin');}
		
		if(SUBDOMAIN!=$user['subname']){
			header('Location: http://'. $user['subname']."." . DOMAIN.$_SERVER['REQUEST_URI']);
			exit;
		}

		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		$company = Companies::find('first',array(
			'conditions'=>array('subname'=>$user['subname'])
		));
		
		return compact('details','user','company');
	}
	
	public function settings($option = null){
		$title = "User settings";
		$ga = new GoogleAuthenticator();
		
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);

		$company = Companies::find('first',array(
			'conditions'=>array('subname'=>$user['subname'])
		));
		
		if ($this->request->data) {
				$option = $this->request->data['option'];
				$data = array(
					$option => $this->request->data['file'],
					$option.'.verified'=>'No',
				);
				$field = 'details_'.$option.'_id';
				$remove = File::remove('all',array(
					'conditions'=>array( $field => (string) $details->_id)
				));

				$fileData = array(
						'file' => $this->request->data['file'],
						'details_'.$option.'_id' => (string) $details->_id
				);
				
				$details = Details::find('first',
					array('conditions'=>array('user_id'=> (string) $id))
				)->save($data);
				$file = File::create();
				if ($file->save($fileData)) {
						$this->redirect('ex::dashboard');
				}
		}

		$TOTP = $details['TOTP.Validate'];
		$secret = $details['secret'];

		$qrCodeUrl = $ga->getQRCodeGoogleUrl(SUBDOMAIN.".VirtCurr.com-TOTP:".$details['username'], $secret);
		
		
		$image_address = File::find('first',array(
			'conditions'=>array('details_address_id'=>(string)$details['_id'])
		));
		if($image_address['filename']!=""){
				$imagename_address = $image_address['_id'].'_'.$image_address['filename'];
					$path = LITHIUM_APP_PATH . '/webroot/documents/'.$imagename_address;
				file_put_contents($path, $image_address->file->getBytes());
		}

		$image_bank = File::find('first',array(
			'conditions'=>array('details_bank_id'=>(string)$details['_id'])
		));
		if($image_bank['filename']!=""){
				$imagename_bank = $image_bank['_id'].'_'.$image_bank['filename'];
					$path = LITHIUM_APP_PATH . '/webroot/documents/'.$imagename_bank;
				file_put_contents($path, $image_bank->file->getBytes());
		}

		$image_government = File::find('first',array(
			'conditions'=>array('details_government_id'=>(string)$details['_id'])
		));
		if($image_government['filename']!=""){
				$imagename_government = $image_government['_id'].'_'.$image_government['filename'];
				$path = LITHIUM_APP_PATH . '/webroot/documents/'.$imagename_government;
				file_put_contents($path, $image_government->file->getBytes());
		}		

			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			);		
			$settings = Settings::find('first',array(
				'conditions'=>array('subname'=>SUBDOMAIN)
			));
		return compact('details','user','title','qrCodeUrl','secret','option','imagename_address','imagename_government','imagename_bank','settings','company');
	
	}
	
	public function SendPassword($username=""){
		$users = Users::find('first',array(
					'conditions'=>array('username'=>$username)
				));
		$id = (string)$users['_id'];
		if($id==""){
			return $this->render(array('json' => array("Password"=>"Password Not sent","TOTP"=>"No")));
		}
		$ga = new GoogleAuthenticator();
		$secret = $ga->createSecret(64);

		$details = Details::find('first',array(
					'conditions'=>array('username'=>$username,'user_id'=>(string)$id)
		));
		if($details['oneCodeused']=='Yes' || $details['oneCodeused']==""){
			$oneCode = $ga->getCode($secret);	
			$data = array(
				'oneCode' => $oneCode,
				'oneCodeused' => 'No'
			);
			$details = Details::find('first',array(
						'conditions'=>array('username'=>$username,'user_id'=>(string)$id)
			))->save($data);
		}
		$details = Details::find('first',array(
					'conditions'=>array('username'=>$username,'user_id'=>(string)$id)
		));
		$oneCode = $details['oneCode'];

		$totp = "No";

		if($details['TOTP.Validate']==true && $details['TOTP.Login']==true){
			$totp = "Yes";
		}
		$email = $users['email'];
/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('users'=>$users,'oneCode'=>$oneCode,'username'=>$username);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'Sign in password for '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = null;
					$function->sendEmailTo($email,$compact,'users','onecode',"Sign in password from ",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				

			return $this->render(array('json' => array("Password"=>"Password sent to email","TOTP"=>$totp)));
	}
	
		public function SaveTOTP(){
		$user = Session::read('default');
		if ($user==""){return $this->render(array('json' => false));}
		$id = $user['_id'];
	
		$login = $this->request->query['Login'];
		$withdrawal = $this->request->query['Withdrawal'];		
		$security = $this->request->query['Security'];		
		$ScannedCode = $this->request->query['ScannedCode'];		

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$ga = new GoogleAuthenticator();
		$checkResult = $ga->verifyCode($details['secret'], $ScannedCode, 2);

		if ($checkResult==1) {
			$data = array(
				'TOTP.Validate'=>(boolean)true,
				'TOTP.Login'=> (boolean)$login,				
				'TOTP.Withdrawal'=>(boolean)$withdrawal,				
				'TOTP.Security'=>(boolean)$security,				
			);
			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			)->save($data);
			return $this->render(array('json' => true));
		} else {
			return $this->render(array('json' => false));
		}
//		return $this->render(array('json' => false));
	}
	public function CheckTOTP(){
		$user = Session::read('default');
		if ($user==""){return $this->render(array('json' => false));}
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);

		$CheckCode = $this->request->query['CheckCode'];		
		$ga = new GoogleAuthenticator();
		$checkResult = $ga->verifyCode($details['secret'], $CheckCode, 2);		
		if ($checkResult) {
			$data = array(
				'TOTP.Validate'=>false,
				'TOTP.Security'=>false,				
			);
			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			)->save($data);
			return $this->render(array('json' => true));
		}else{
			return $this->render(array('json' => false));
		}
	}
	public function DeleteTOTP(){

		return $this->render(array('json' => ""));
	}

	public function addbank(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		$user_id = $user['_id'];
		$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			));		
		$title = "Add bank";
			
		return compact('details','title');
	}
		public function addbankdetails(){
		$user = Session::read('default');
		$user_id = $user['_id'];
		$finance = Details::find("first",array(
			'conditions'=>array('user_id'=>$user_id)
		));
		$data = array();
		if($this->request->data) {	
			$data['finance'] = $finance['finance'];
			$data['finance']['bank'] = $this->request->data;
			$data['finance']['bank']['id'] = new MongoID;
			$data['finance']['bank']['verified'] = 'No';
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			))->save($data);
		}
		return $this->redirect('Users::settings');
	}
	public function addpostal(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		$user_id = $user['_id'];
		$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			));		
		$title = "Add Address";
			
		return compact('details','title');
	
	}
	public function addpostaldetails(){
		$user = Session::read('default');
		$user_id = $user['_id'];
		$finance = Details::find("first",array(
			'conditions'=>array('user_id'=>$user_id)
		));

		$data = array();
		if($this->request->data) {	
			$data['finance'] = $finance['finance'];
			$data['finance']['address'] = $this->request->data;
			$data['finance']['address']['id'] = new MongoID;
			$data['finance']['address']['verified'] = 'No';
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			))->save($data);
		}
		return $this->redirect('Users::settings');
	
	}
	public function funding_btc(){
				$title = "Funding BTC";

		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		
		if(!$this->checkVerification($details['username'])){
				return $this->redirect('/ex/dashboard');
		}
		
		
		$secret = $details['secret'];
		$userid = $details['user_id'];		
		$my_address = BITCOIN_ADDRESS;
		$callback_url = 'https://'.COMPANY_URL.'/users/receipt/?userid='.$userid.'&secret='.$secret;
		$root_url = 'https://blockchain.info/api/receive';
		$parameters = 'method=create&address=' . $my_address .'&shared=false&callback='. urlencode($callback_url);
		$response = file_get_contents($root_url . '?' . $parameters);
		$object = json_decode($response);
//		print_r($object);
		$address = $object->input_address;
		$laddress = 'LADDRESS';				
		$paytxfee = Settings::find('first',array(
			'conditions'=>array('subname'=>SUBDOMAIN)
		));
		foreach($paytxfee['txfees'] as $fee){
			if($fee['name']=='BTC'){
				$txfee = $fee['fee'];			
			}
		}

		
		$transactions = Transactions::find('all',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Approved'=>'No'
				)
		));
			return compact('details','address','txfee','title','transactions','laddress')	;
	}

	public function signup(){
		if($this->request->data) {	
      $Users = Users::create($this->request->data);
      $saved = $Users->save();
			if($saved==true){
				$verification = sha1($Users->_id);
	
				$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
				$bitcoinaddress = $bitcoin->getaccountaddress($this->request->data['username']);
	
				$companies = Companies::find('first',array(
					'conditions'=>array('subname'=>SUBDOMAIN)
				));
				$CompanyISO = $companies['CompanyISO'];
				$countries = Countries::find('first',array(
						'conditions' => array('ISO' => $CompanyISO)
					));
				$CurrencyCode = $countries['CurrencyCode'];
				$CurrencyName = $countries['CurrencyName'];

	//			$oauth = new OAuth2();
	//			$key_secret = $oauth->request_token();
				$ga = new GoogleAuthenticator();
				$data = array(
					'user_id'=>(string)$Users->_id,
					'username'=>(string)$Users->username,
					'subname'=>SUBDOMAIN,
					'email.verify' => $verification,
					'mobile.verified' => "No",				
					'mobile.number' => "",								
					'key'=>$ga->createSecret(64),
					'secret'=>$ga->createSecret(64),
					'Friend'=>array(),
					'bitcoinaddress.0'=>$bitcoinaddress,
					'balance.BTC' => (float)0,
					'balance.LTC' => (float)0,				
					'balance.USD' => (float)0,									
					'balance.'.$CurrencyCode => (float)0,
					'usercode'=>$Users->usercode,
				);
				$details = Details::create()->save($data);
	
				$email = $this->request->data['email'];
				$name = $this->request->data['firstname'];


/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('email'=>$email,'verification'=>$verification,'name'=>$name);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'Verification email from '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = SUBDOMAIN . "@". COMPANY_URL;

					$function->sendEmailTo($email,$compact,'users','confirm',"Verification email",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				

				$this->redirect('Users::email');	
			}				
		}
		$settings = Settings::find('first',array(
			'conditions'=>array('subname'=>SUBDOMAIN)
		));
		$companies = Companies::find('first',array(
			'conditions'=>array('subname'=>SUBDOMAIN)
		));
		return compact('settings','companies','saved','Users');
	}

	public function receipt(){
		$secret = $_GET['secret'];;
		$userid = $_GET['userid']; //invoice_id is past back to the callback URL
		$invoice = $_GET['invoice'];
		$transaction_hash = $_GET['transaction_hash'];
		$input_transaction_hash = $_GET['input_transaction_hash'];
		$input_address = $_GET['input_address'];
		$value_in_satoshi = $_GET['value'];
		$value_in_btc = $value_in_satoshi / 100000000;	
		$details = Details::find('first',
			array(
					'conditions'=>array(
						'user_id'=>$userid,
						'secret'=>$secret)
				));
				if(count($details)!=0){
					$tx = Transactions::create();
					$data = array(
						'DateTime' => new \MongoDate(),
						'TransactionHash' => $transaction_hash,
						'username' => $details['username'],
						'subname' => $details['subname'],
						'address'=>$input_address,							
						'Amount'=> (float)number_format($value_in_btc,8),
						'Currency'=> 'BTC',						
						'Added'=>true,
					);							
					$tx->save($data);
				
				$dataDetails = array(
						'balance.BTC' => (float)number_format((float)$details['balance.BTC'] + (float)$value_in_btc,8),
					);
							$details = Details::find('all',
								array(
										'conditions'=>array(
											'user_id'=>$userid,
											'secret'=>$secret
										)
									))->save($dataDetails);
				}
// Send email to client for payment receipt, if invoice number is present. or not

			return $this->render(array('layout' => false));	
	}
	
		public function paymentbtcverify(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];
		$email = $user['email'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		
		if ($this->request->data) {
			$amount = $this->request->data['TransferAmount'];
			if($details['balance.BTC']<=$amount){return false;}			
			$fee = $this->request->data['txFee'];
			$address = $this->request->data['bitcoinaddress'];

			$tx = Transactions::create();
				$data = array(
					'DateTime' => new \MongoDate(),
					'username' => $details['username'],
					'subname' => $details['subname'],
					'address'=>$address,							
					'verify.payment' => sha1(openssl_random_pseudo_bytes(4,$cstrong)),
					'Paid' => 'No',
					'Amount'=> (float) -$amount,
					'Currency'=> 'BTC',					
					'txFee' => (float) -$fee,
					'Added'=>false,
				);							
				$tx->save($data);	
/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('data'=>$data,'details'=>$details,'tx'=>$tx);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'BTC Withdrawal Approval from '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = SUBDOMAIN . "@". COMPANY_URL;

					$function->sendEmailTo($email,$compact,'users','withdraw_btc',"BTC Withdrawal Approval",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				
		}	
		return compact('data','details','user');
	}

	public function paymentltcverify(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];
		$email = $user['email'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		
		if ($this->request->data) {
			$amount = $this->request->data['TransferAmount'];
			if($details['balance.LTC']<=$amount){return false;}			
			$fee = $this->request->data['txFee'];
			$address = $this->request->data['litecoinaddress'];

			$tx = Transactions::create();
				$data = array(
					'DateTime' => new \MongoDate(),
					'username' => $details['username'],
					'subname' => $details['subname'],
					'address'=>$address,							
					'verify.payment' => sha1(openssl_random_pseudo_bytes(4,$cstrong)),
					'Paid' => 'No',
					'Amount'=> (float) -$amount,
					'Currency'=> 'LTC',					
					'txFee' => (float) -$fee,
					'Added'=>false,
				);							
				$tx->save($data);	
/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('data'=>$data,'details'=>$details,'tx'=>$tx);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'LTC Withdrawal Approval from '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = SUBDOMAIN . "@". COMPANY_URL;

					$function->sendEmailTo($email,$compact,'users','withdraw_btc',"LTC Withdrawal Approval",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				
				
		}	
		return compact('data','details','user');
	}

	
	public function payment(){
			$title = "Payment";

		if ($this->request->data) {
			$verify = $this->request->data['verify'];
			$username = $this->request->data['username'];
			$password = $this->request->data['password'];

			$transaction = Transactions::find('first',array(
				'conditions'=>array(
					'verify.payment'=>$verify,
					'username'=>$username,
					'Paid'=>'No'
					)
			));

			$user = Users::find('first',array(
				'conditions' => array(
					'username' => $username,
					'password' => String::hash($password),
				)
			));
			$id = $user['_id'];
			$email = $user['email'];
		}
		if($id==""){return $this->redirect('/signin');}
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);

		
		if ($this->request->data) {
			$guid=BITCOIN_GUID;
			$firstpassword=BITCOIN_FIRST;
			$secondpassword=BITCOIN_SECOND;
			$amount = abs($transaction['Amount']);
			if($details['balance.BTC']<=$amount){return false;}			
			$fee = $transaction['txFee'];
			$address = $transaction['address'];
			$satoshi = (float)$amount * 100000000;
			$fee_satoshi = (float)$fee * 100000000;
			$json_url = "http://blockchain.info/merchant/$guid/payment?password=$firstpassword&second_password=$secondpassword&to=$address&amount=$satoshi&fee=$fee_satoshi";
			$json_data = file_get_contents($json_url);
			$json_feed = json_decode($json_data);
			$txmessage = $json_feed->message;
			$txid = $json_feed->tx_hash;
			if($txid!=null){
				$data = array(
					'DateTime' => new \MongoDate(),
					'TransactionHash' => $txid,
					'Paid'=>'Yes',
					'Transfer'=>$message,
				);							
			$transaction = Transactions::find('first',array(
				'conditions'=>array(
					'verify.payment'=>$verify,
					'username'=>$username,
					'subname' => $details['subname'],
					'Paid'=>'No'
					)
			))->save($data);
			$transaction = Transactions::find('first',array(
				'conditions'=>array(
					'verify.payment'=>$verify,
					'username'=>$username,
					'Paid'=>'Yes'
					)
			));			
				$dataDetails = array(
						'balance.BTC' => (float)number_format($details['balance.BTC'] - (float)$amount - (float)$fee,8),
					);
				$details = Details::find('all',
					array(
							'conditions'=>array(
								'user_id'=> (string) $id
							)
						))->save($dataDetails);
/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('transaction'=>$transaction,'details'=>$details,'txid'=>$txid);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'BTC sent from '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = SUBDOMAIN . "@". COMPANY_URL;

					$function->sendEmailTo($email,$compact,'users','withdraw_btc_sent',"BTC sent",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				
			}
			return compact('txmessage','txid','json_url','json_feed','title');
		}
	}

	public function paymentltc(){
			$title = "Payment LTC";
			
		if ($this->request->data) {
			$verify = $this->request->data['verify'];
			$username = $this->request->data['username'];
			$password = $this->request->data['password'];

			$transaction = Transactions::find('first',array(
				'conditions'=>array(
					'verify.payment'=>$verify,
					'username'=>$username,
					'Paid'=>'No'
					)
			));

			$user = Users::find('first',array(
				'conditions' => array(
					'username' => $username,
					'password' => String::hash($password),
				)
			));
			$id = $user['_id'];
			$email = $user['email'];
		}

		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);

		if($id==""){return $this->redirect('/signin');}
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		
		if ($this->request->data) {
			$amount =  abs($transaction['Amount']);
			if($details['balance.LTC']<=$amount){return false;}		

			$fee = abs($transaction['txFee']);
			$address =  $transaction['address'];
			$satoshi = (float)$amount * 100000000;
			$fee_satoshi = (float)$fee * 100000000;
			$litecoin = new Litecoin('http://'.LITECOIN_WALLET_SERVER.':'.LITECOIN_WALLET_PORT,LITECOIN_WALLET_USERNAME,LITECOIN_WALLET_PASSWORD);
 
				$comment = "User: ".$details['username']."; Address: ".$address."; Amount:".$amount.";";
				if((float)$details['balance.LTC']>=(float)$amount){
						$settxfee = $litecoin->settxfee($fee);
						$txid = $litecoin->sendfrom('NilamDoctor', $address, (float)$amount,(int)1,$comment);
					if($txid!=null){

						$data = array(
							'DateTime' => new \MongoDate(),
							'TransactionHash' => $txid,
							'Added'=>false,
							'Paid'=>'Yes',
							'Transfer'=>$comment,
						);							
						$transaction = Transactions::find('first',array(
							'conditions'=>array(
								'verify.payment'=>$verify,
								'username'=>$username,
								'subname' => $details['subname'],
								'Paid'=>'No'
								)
						))->save($data);
						$transaction = Transactions::find('first',array(
							'conditions'=>array(
								'verify.payment'=>$verify,
								'username'=>$username,
								'Paid'=>'Yes'
								)
						));			
						
						$txmessage = number_format($amount,8) . " LTC transfered to ".$address;

						$dataDetails = array(
								'balance.LTC' => (float)number_format($details['balance.LTC'] - (float)$amount - (float)$fee,8),
							);
						$details = Details::find('all',
							array(
									'conditions'=>array(
										'user_id'=> (string) $id
									)
								))->save($dataDetails);
/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('transaction'=>$transaction,'details'=>$details,'txid'=>$txid);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'LTC sent from '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = SUBDOMAIN . "@". COMPANY_URL;

					$function->sendEmailTo($email,$compact,'users','withdraw_ltc_sent',"LTC sent",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				
								
				}
			}
			return compact('txmessage','txid','json_url','json_feed','title');
		}
	}
	public function funding_ltc(){
				$title = "Funding LTC";

		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);

		if(!$this->checkVerification($details['username'])){
				return $this->redirect('/ex/dashboard');
		}
		
		$litecoin = new Litecoin('http://'.LITECOIN_WALLET_SERVER.':'.LITECOIN_WALLET_PORT,LITECOIN_WALLET_USERNAME,LITECOIN_WALLET_PASSWORD);
		$address = $litecoin->getnewaddress($user['username']);

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$secret = $details['secret'];
		$userid = $details['user_id'];		

		$paytxfee = Settings::find('first',array(
			'conditions'=>array('subname'=>SUBDOMAIN)
		));
		foreach($paytxfee['txfees'] as $fee){
			if($fee['name']=='LTC'){
				$txfee = $fee['fee'];			
			}
		}
		$transactions = Transactions::find('all',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Approved'=>'No'
				)
		));
			return compact('details','address','txfee','title','transactions')	;
	}
	public function paymentltcconfirm($id = null){
		if ($id==""){return $this->redirect('/signin');}
		$transaction = Transactions::find('first',array(
			'conditions'=>array(
				'verify.payment'=>$id,
				'Paid'=>'No'
				)
		));
		return compact('transaction');

	}
	public function email(){
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);

		if(isset($details['email']['verified'])){
			$msg = "Your email is verified.";
		}else{
			$msg = "Your email is <strong>not</strong> verified. Please check your email to verify.";
		}
		$title = "Email verification";
		return compact('msg','title');
	}
	public function confirm($email=null,$verify=null){
		if($email == "" || $verify==""){
			if($this->request->data){
				if($this->request->data['email']=="" || $this->request->data['verified']==""){
					return $this->redirect('Users::email');
				}
				$email = $this->request->data['email'];
				$verify = $this->request->data['verified'];
			}else{return $this->redirect('Users::email');}
		}
		$finduser = Users::first(array(
			'conditions'=>array(
				'email' => $email,
			)
		));

		$id = (string) $finduser['_id'];

			if($id!=null){
				$data = array('email.verified'=>'Yes');
				Details::create();
				$details = Details::find('all',array(
					'conditions'=>array('user_id'=>$id,'email.verify'=>$verify)
				))->save($data);

				if(empty($details)==1){
					return $this->redirect('Users::email');
				}else{
					return $this->redirect('ex::dashboard');
				}
				}else{return $this->redirect('Users::email');
			}

	}
	public function funding_fiat(){
		$title = "Funding Fiat";

		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];
		
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		if(!$this->checkVerification($details['username'])){
				return $this->redirect('/ex/dashboard');
		}

		$settings =Settings::find('first',array(
				'conditions' => array('subname' => $details['subname'])
		));

		$transactions = Transactions::find('all',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Approved'=>'No'
				)
		));
			return compact('details','title','transactions','settings')	;
	}
	public function deposit(){
		$title = "Deposit";
	
		$user = Session::read('default');

		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		
		$CompanyBank = Details::find('first',array(
			'conditions'=>array('username'=>$details['subname'])
		));
		$amountFiat = $this->request->data['AmountFiat'];
		$Currency = $this->request->data['Currency']; 
		$Reference = $this->request->data['Reference']; 		
		$data = array(
				'DateTime' => new \MongoDate(),
				'username' => $details['username'],
				'subname'=> $details['subname'],
				'Amount'=> (float)$amountFiat,
				'Currency'=> $Currency,					
				'Added'=>true,
				'Reference'=>$Reference,
				'Approved'=>'No'
		);
		$tx = Transactions::create();
		$tx->save($data);
/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('data'=>$data,'details'=>$details,'user'=>$user,'CompanyBank'=>$CompanyBank);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'Deposit to '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = SUBDOMAIN . "@". COMPANY_URL;

					$function->sendEmailTo($email,$compact,'users','deposit',"Deposit to ",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				

		return compact('title','details','data','user');			
	}
	public function withdraw(){
		$title = "Withdraw";
	
		$user = Session::read('default');

		if ($user==""){		return $this->redirect('/signin');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$CompanyBank = Details::find('first',array(
			'conditions'=>array('username'=>$details['subname'])
		));
		
		$amountFiat = $this->request->data['WithdrawAmountFiat'];
		$Currency = $this->request->data['WithdrawCurrency']; 
		$Reference = $this->request->data['WithdrawReference']; 		
		
		$data = array(
				'DateTime' => new \MongoDate(),
				'username' => $details['username'],
				'subname' => $details['subname'],
				'Amount'=> (float)$amountFiat,
				'Currency' => $Currency,					
				'Added'=>false,
				'Reference'=>$Reference,
				'Approved'=>'No'
		);
		$tx = Transactions::create();
		$tx->save($data);
/////////////////////////////////Email//////////////////////////////////////////////////
					$function = new Functions();
					$compact = array('data'=>$data,'details'=>$details,'user'=>$user,'CompanyBank'=>$CompanyBank);
					// sendEmailTo($email,$compact,$controller,$template,$subject,$from,$mail1,$mail2,$mail3)
					$from = array(NOREPLY => 'Withdrawal from '.SUBDOMAIN."@".COMPANY_URL);
					$mail1 = MAIL_1;
					$mail2 = SUBDOMAIN . "@". COMPANY_URL;

					$function->sendEmailTo($email,$compact,'users','withdraw',"Withdrawal from ",$from,$mail1,$mail2);
/////////////////////////////////Email//////////////////////////////////////////////////				

		return compact('title','details','data','user');			
	
	}
	public function checkVerification($username){

		$details = Details::find('first',array(
			'conditions'=>array('username'=>$username)
		));

		$settings = Settings::find('first',array(
			'conditions'=>array('subname'=>$details['subname'])
		));
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
				}elseif($details[$documents['id'].'.verified']=='No'){
						$alldocuments[$documents['id']]="Pending";		
				}else{
						$alldocuments[$documents['id']]="Yes";
				}
			}
			$i++;
		}

		foreach($alldocuments as $key=>$val){						
			if($val=='No'){
				return false;
			}
			if($val=='Pending'){
				return false;
			}
		}
		return true;
	}
}
?>