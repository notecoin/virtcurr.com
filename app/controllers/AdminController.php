<?php
namespace app\controllers;
use app\models\Countries;
use app\models\Templates;
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
}?>