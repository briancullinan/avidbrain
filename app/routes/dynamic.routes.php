<?php

	if(empty($app->user->email) && isset($definedRoute->protected) && $definedRoute->protected==true){

		$app->map($definedRoute->route, function() use($app,$definedRoute,$template){

			$app->redirect('/login');

		})->via('GET');

	}
	elseif(isset($app->user->email) && isset($definedRoute->protected) && $definedRoute->protected==true && isset($definedRoute->permissions) && !empty($definedRoute->permissions) && !in_array($app->user->usertype, $definedRoute->permissions)){
		/*
			Hello darkness, my old friend
			I've come to talk with you again
			Because a vision softly creeping
			Left its seeds while I was sleeping
			And the vision that was planted in my brain
			Still remains
			Within the sound of silence
		*/
	}
	else{

		if(isset($definedRoute->type)){
			$viaMethod = $definedRoute->type;
		}
		else{
			$viaMethod = array('GET', 'POST');
		}

		if(isset($definedRoute->template)){
			$template = $definedRoute->template;
		}
		else{
			$template = $app->settings['template'];
		}

		$app->map($definedRoute->route, function() use($app,$definedRoute,$template){
			$app->target = buildpaths($definedRoute,$app->dependents->APP_PATH,$app->user);
			$router = $app->router();
			$getParams = $router->getCurrentRoute()->getParams();
			if(isset($definedRoute->params)){
				foreach($definedRoute->params as $add => $param){
					$getParams[$add] = $param;
				}
			}
			$app->parameters = $getParams;

			include($app->dependents->APP_PATH.'navigation/navigation.basics.wild.php');

			$values = array();
			$values['app'] = $app;
			if(is_array($app->parameters)){
				foreach($app->parameters as $key =>$value){
					if(isset($value) && !empty($value)){
						$values[$key] = $value;
						$$key = $value;
					}
					else{
						$values[$key] = NULL;
						$$key = NULL;
					}
				}
			}

			if(file_exists($app->target->root)){
				include($app->target->root);
			}
			if(file_exists($app->target->action)){
				include($app->target->action);
			}
			if($app->request->isPost()==true && file_exists($app->target->post)){
				if($app->request->isAjax()==true){
					include($app->target->post);
					exit;
				}
				else{
					include($app->target->post);
				}
			}
		    $app->render($template,$values);
		})->via($viaMethod);

	}
