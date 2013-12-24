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


class CompanyController extends \lithium\action\Controller {
	public function commissions(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		if($this->request->data){
			$i = 0;
			$commissions = array();
			foreach ($this->request->data['transact'] as $key=>$val){
				$commissions[$key]['transact'] = (float)$val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['percent'] as $key=>$val){
				$commissions[$key]['percent'] = (float)$val;
				$i++;
			}
		}
		$commissions[$i]['base'] = 0.1;
		$data = array(
			'commissions'=>$commissions
		);

		$settings = Settings::find('all',array(
			'conditions'=>array('subname'=>$user['subname'])
		))->save($data);
		$this->redirect('users::settings');
	}
	public function trades(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		if($this->request->data){

			$trades = array();
			$i = 0;
			foreach ($this->request->data['trade'] as $key=>$val){
				$trades[$key]['trade'] = $val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['refresh'] as $key=>$val){
				$trades[$key]['refresh'] = (boolean)$val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['First'] as $key=>$val){
				$trades[$key]['First'] = $val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['Second'] as $key=>$val){
				$trades[$key]['Second'] = $val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['active'] as $key=>$val){
				$trades[$key]['active'] = (boolean)$val;
				$i++;
			}
			
		}
		$data = array(
			'trades'=>$trades
		);

		$settings = Settings::find('all',array(
			'conditions'=>array('subname'=>$user['subname'])
		))->save($data);
//s		exit;
		$this->redirect('users::settings');
	}
	
	public function txfees(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		if($this->request->data){

			$txfees = array();
			$i = 0;
			foreach ($this->request->data['fee'] as $key=>$val){
				$txfees[$key]['fee'] = (float)$val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['name'] as $key=>$val){
				$txfees[$key]['name'] = $val;
				$i++;
			}		
		$data = array(
			'txfees'=>$txfees
		);

		$settings = Settings::find('all',array(
			'conditions'=>array('subname'=>$user['subname'])
		))->save($data);
		}
			
	$this->redirect('users::settings');
	}
	public function documents(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		if($this->request->data){

			$documents = array();
			$i = 0;
			foreach ($this->request->data['name'] as $key=>$val){
				$documents[$key]['name'] = $val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['id'] as $key=>$val){
				$documents[$key]['id'] = $val;
				$i++;
			}		
			$i = 0;
			foreach ($this->request->data['required'] as $key=>$val){
				$documents[$key]['required'] = (boolean)$val;
				$i++;
			}				
			$i = 0;
			foreach ($this->request->data['alias'] as $key=>$val){
				$documents[$key]['alias'] = $val;
				$i++;
			}					
		$data = array(
			'documents'=>$documents
		);

		$settings = Settings::find('all',array(
			'conditions'=>array('subname'=>$user['subname'])
		))->save($data);
		}
			
	$this->redirect('users::settings');
	}
	

	public function limits(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		if($this->request->data){
			$i = 0;
			$limits = array();
			foreach ($this->request->data['name'] as $key=>$val){
				$limits[$key]['name'] = $val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['deposit'] as $key=>$val){
				$limits[$key]['deposit'] = (float)$val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['withdrawal'] as $key=>$val){
				$limits[$key]['withdrawal'] = (float)$val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['allow'] as $key=>$val){
				$limits[$key]['allow'] = (boolean)$val;
				$i++;
			}

		}
		$data = array(
			'limits'=>$limits
		);

		$settings = Settings::find('all',array(
			'conditions'=>array('subname'=>$user['subname'])
		))->save($data);
		$this->redirect('users::settings');
	}

	public function denominations(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		if($this->request->data){
			$i = 0;
			$denominations = array();
			foreach ($this->request->data['name'] as $key=>$val){
				$denominations[$key]['name'] = $val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['value'] as $key=>$val){
				$denominations[$key]['value'] = (float)$val;
				$i++;
			}
			$i = 0;
			foreach ($this->request->data['active'] as $key=>$val){
				$denominations[$key]['active'] = (boolean)$val;
				$i++;
			}

		}
		$data = array(
			'denominations'=>$denominations
		);

		$settings = Settings::find('all',array(
			'conditions'=>array('subname'=>$user['subname'])
		))->save($data);
		$this->redirect('users::settings');
	}

	public function friends(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		$friends = array();
		$data = array(
			'friends'=> array('allow'=>(boolean)$this->request->data['allow'])
		);
		$settings = Settings::find('all',array(
			'conditions'=>array('subname'=>$user['subname'])
		))->save($data);
		$this->redirect('users::settings');
	
	}

}
?>