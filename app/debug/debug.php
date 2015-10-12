<?php

#ini_set('display_errors', 1);
#ini_set('log_errors', 1);
#error_reporting(E_ALL);

	set_error_handler("errorHandler",$app->request->isAjax());
	register_shutdown_function("fatalHandler",$app);

	function errorHandler($errno, $errstr, $errfile = '', $errline = 0, $errcontext = NULL,$isajax,$app) {
		$erros = array(
			'Error Number'=>$errno,
			'Message'=>$errstr,
			'File'=>$errfile,
			'Line'=>$errline
		);
		if(empty($app->dependents->DEBUG)){

			$message = '';
			foreach($erros as $key=> $mitem){
				$message.= '<p>'.$key.': '.$mitem.'</p>';
			}
			$app->mailgun->to = 'david@avidbrain.com';
			$app->mailgun->subject = 'AvidBrain Error';
			$app->mailgun->message = $message;
			$app->mailgun->send();

			$pathinfo = (object)array();
			$pathinfo->url = '/errors';
			$pathinfo->include = 'errors';
			$pathinfo->slug = 'errors';
			$app->target = buildpaths($pathinfo,$app->dependents->APP_PATH,NULL);
			//killallcookies();
			$app->render(
		    	$app->settings['template'],
		    	array('app'=>$app)
		    );
		}
		elseif(isset($isajax) && $isajax==true){
			echo json_encode($erros);
		}
		else{
			echo '<pre>'; print_r($erros); echo '</pre>';
			exit;
		}
	}
	function fatalHandler($app) {

		//$app->whoops->handleShutdown();

		$isajax = $app->request->isAjax();
	    $error = error_get_last();
	    if($error) errorHandler($error["type"], $error["message"], $error["file"], $error["line"],NULL,$isajax);
	}

	$app->notFound(function () use ($app) {
		$pathinfo = (object)array();
		$pathinfo->url = '/page-not-found';
		$pathinfo->include = 'page-not-found';
		$pathinfo->slug = 'page-not-found';
		$app->target = buildpaths($pathinfo,$app->dependents->APP_PATH,NULL);
		include($app->target->action);
	    $app->render(
	    	$app->settings['template'],
	    	array('app'=>$app)
	    );
	});

	$app->error(function (\Exception $error) use ($app) {
		errorHandler($error->getCode(),$error->getMessage(),$error->getFile(),$error->getLine(),$error->getTrace(),$app->request->isAjax(),$app);
	});
