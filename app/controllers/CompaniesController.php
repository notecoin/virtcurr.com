<?php
namespace app\controllers;
use app\models\Countries;

class CompaniesController extends \lithium\action\Controller {

	public function index(){

		$SelectedCountry = Countries::find('first',array(
		'conditions'=>array('ISO'=>strtoupper(SUBDOMAIN))
		));
		return compact('SelectedCountry');
	}
}
?>