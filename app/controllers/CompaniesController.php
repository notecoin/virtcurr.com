<?php
namespace app\controllers;
use app\models\Countries;
use app\models\Ipaddresses;
use app\models\Companies;

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
		foreach($Country as $CC){
			$CountryISO = $CC['ISO'];
		}
		$MyCountry = Countries::find('first',array(
			'conditions'=>array('ISO'=>$CountryISO)
		));

		$SelectedCountry = Countries::find('first',array(
		'conditions'=>array('ISO'=>strtoupper(SUBDOMAIN))
		));
		
		$Companies = Companies::find('all',array(
			'conditions'=>array('ISO'=>strtoupper(SUBDOMAIN))
		));
		return compact('SelectedCountry','MyCountry','IP','Companies');
	}
}
?>