<?php
	set_error_handler("errorHandler",$app->request->isAjax());
	register_shutdown_function("fatalHandler",$app);
	
	function errorHandler($errno, $errstr, $errfile = '', $errline = 0, $errcontext = array(),$isajax) {
		$erros = array(
			'Error Number'=>$errno,
			'Message'=>$errstr,
			'File'=>$errfile,
			'Line'=>$errline,
			'Stack Trace'=>$errcontext
		);
		if(isset($isajax) && $isajax==true){
			echo json_encode($erros);
		}
		else{
			echo '<pre>'; print_r($erros); echo '</pre>';
			exit;
		}
	}
	function fatalHandler($app) {
		
		$app->whoops->handleShutdown();
		
		$isajax = $app->request->isAjax();
	    $error = error_get_last();
	    if($error) errorHandler($error["type"], $error["message"], $error["file"], $error["line"],array(),$isajax);
	}
	
	$app->notFound(function () use ($app) {
		$pathinfo = (object)array();
		$pathinfo->url = '/page-not-found';
		$pathinfo->include = 'page-not-found';
		$pathinfo->slug = 'page-not-found';
		$app->target = buildpaths($pathinfo,$app->dependents->APP_PATH,NULL);
		include($app->target->action);
	    $app->render(
	    	'base-template.php',
	    	array('app'=>$app)
	    );
	});
	
	$app->error(function (\Exception $error) use ($app) {
		errorHandler($error->getCode(),$error->getMessage(),$error->getFile(),$error->getLine(),$error->getTrace(),$app->request->isAjax());
	});