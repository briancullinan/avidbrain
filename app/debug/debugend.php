<?php

$app->notFound(function () use ($app) {
	$pathinfo = (object)array();
	$pathinfo->url = '/page-not-found';
	$pathinfo->include = 'page-not-found';
	$pathinfo->slug = 'page-not-found';
	$app->target = buildpaths($pathinfo,APP_PATH,NULL);
	include($app->dependents->APP_PATH.'navigation/navigation.basics.wild.php');
	include($app->target->action);
	$app->render(
		$app->settings['template'],
		array('app'=>$app)
	);
});

function fatal_error_handler($buffer){
	$error=error_get_last();
	if($error['type'] == 1){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$error['AJAXERRORS'] = true;
			$string = json_encode($error);
		}
		else{

			$string ='<pre class="handle-errors">';


			$geterrortype = geterrortype($error['type']);
			$key = key($geterrortype);
			$errortext = $geterrortype[$key];


			$string.= '<div class="error">Date: '.thedate().'</div>';
			$string.= '<div class="error">Error Message: '.$errortext.'</div>';
			$string.= '<div class="error">Error Type: '.$key.'</div>';
			$string.= '<div class="error">Error Line: '.$error['line'].'</div>';
			$string.= '<div class="error">Error File: '.$error['file'].'</div>';

			$message = explode("\n",$error['message']);
			foreach($message as $go){
				$string.='<div class="error">'.$go.'</div>';
			}

			if(isset($_SERVER['HTTP_REFERER'])){
				$string.= '<div class="error">HTTP_REFERER: '.$_SERVER['HTTP_REFERER'].'</div>';
			}
			if(isset($_SERVER['SCRIPT_FILENAME'])){
				$string.= '<div class="error">SCRIPT_FILENAME: '.$_SERVER['SCRIPT_FILENAME'].'</div>';
			}
			if(isset($_SERVER['REMOTE_ADDR'])){
				$string.= '<div class="error">REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR'].'</div>';
			}
			if(isset($_SERVER['REQUEST_URI'])){
				$string.= '<div class="error">REQUEST_URI: '.$_SERVER['REQUEST_URI'].'</div>';
			}

			$config = new \Doctrine\DBAL\Configuration();
			$connectionParams = array(
				'dbname' => 'avidbrain',
				'user' => DBUSER,
				'password' => DBPASS,
				'host' => HOST,
				'port' => PORT,
				'charset' => CHARSET,
				'driver' => 'pdo_mysql'
			);
			$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
			$conn->setFetchMode(PDO::FETCH_OBJ);
			phpFastCache::setup("storage","auto");
			$conn->cache = new phpFastCache();
			$crypter = new Crypter(SALT, MCRYPT_RIJNDAEL_256);
			$app->user = new User($conn,$crypter);
			if(isset($app->user->email)){
				$string.= '<div>User Email: '.$app->user->email.'</div>';
			}
			if(isset($app->user->usertype)){
				$string.= '<div>User Type: '.$app->user->usertype.'</div>';
			}



			$string.='</pre>';

			$maiglunarray = array('MAILGUN_KEY'=>MAILGUN_KEY,'APP_PATH'=>APP_PATH,'SYSTEM_EMAIL'=>SYSTEM_EMAIL,'MAILGUN_DOMAIN'=>MAILGUN_DOMAIN,'MAILGUN_DOMAIN'=>MAILGUN_DOMAIN,'MAILGUN_PUBLIC'=>MAILGUN_PUBLIC);
			$mailgun = new Email($maiglunarray);
			$mailgun->to = 'david@avidbrain.com';
			$mailgun->subject = 'MindSpree Fatal Error';
			$mailgun->message = $string;
			$mailgun->send();

			$string.= '<style type="text/css">html,body{margin:0px;padding:0px;}.handle-errors{margin:0px;box-sizing:border-box;background:#222;color:#ccc;position:fixed;bottom:0px;left:0px;width:100%;padding:20px;}</style>';


		}
	}

	if(isset($string)){
		$buffer = $string;
	}

	if(DEBUG==false && isset($string)){
		$buffer = file_get_contents(APP_PATH.'views/whoops.html');
	}

	return $buffer;
}


ob_start('fatal_error_handler');
