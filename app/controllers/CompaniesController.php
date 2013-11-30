<?php
namespace app\controllers;
use app\models\Countries;
use app\models\Commissions;
use app\models\Documents;
use app\models\Ipaddresses;
use app\models\Companies;
use app\models\Settings;
use app\models\Users;
use app\models\Details;

use lithium\storage\Session;

use app\extensions\action\GoogleAuthenticator;
use \lithium\template\View;

use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;


class CompaniesController extends \lithium\action\Controller {

	public function index(){
		$IP = $_SERVER['REMOTE_ADDR'];
		$ips = explode(".",$IP);
		$IP_no =  $ips[3] + $ips[2]*256 + $ips[1]*65536 + $ips[0]*16777216;
		$Country = Ipaddresses::find('all',array(
			'conditions'=>array(
				'start_no'=>array('$lte'=>$IP_no), 
				'end_no'=>array('$gte'=>$IP_no)
			),
			'limit'=>1
		));
//		print_r($Country);
		if(count($Country)!=0){
			foreach($Country as $CC){
				$CountryISO = $CC['ISO'];
			}
		}
//		print_r($CountryISO);
		$MyCountry = Countries::find('first',array(
			'conditions'=>array('ISO'=>$CountryISO)
		));

		$SelectedCountry = Countries::find('first',array(
		'conditions'=>array('ISO'=>strtoupper(SUBDOMAIN))
		));
		
		$Companies = Companies::find('all',array(
			'conditions'=>array('CompanyISO'=>strtoupper(SUBDOMAIN))
		));
		return compact('SelectedCountry','MyCountry','IP','Companies');
	}
	
	
	public function Register(){
	 $saved = false;
    if($this->request->data){
        $Companies = Companies::create($this->request->data);
        //Attempt to save the data, and update the $saved variable
        //with the outcome of the save attempt (bool)
        $saved = $Companies->save();
				if($saved==true){
				//send email to verify account and activate for login
					$verification = sha1($Companies->_id);
					$ga = new GoogleAuthenticator();
					$countries = Countries::find('first',array(
						'conditions' => array('ISO' => $this->request->data['CompanyISO'])
					));
					$CurrencyCode = $countries['CurrencyCode'];
					$CurrencyName = $countries['CurrencyName'];
					$data = array(
						'subname'	=>	$this->request->data['subname'],
						'username'	=>	$this->request->data['subname'],
						'password'	=>	$this->request->data['password'],
						'password2'	=>	$this->request->data['password2'],					
						'firstname'	=>	$this->request->data['firstname'],
						'lastname'	=>	$this->request->data['lastname'],
						'email'	=>	$this->request->data['email'],
						'admin' => true,
					);
				$User = Users::create($data);
				$saved = $User->save();
	
				$data = array(
					'user_id'=>(string)$User->_id,
					'username'=>$this->request->data['subname'],
					'subname'=>$this->request->data['subname'],
					'email.verify' => $verification,
					'mobile.number' => $this->request->data['mobile'],
					'key'=>$ga->createSecret(64),
					'secret'=>$ga->createSecret(64),
					'Friend'=>array(),
					'balance.BTC' => (float)0,
					'balance.LTC' => (float)0,				
					'balance.USD' => (float)0,									
					'balance.'.$CurrencyCode => (float)0
				);
				Details::create()->save($data);
	
				$trades = array(
					array(
						'refresh' => false,
						'trade' => 'BTC/LTC',
						'First' => 'Bitcoin',
						'Second' => 'Litecoin',
						'active'=> true,
					),
					array(
						'refresh' => false,
						'trade' => 'BTC/USD',
						'First' => 'Bitcoin',
						'Second' => 'Dollar',
						'active'=> true,						
					),					
					array(
						'refresh' => false,
						'trade' => 'LTC/USD',
						'First' => 'Litecoin',
						'Second' => 'Dollar',
						'active'=> true,						
					),					
					array(
						'refresh' => false,
						'trade' => 'BTC/'.$CurrencyCode,
						'First' => 'Bitcoin',
						'Second' => $CurrencyName,
						'active'=> true,						
					),					
					array(
						'refresh' => false,
						'trade' => 'LTC/'.$CurrencyCode,
						'First' => 'Litecoin',
						'Second' => $CurrencyName,
						'active'=> true,						
					),										
				);
				
				$commissions = Commissions::find('all',array(
					'order'=>array('_id'=>1)
				));
				$i = 0;
				$commdata = array();
				foreach($commissions as $comm){
					$commdata[$i]['transact'] = $comm['transact'];
					$commdata[$i]['percent'] = $comm['percent'];					
				$i++;
				}
				$documents = Documents::find('all');
				$i = 0;
				$docudata = array();
				foreach($documents as $docu){
					$docudata[$i]['name'] = $docu['name'];
					$docudata[$i]['required'] = $docu['required'];
					$docudata[$i]['alias'] = $docu['alias'];										
					$docudata[$i]['id'] = $docu['id'];															
					$i++;
				}
				$txfees = array(
					'BTC' => 0.0005,
					'LTC' => 0.0001
				);
					$data = array(
						'company_id'=>(string)$Companies->_id,
						'subname'=>(string)$Companies->subname,
						'email.verified' => "No",				
						'email.verify' => $verification,
						'mobile.verified' => "No",				
						'mobile.number' => $Companies->mobile,
						'key'=>$ga->createSecret(64),
						'secret'=>$ga->createSecret(64),
						'trades'=>$trades,
						'commissions'=>$commdata,
						'documents'=>$docudata,
						'txfees'=> $txfees,
					);
					Settings::create()->save($data);
					
					$email = $this->request->data['email'];
					$name = $this->request->data['firstname'];
					$subname = $this->request->data['subname'];
					$this->SendRegistrationEmail($email,$name);
					//redirect to email verification
					$this->redirect('Companies::email');	
	    }
		}
		$SelectedCountry = Countries::find('first',array(
		'conditions'=>array('ISO'=>strtoupper(SUBDOMAIN))
		));

    //Return $saved to our view as part of an associative array/token
    return compact('saved','Companies','SelectedCountry');
	}
	
