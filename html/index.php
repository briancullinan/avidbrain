<?php
	//echo 'AvidBrain Under Maintanance. Please Hold On.';exit;
	header('Content-Type: text/html; charset=utf-8');
	mb_internal_encoding("UTF-8");
	mb_http_output('UTF-8');
	ini_set('session.cookie_httponly','on');
	ini_set('session.use_only_cookies','on');
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'){
		ini_set('session.cookie_secure','on');
	}
	ini_set('session.cookie_lifetime',0);
	ini_set('session.use_strict_mode','on');
	ini_set('session.use_trans_sid','off');
	ini_set('session.cache_limiter','nocache');
	ini_set('session.hash_function','sha256');
	session_start();
	session_regenerate_id();
	session_cache_limiter(false);

	require '../vendor/autoload.php';
	require('../app/config/config.php');
	require '../app/autoload/autoload.php';
	require(APP_PATH.'functions/global.functions.php');
	require(APP_PATH.'dependents/avidbrain.files.php');
	require(APP_PATH.'debug/debugger.php');

	$app = new \Slim\Slim();
	$app->config($slimConfig);
	$app->header = $header;

	if($app->request->getMethod()=='POST' && $app->request->isAjax()==true){
		header('Content-type: application/json');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}
	\Stripe\Stripe::setApiKey(STRIPE_SECRET);

	use Doctrine\Common\ClassLoader;
	$config = new \Doctrine\DBAL\Configuration();
	$connectionParams = array(
	    'dbname' => DBNAME,
	    'user' => DBUSER,
	    'password' => DBPASS,
	    'host' => HOST,
	    'port' => PORT,
	    'charset' => CHARSET,
	    'driver' => 'pdo_mysql'
	);
	try{
		$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
		$conn->setFetchMode(PDO::FETCH_OBJ);
		$connecteddatabase = $conn->executeQuery("SHOW TABLES FROM avidbrain",array())->fetchALL();
		$app->connect = $conn;
		phpFastCache::setup("storage","auto");
		$app->connect->cache = new phpFastCache();
	}
	catch(Exception $e){
		include(APP_PATH.'views/whoops.html');
		exit;
	}

	$app->enableaffiliates = true;
	$app->crypter = new Crypter(SALT, MCRYPT_RIJNDAEL_256);
	$app->user = new User($app->connect,$app->crypter);
	$app->affiliate = new Affiliate($app->connect,$app->crypter);
	$app->mailgun = new Email(array('MAILGUN_KEY'=>MAILGUN_KEY,'APP_PATH'=>APP_PATH,'SYSTEM_EMAIL'=>SYSTEM_EMAIL,'MAILGUN_DOMAIN'=>MAILGUN_DOMAIN,'MAILGUN_DOMAIN'=>MAILGUN_DOMAIN,'MAILGUN_PUBLIC'=>MAILGUN_PUBLIC));
	$app->sendmessage = new SendMessage($app->connect);
	$app->twilio = new Services_Twilio(TWILIO_ID, TWILIO_AUTH_TOKEN);

	use \Slim\Extras\Middleware\CSRFNINJA;
	use \Slim\Extras\Middleware\HttpBasicAuth;
	use Intervention\Image\ImageManager;
//	$app->imagemanager = new ImageManager(array('driver' => 'imagick'));
	$app->imagemanager = new ImageManager(array('driver' => 'gd'));
	$app->add(new CSRFNINJA());

	$app->purechat = true;
	if(isset($app->user->email)){
		include(APP_PATH.'validate/validate.user.php');
	}

	$freesessions = new stdClass();
	$freesessions->enabled = true;
	$freesessions->maximum = 3000;
	$app->freesessions = $freesessions;


	//$minime = true;
	$app->minify = true;
	if(isset($minime)){
		include(APP_PATH.'minify.php');
	}


	require(APP_PATH.'validate/validate.post.php');
	require(APP_PATH.'routes/page.routes.php');
	require(APP_PATH.'debug/debugend.php');
	$app->run();
	ob_end_flush();
