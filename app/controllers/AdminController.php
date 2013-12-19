<?php
namespace app\controllers;
use app\models\Countries;
use app\models\Templates;
use app\models\Ipaddresses;
use app\models\Companies;
use app\models\Settings;
use app\models\Users;
use app\models\Details;
use app\models\File;
use lithium\storage\Session;

use app\extensions\action\GoogleAuthenticator;
use \lithium\template\View;

use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;


class AdminController extends \lithium\action\Controller {

	public function index(){
		$user = Session::read('member');
		if ($user['admin']!=1){		return $this->redirect('/signin');}
	}
	
	public function pages($page=null){
		$user = Session::read('member');
		if ($user['admin']!=1){		return $this->redirect('/signin');}

		$templates = Templates::find('all');
		
		if($this->request->data){
			$settings = Settings::find('first',array(
			'conditions'=>array('subname'=>$user['subname'])
			));		
			$data = array(
				$page => $this->request->data['template']
			);

			$settings = Settings::find('first',array(
			'conditions'=>array('subname'=>$user['subname'])
			))->save($data);
			
		}
		$settings = Settings::find('first',array(
			'conditions'=>array('subname'=>$user['subname'])
		));

	return compact('page','templates','settings');
	}

	function __init(){
	}
	public function approval(){
		$user = Session::read('member');
		if ($user['admin']!=1){		return $this->redirect('/signin');}
		$settings = Settings::find('first',array(
			'conditions'=>array('subname'=>$user['subname'])
		));

		$subname = $user['subname'];

			if($this->request->data){
			$UserApproval = $this->request->data['UserApproval']	;
			$EmailSearch = $this->request->data['EmailSearch']	;	
			$UserSearch = $this->request->data['UserSearch']	;							
			$usernames = array();		
			if($EmailSearch!="" || $UserSearch!="" ){
				$user = Users::find('all',array(
					'conditions'=>array(
						'username'=>array('$regex'=>$UserSearch),
						'email'=>array('$regex'=>$EmailSearch),		
						'subname'=>$subname,
					)
				));
				foreach($user as $u){
					array_push($usernames,$u['username']);
				}
			}else{
					$user = Users::find('all',array('limit'=>1000));
					foreach($user as $u){
						array_push($usernames,$u['username']);
					}
			}
			switch ($UserApproval) {
				case "All":
					$details = Details::find('all',array(
						'conditions'=>array(
							'username'=>array('$in'=>$usernames),
							'subname'=>$subname,
							)
					));
					break;
				case "VEmail":
					$details = Details::find('all',array(
						'conditions'=>array(
						'email.verified'=>'Yes',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,
						)
					));
	
					break;
				case "VPhone":
					$details = Details::find('all',array(
						'conditions'=>array(
						'phone.verified'=>'Yes',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "Vbank":
					$details = Details::find('all',array(
						'conditions'=>array(
						'bank.verified'=>'Yes',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
				
					break;
				case "Vgovernment":
					$details = Details::find('all',array(
						'conditions'=>array(
						'government.verified'=>'Yes',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
				
					break;
				case "Vaddress":
					$details = Details::find('all',array(
						'conditions'=>array(
						'address.verified'=>'Yes',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));			
					break;
					
				case "NVEmail":
					$details = Details::find('all',array(
						'conditions'=>array(
						'email.verify'=>'Yes',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "NVPhone":
					$details = Details::find('all',array(
						'conditions'=>array(
						'phone.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "NVbank":
					$details = Details::find('all',array(
						'conditions'=>array(
						'bank.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "NVgovernment":
					$details = Details::find('all',array(
						'conditions'=>array(
						'government.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "NVaddress":
					$details = Details::find('all',array(
						'conditions'=>array(
						'address.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
				
					break;
					
				case "WVEmail":
					$details = Details::find('all',array(
						'conditions'=>array(
						'email.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
				
					break;
				case "WVPhone":
					$details = Details::find('all',array(
						'conditions'=>array(
						'phone.verified'=>'No',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "WVbank":
					$details = Details::find('all',array(
						'conditions'=>array(
						'bank.verified'=>'No',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "WVgovernment":
					$details = Details::find('all',array(
						'conditions'=>array(
						'government.verified'=>'No',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
	
					break;
				case "WVaddress":
					$details = Details::find('all',array(
						'conditions'=>array(
						'address.verified'=>'No',
						'username'=>array('$in'=>$usernames),
						'subname'=>$subname,

						)
					));
					break;
			}
			}else{
				$details = Details::find('all',array(
				'conditions'=>array(
					'$or'=>array(
						array('address.verified'=>'No'),
						array('government.verified'=>'No'),
						array('bank.verified'=>'No'),
						array('address.verified'=>''),
						array('government.verified'=>''),
						array('bank.verified'=>'')	
					),
						'subname'=>$subname,					
				)
				));
			}

		return compact('page','templates','settings','UserApproval','details');
	}	

		public function Approve($media=null,$id=null,$response=null){
		$user = Session::read('member');
		if ($user['admin']!=1){		return $this->redirect('/signin');}

			if($response!=""){
				if($response=="Approve"){
					$data = array(
						$media.".verified" => "Yes",
						'finance.'.$media.".verified" => "Yes"
					);
				}elseif($response=="Reject"){
					$data = array(
						$media.".verified" => "No",
						'finance.'.$media.".verified" => "Yes"						
					);
				}
				$details = Details::find('first',array(
					'conditions'=>array(
						'_id'=>$id
					)
				))->save($data);
			}
			
			$details = Details::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			));

		$image_utility = File::find('first',array(
			'conditions'=>array('details_'.$media.'_id'=>(string)$details['_id'])
		));
		if($image_utility['filename']!=""){
				$imagename_utility = $image_utility['_id'].'_'.$image_utility['filename'];
				$path = LITHIUM_APP_PATH . '/webroot/documents/'.$imagename_utility;
				file_put_contents($path, $image_utility->file->getBytes());
		}
			$this->_render['layout'] = 'image';


			return compact('imagename_utility','media','id','details');
	}

}?>