	public function email(){
		$user = Session::read('member');
		$id = $user['_id'];
		$settings = Settings::find('first',
			array('conditions'=>array('company_id'=>$id))
		);

		if(isset($settings['email']['verified'])){
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
					return $this->redirect('Companies::email');
				}
				$email = $this->request->data['email'];
				$verify = $this->request->data['verified'];
			}else{return $this->redirect('Companies::email');}
		}
		$finduser = Companies::first(array(
			'conditions'=>array(
				'email' => $email,
			)
		));

		$id = (string) $finduser['_id'];
		$username = (string) $finduser['subname'];
			if($id!=null){
				$data = array('email.verified'=>'Yes');
				Settings::create();
				$settings = Settings::find('all',array(
					'conditions'=>array('company_id'=>$id,'email.verify'=>$verify)
				))->save($data);
				Details::create();
				$details = Details::find('all',array(
					'conditions'=>array(
						'username'=>$username
					)
				))->save($data);
				
//print_r($verify);exit;
				if(empty($settings)==1){
					return $this->redirect('Companies::email');
				}else{
					return $this->redirect('/signin/'.$finduser);
				}
			}else{return $this->redirect('Companies::email');}

	}

	private function SendRegistrationEmail($email,$name){
			
			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$body = $view->render(
				'template',
				compact('email','verification','name'),
				array(
					'controller' => 'companies',
					'template'=>'confirm',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Verification of email from ".COMPANY_URL);
			$message->setFrom(array(NOREPLY => 'Verification email '.COMPANY_URL));
			$message->setTo($user->email);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		

			$message->setBody($body,'text/html');
			
			$mailer->send($message);
	}
	public function page($pagename=null){
	
	}	
}
?>