<?php
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
	session_regenerate_id();
	session_cache_limiter(false);
	session_start();
		require '../vendor/autoload.php';
		require('../app/dependents/dependents.php');
	$app = new \Slim\Slim();
		require('../app/dependents/dependent-files.php');
	$app->dependents = $dependents;
	$app->config(array(
	    'debug' => true,
	    'mode'=>'development',
	    'templates.path' => $app->dependents->APP_PATH.'/views'
	));
	$app->log->setEnabled(true);
	use \Slim\Extras\Middleware\CsrfGuard;
	use \Slim\Extras\Middleware\HttpBasicAuth;
	$app->add(new HttpBasicAuth('avidbrain', 'tutornode'));
	$app->add(new CsrfGuard());
	if($app->request->getMethod()=='POST' && $app->request->isAjax()==true){
		header('Content-type: application/json');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}
	
	include($app->dependents->APP_PATH.'functions/global.functions.php');
	require '../app/autoload/autoload.php';
	
	//killallcookies();

	// Global Database Connection
	define('PREFIX', 'avid___');
	use Doctrine\Common\ClassLoader;
	$config = new \Doctrine\DBAL\Configuration();
	$connectionParams = array(
	    'dbname' => 'avidbrain',
	    'user' => $app->dependents->database->DBUSER,
	    'password' => $app->dependents->database->DBPASS,
	    'host' => $app->dependents->database->HOST,
	    'port' => $app->dependents->database->PORT,
	    'charset' => $app->dependents->database->CHARSET,
	    'driver' => 'pdo_mysql',
	    'prefix'=>PREFIX
	);
	\Stripe\Stripe::setApiKey($app->dependents->stripe->STRIPE_SECRET);
	$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
	$conn->setFetchMode(PDO::FETCH_OBJ);
	$app->connect = $conn;
	
		phpFastCache::setup("storage","auto");
		$app->connect->cache = new phpFastCache();
	
	$app->crypter = new Crypter($app->dependents->SALT, MCRYPT_RIJNDAEL_256);
	$app->user = new User($app->connect,$app->crypter);
	$app->mailgun = new Email($app->dependents);
	$app->sendmessage = new SendMessage($app->connect);
	$app->twilio = new Services_Twilio($app->dependents->twilio->id, $app->dependents->twilio->auth_token);
	
	use Intervention\Image\ImageManager;
	$app->imagemanager = new ImageManager(array('driver' => 'imagick'));
	
	// Contest / Giveaway
	$app->contest = new stdClass();
	//$app->contest->ipadgiveaway = true;
	
	// Twitters
	use Abraham\TwitterOAuth\TwitterOAuth;
	//$app->connect->cache->delete("my_tweets");
	$app->my_tweets = $app->connect->cache->get("my_tweets");
	//notify($app->my_tweets);
	if($app->my_tweets == null){
		$connection = new TwitterOAuth('Us5wwKQrRRpT6zSdcznwHI84k', 'M3826Tuq5AniP0KuMBllwButIvGn0W8p0XWxqRVQh67fMhsKAL', '2840761432-fmuW8KuLUPa6aBuzlD7pTk6ttoJLQ9LuAej3vWP', 'veyYK8Hciun1ELTHdf3yzoFsxm2Ny6K5kYgX0ceuM0tWK');
		$content = $connection->get("account/verify_credentials");
		$twitterAPI = $connection->get('statuses/user_timeline', array('screen_name' => 'avidbrain', 'count' => 5));
	    $app->my_tweets = $twitterAPI;
	    $app->connect->cache->set("my_tweets", $twitterAPI, 3600);
	}
	
	use MatthiasMullie\Minify;
	//$minifyme = true;
	//$app->minify = true;
	if(isset($minifyme)){
			
		$minifier = new Minify\CSS();
		foreach($app->header->localcss as $cssfile){
			$minifier->add($app->dependents->DOCUMENT_ROOT.'css/'.$cssfile);
		}
		$minifier->minify($app->dependents->DOCUMENT_ROOT.'css/final.'.$app->dependents->VERSION.'.css');
		
		$minifier = new Minify\JS();
		foreach($app->header->localjs as $jsfiles){
			$minifier->add($app->dependents->DOCUMENT_ROOT.'js/'.$jsfiles);
		}
		$minifier->minify($app->dependents->DOCUMENT_ROOT.'js/final.'.$app->dependents->VERSION.'.js');
		notify('ALL DONE');
		exit;
	}
	
 	#$app->connect->cache->clean();
	#exit;

	if(isset($app->user->email)){
		include($app->dependents->APP_PATH.'validate/validate.user.php');
	}
	include($app->dependents->APP_PATH.'validate/validate.post.php');
	include($app->dependents->APP_PATH.'routes/page.routes.php');
	$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);
	include($app->dependents->APP_PATH.'debug/debug.php');
	include($app->dependents->APP_PATH.'debug/fixes.php');
	$app->run();