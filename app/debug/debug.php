<?php

#ini_set('display_errors', 1);
#ini_set('log_errors', 1);
#error_reporting(E_ALL);

	function geterrortype($number){
		$errornumbers = array(
			1=>'E_ERROR || Fatal run-time errors. These indicate errors that can not be recovered from, such as a memory allocation problem. Execution of the script is halted.',
			2=>'E_WARNING || Run-time warnings (non-fatal errors). Execution of the script is not halted.',
			4=>'E_PARSE || Compile-time parse errors. Parse errors should only be generated by the parser.',
			8=>'E_NOTICE || Run-time notices. Indicate that the script encountered something that could indicate an error, but could also happen in the normal course of running a script.',
			16=>'E_CORE_ERROR || Fatal errors that occur during PHPs initial startup. This is like an E_ERROR, except it is generated by the core of PHP.',
			32=>'E_CORE_WARNING || Warnings (non-fatal errors) that occur during PHPs initial startup. This is like an E_WARNING, except it is generated by the core of PHP.',
			64=>'E_COMPILE_ERROR || Fatal compile-time errors. This is like an E_ERROR, except it is generated by the Zend Scripting Engine.',
			128=>'E_COMPILE_WARNING || Compile-time warnings (non-fatal errors). This is like an E_WARNING, except it is generated by the Zend Scripting Engine.',
			256=>'E_USER_ERROR || User-generated error message. This is like an E_ERROR, except it is generated in PHP code by using the PHP function trigger_error().',
			512=>'E_USER_WARNING || User-generated warning message. This is like an E_WARNING, except it is generated in PHP code by using the PHP function trigger_error().',
			1024=>'E_USER_NOTICE || User-generated notice message. This is like an E_NOTICE, except it is generated in PHP code by using the PHP function trigger_error().',
			2048=>'E_STRICT || Enable to have PHP suggest changes to your code which will ensure the best interoperability and forward compatibility of your code.',
			4096=>'E_RECOVERABLE_ERROR || Catchable fatal error. It indicates that a probably dangerous error occurred, but did not leave the Engine in an unstable state. If the error is not caught by a user defined handle (see also set_error_handler()), the application aborts as it was an E_ERROR.',
			8192=>'E_DEPRECATED || Run-time notices. Enable this to receive warnings about code that will not work in future versions.',
			16384=>'E_USER_DEPRECATED || User-generated warning message. This is like an E_DEPRECATED, except it is generated in PHP code by using the PHP function trigger_error().',
			32767=>'E_ALL || All errors and warnings, as supported, except of level E_STRICT prior to PHP 5.4.0.',
			666 =>'UNKNOWN_ERROR || There was no error number provided.'
		);
		if(isset($number) && !empty($errornumbers[$number])){
			return $errornumbers[$number];
		}
		else{
			return $errornumbers[666];
		}

	}

	set_error_handler("errorHandler",$app->request->isAjax());
	register_shutdown_function("fatalHandler",$app);

	function errorHandler($errno=NULL, $errstr=NULL, $errfile = '', $errline = 0, $errcontext = NULL,$isajax=NULL,$app=NULL) {

		$type = geterrortype($errno);
		$typeEx = explode(' || ',$type);
		$additional = [];
		if(isset($typeEx[0])){
			$additional['type'] = $typeEx[0];
		}
		if(isset($typeEx[1])){
			$additional['text'] = $typeEx[1];
		}

		$erros = array(
			'Error Number'=>$type,
			'Message'=>$errstr,
			'File'=>$errfile,
			'Line'=>$errline,
			'Additional'=>$additional
		);

		if(empty($app->dependents->DEBUG)){

			if(isset($erros['Additional']['type']) && $erros['Additional']['type']=='E_NOTICE'){
				$app->render(
			    	$app->settings['template'],
			    	array('app'=>$app)
			    );
			}
			else{
				$message = '<p>Page: '.$app->request->getPath().'</p>';
				if(isset($app->user->email)):$message.= '<p>User: '.$app->user->email.'</p>';endif;
				if(isset($app->user->usertype)):$message.= '<p> Usertype: '.$app->user->usertype.'</p>';endif;
				$message.= '<p>Date: '.formatdate(thedate(),'M. jS, Y @ g:i a').'</p>';
				$message.= '<p>Domain: '.$app->dependents->DOMAIN.'</p>';
				$message.= '<p>Server Name: '.$app->dependents->SERVER_NAME.'</p>';

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


		if(isset($app->dependents->DEBUG) && $app->dependents->DEBUG == true){
			$app->whoops->handleShutdown();
		}

		$isajax = $app->request->isAjax();
	    $error = error_get_last();
		if(!empty($error)){


			$message = '<p>Page: '.$app->request->getPath().'</p>';
			if(isset($app->user->email)):$message.= '<p>User: '.$app->user->email.'</p>';endif;
			if(isset($app->user->usertype)):$message.= '<p> Usertype: '.$app->user->usertype.'</p>';endif;
			$message.= '<p>Date: '.formatdate(thedate(),'M. jS, Y @ g:i a').'</p>';
			$message.= '<p>Domain: '.$app->dependents->DOMAIN.'</p>';
			$message.= '<p>Server Name: '.$app->dependents->SERVER_NAME.'</p>';
			$message.= '<p>Type: '.geterrortype($error['type']).'</p>';
			$message.= '<p>Message: '.$error['message'].'</p>';
			$message.= '<p>File: '.$error['file'].'</p>';
			$message.= '<p>Line: '.$error['line'].'</p>';


			$app->mailgun->to = 'david@avidbrain.com';
			$app->mailgun->subject = 'AvidBrain Fatal Error';
			$app->mailgun->message = $message;
			$app->mailgun->send();

			$_SESSION['slim.flash']['error'] = '<i class="fa fa-flash orange-text"></i> Whoops, there was an error';
			header("Location: /errors");
		}

	}

	$app->notFound(function () use ($app) {
		$pathinfo = (object)array();
		$pathinfo->url = '/page-not-found';
		$pathinfo->include = 'page-not-found';
		$pathinfo->slug = 'page-not-found';
		$app->target = buildpaths($pathinfo,$app->dependents->APP_PATH,NULL);
		include($app->dependents->APP_PATH.'navigation/navigation.basics.wild.php');
		include($app->target->action);
	    $app->render(
	    	$app->settings['template'],
	    	array('app'=>$app)
	    );
	});

	$app->error(function (\Exception $error) use ($app) {
		errorHandler($error->getCode(),$error->getMessage(),$error->getFile(),$error->getLine(),$error->getTrace(),$app->request->isAjax(),$app);
	});
