<?php
namespace app\extensions\action;

use lithium\storage\Session;
use app\extensions\action\Bitcoin;
use app\models\Users;
use lithium\data\Connections;

class Functions extends \lithium\action\Controller {

	public function roman($integer, $upcase = true){
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
		$return = '';
		while($integer > 0){
			foreach($table as $rom=>$arb){
				if($integer >= $arb){
					$integer -= $arb;
					$return .= $rom;
					break;
				}
			}
		}
		return $return;
	} 



	function get_ip_address() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}

	public function ip_location($ip=null){
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://api.hostip.info/get_json.php?ip='.$ip.'&position=true', false, $context);
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'http://api.hostip.info/get_json.php?ip='.$ip.'&position=true');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			
			
			$jdec = (array)json_decode($json);			
			return compact('jdec');
	}
	
	public function ip2location($ip=null){
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			//http://api.ipinfodb.com/v3/ip-city/?key=40b69b063becff17998e360d05f48a31814a8922db3f33f5337ceb45542e2b42&ip=74.125.45.100&format=json
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'http://api.ipinfodb.com/v3/ip-city/?key='.IP_INFO_DB.'&ip='.$ip.'&format=json');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);
// display file
			$json = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key='.IP_INFO_DB.'&ip='.$ip.'&format=json', false, $context);
			$jdec = (array)json_decode($json);			
			return compact('jdec');
	}
		

	public function toFriendlyTime($seconds) {
	  $measures = array(
		'year'=>24*60*60*30*12,	  	  
		'month'=>24*60*60*30,	  
		'day'=>24*60*60,
		'hour'=>60*60,
		'minute'=>60,
		'second'=>1,
		);
	  foreach ($measures as $label=>$amount) {
		if ($seconds >= $amount) {  
		  $howMany = floor($seconds / $amount);
		  return $howMany." ".$label.($howMany > 1 ? "s" : "");
		}
	  } 
	  return "now";
	}   

		public function number_to_words($number) {
	   
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);
	   
		if (!is_numeric($number)) {
			return false;
		}
	   
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . $this->number_to_words(abs($number));
		}
   
		$string = $fraction = null;
	   
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->number_to_words($remainder);
				}
				break;
		}
	   
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
	   
		return $string;
	}
	

	public function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map($this->objectToArray, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
	
	public function arrayToObject($d) {
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return (object) array_map($this->arrayToObject, $d);
		}
		else {
			// Return object
			return $d;
		}
	}
			public function OnlineUsers(){
			$dataFile = LITHIUM_APP_PATH . '/webroot/qrcode/out/visitors.txt';
//			print_r($dataFile);
			$sessionTime = 30; //this is the time in **minutes** to consider someone online before removing them from our file

			if(!file_exists($dataFile)) {
				$fp = fopen($dataFile, "w+");
				fclose($fp);
			}
			$ip = $_SERVER['REMOTE_ADDR'];
			$users = array();
			$onusers = array();
			
			//getting
			$fp = fopen($dataFile, "r");
			flock($fp, LOCK_SH);
			while(!feof($fp)) {
				$users[] = rtrim(fgets($fp, 32));
			}
			flock($fp, LOCK_UN);
			fclose($fp);

			
			//cleaning
			$x = 0;
			$alreadyIn = FALSE;
			foreach($users as $key => $data) {
				list( , $lastvisit) = explode("|", $data);
				if(time() - $lastvisit >= $sessionTime * 60) {
					$users[$x] = "";
				} else {
					if(strpos($data, $ip) !== FALSE) {
						$alreadyIn = TRUE;
						$users[$x] = "$ip|" . time(); //updating
					}
				}
				$x++;
			}
			
			if($alreadyIn == FALSE) {
				$users[] = "$ip|" . time();
			}
			
			//writing
			$fp = fopen($dataFile, "w+");
			flock($fp, LOCK_EX);
			$i = 0;
			foreach($users as $single) {
				if($single != "") {
					fwrite($fp, $single . "\r\n");
					$i++;
				}
			}
			flock($fp, LOCK_UN);
			fclose($fp);
			
			if($uo_keepquiet != TRUE) {
				return $i;
			}
	
	}

}
?>