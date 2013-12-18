<?php
namespace app\models;
use lithium\util\Validator;
use lithium\util\String;

class Companies extends \lithium\data\Model {

	protected $_schema = array(
		'_id'	=>	array('type' => 'id'),
		'subname'	=>	array('type' => 'string', 'null' => false),
		'password'	=>	array('type' => 'string', 'null' => false),
		'firstname'	=>	array('type' => 'string', 'null' => false),
		'lastname'	=>	array('type' => 'string', 'null' => false),
		'email'	=>	array('type' => 'string', 'null' => false),		
		'updated'	=>	array('type' => 'datetime', 'null' => false),
		'created'	=>	array('type' => 'datetime', 'null' => false),
		'verified'	=>	array('type' => 'string', 'null' => true),
		'CompanyName'	=>	array('type' => 'string', 'null' => false),		
		'CompanyAddress'	=>	array('type' => 'string', 'null' => false),		
		'CompanyStreet'	=>	array('type' => 'string', 'null' => false),		
		'CompanyCity'	=>	array('type' => 'string', 'null' => false),		
		'CompanyZip'	=>	array('type' => 'string', 'null' => false),		
		'CompanyCountry'	=>	array('type' => 'string', 'null' => false),		
		'CompanyISO'	=>	array('type' => 'string', 'null' => false),				
		'Active'	=>	array('type' => 'boolean', 'null' => false),						
		'mobile'	=>	array('type' => 'string', 'null' => false),		
		'ip'	=>	array('type' => 'string', 'null' => true),		
	);

	protected $_meta = array(
		'key' => '_id',
		'locked' => true
	);

	public $validates = array(
		'firstname' => array(
			array('notEmpty', 'message' => 'Please enter your First Name'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		'lastname' => array(
			array('notEmpty', 'message' => 'Please enter your Last Name'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		'email' => array(
			array('uniqueEmail', 'message' => 'This Email is already used'),
			array('notEmpty', 'message' => 'Please enter your email address'),			
			array('email', 'message' => 'Not a valid email address'),						
		),
		'password' => array(
			array('notEmpty', 'message' => 'Please enter a password'),
			array('alphaNumeric', 'message' => 'Please use only alphanumeric characters'),
			array('passwordVerification', 'message' => 'Passwords are not the same'),
//			array('lengthBetween', 'message' => 'Password should be between 4 to 20 characters, will be used as a subdomain name!', 'max'=>20,'min'=>4),

		),
		'subname' => array(
			array('uniqueSubname', 'message' => 'This Sub-Domain name is already taken'),
			array('notEmpty', 'message' => 'Please enter a Sub-Domain name'),
			array('alphaNumeric', 'message' => 'Please use only alphanumeric characters'),
			array('lengthBetween', 'message' => 'Sub-Domain should be between 4 to 20 characters, will be used as a subdomain/username name!', 'max'=>20,'min'=>4),
		),
		'mobile' => array(
			array('notEmpty', 'message' => 'Please enter mobile number'),			
			array('lengthBetween','min'=>10, 'message'=>'At least 10 characters'),
		),
		'CompanyName' => array(
			array('notEmpty', 'message' => 'Please enter Company Name'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		'CompanyAddress' => array(
			array('notEmpty', 'message' => 'Please enter Address'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		'CompanyStreet' => array(
			array('notEmpty', 'message' => 'Please enter Street'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		'CompanyCity' => array(
			array('notEmpty', 'message' => 'Please enter City'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		'CompanyZip' => array(
			array('notEmpty', 'message' => 'Please enter Zip - Postal Code'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		'CompanyCountry' => array(
			array('notEmpty', 'message' => 'Country'),			
			array('lengthBetween','min'=>2, 'message'=>'At least 2 characters'),
		),
		
		);
	}

	Validator::add('passwordVerification', function($value, $rule, $options) {
		if(!isset($options['values']['password2']) || $value==$options['values']['password2']){ 
			return true;
		}else{
			return false;
		}
	});

	Validator::add('uniqueSubname', function($value, $rule, $options) {
		$conflicts = Companies::count(array('subname' => $value));
		if($conflicts) return false;
		return true;
	});

	Validator::add('uniqueEmail', function($value, $rule, $options) {
		$conflicts = Companies::count(array('email' => $value));
		if($conflicts) return false;
		return true;
	});
	Companies::applyFilter('save', function($self, $params, $chain) {
		if ($params['data']) {
			$params['entity']->set($params['data']);
			$params['data'] = array();
		}
		if (!$params['entity']->exists()) {
			$params['entity']->password = String::hash($params['entity']->password);
			$params['entity']->password2 = String::hash($params['entity']->password2);		
			$params['entity']->created = new \MongoDate();
			$params['entity']->Active = false;
			$params['entity']->updated = new \MongoDate();
			$params['entity']->ip = $_SERVER['REMOTE_ADDR'];
		}
//		print_r($params['entity']->Company.Name);
		return $chain->next($self, $params, $chain);
	});
?>