<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License

 */
 use lithium\storage\Session;
 use lithium\g11n\Message;
 use lithium\core\Environment; 
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title><?php echo MAIN_TITLE;?>: <?php if(isset($title)){echo $title;} ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="<?php if(isset($keywords)){echo $keywords;} ?>">	
	<meta name="description" content="<?php if(isset($description)){echo $description;} ?>">		
	<?php echo $this->html->style(array('/bootstrap/css/bootstrap')); ?>
	<?php echo $this->html->style(array('/bootstrap/css/datepicker')); ?>	
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?php
	$this->scripts('<script src="/js/main.js?v='.rand(1,100000000).'"></script>'); 	
	$this->scripts('<script src="/bootstrap/js/jquery.js?v='.rand(1,100000000).'"></script>'); 	
	$this->scripts('<script src="/bootstrap/js/bootstrap-datepicker.js?v='.rand(1,100000000).'"></script>'); 		
	$this->scripts('<script src="/bootstrap/js/bootstrap.js"></script>'); 
	?>   		
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 20px;
      }
      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1100px;
      }
      .container > hr {
        margin: 20px 0;
      }
    </style>
</head>
<?php
//	print_r(strlen($_SERVER['REQUEST_URI']));
if(Environment::get('locale')=="en_US"){$locale = "en";}else{$locale = Environment::get('locale');}
if(Session::read('ex')==""){
		Session::write('ex','BTC/GBP');
	}else{
		if(strlen($_SERVER['REQUEST_URI'])==16 || strlen($_SERVER['REQUEST_URI'])==13){
		$request_uri = str_replace("/".$locale,"",$_SERVER['REQUEST_URI']);
		if($request_uri=="_ex"){
			$request_uri = "btc_gbp";
		}
			if($locale==""){
				$ex = str_replace("_","/",strtoupper(str_replace("/ex/x/","",$request_uri)));
			}else{
				$ex = str_replace("_","/",strtoupper(str_replace("/ex/x/","",$request_uri)));
			}
			Session::write('ex',$ex);			
		}
}
$ex = Session::read('ex');
?>

<body 
<?php if($this->_request->controller=='ex'){ ?>
onLoad="UpdateDetails('<?=$ex?>');"
<?php }?>
 style="background-image:url(/img/worldmap.png);background-position:top;background-repeat:no-repeat ">
	<?php echo  $this->_render('element', 'header');?>
	<div id="container" class="container">
		<?php 
		extract(lithium\g11n\Message::aliases());
		$user = Session::read('member'); ?>
		<?php 
		if(SUBDOMAIN!=""){
			if($this->_request->controller!='Pages' && ucwords( $this->_request->controller)!='Companies' && ucwords( $this->_request->controller)!='Users'){
				if($this->_request->action!="signin" && $this->_request->action!="signup" && $this->_request->action!="signout"){
					echo $this->_render('element', 'menu');
				}
			}
		}?>		
		<?php echo $this->content(); ?>
	</div>
	<?php echo $this->_render('element', 'footer');?>	
<?php echo $this->scripts(); ?>	
<script type="text/javascript">
$(function() {
	$('.tooltip-x').tooltip();
	$("input:text:visible:first").focus();
});
</script>
</body>
</html>