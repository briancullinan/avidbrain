<?php

	if($app->request->isPost()==true){
		
		$key = key($_POST);
		
		$post = makepost(json_decode(json_encode($app->request->params($key)),FALSE));
		$app->keyname = $key;
		$app->$key = $post;
		
		if(isset($_POST['stripeToken'])){
			$app->stripe = new stdClass();
			$app->stripe->stripeToken = $_POST['stripeToken'];
			if(isset($_POST['stripeTokenType'])){
				$app->stripe->stripeTokenType = $_POST['stripeTokenType'];	
			}
			if(isset($_POST['stripeEmail'])){
				$app->stripe->stripeEmail = $_POST['stripeEmail'];	
			}
		}
		
		$flash = NULL;
		if($app->request->isAjax()==false){
			$flash=true;
		}

		if(isset($app->$key->target)){

			$formname = $app->$key->target;
			$submittedData = $app->$key;

			$formPost = new Forms($app->connect);
			$formPost->formname = $formname;
			$formPost->url = NULL;
			$formPost->dependents = $app->dependents;
			$formPost->build = false;
			$formPost->makeform();
			
			if(isset($formPost->questions[0])){
				foreach($formPost->questions as $key => $value){
					$nameValue = $value->name;
	
					if(isset($value->required) && empty($submittedData->$nameValue)){
	
						$required = (object)array(
							'flash'=>$flash,
							'action'=>'required',
							'formID'=>$formname,
							'field'=>'field_'.$formname.'_'.$value->name,
							'input'=>$formname.'_'.$value->name,
							'message'=>$value->required_text
						);
						if(isset($flash)){
							$required->error_message = $value->required_text;
							$required->postdata = $submittedData;
						}
						notify($required);
						if(isset($flash)){
							
							redirect($app->dependents->DOMAIN.$app->request->getPath());
							
						}
	
					}
					elseif(isset($value->required) && isset($value->extra) && $extras=json_decode($value->extra)){
						$tempvarKEY = array();
						$tempvarVALUE = array();
						foreach($extras as $key=> $valueExtra){
							$tempvarKEY[] = $key;
							$tempvarVALUE[] = $valueExtra;
						}
						if(!in_array($submittedData->$nameValue, $tempvarKEY) && !in_array($submittedData->$nameValue, $tempvarVALUE)){
							$required = (object)array(
								'flash'=>$flash,
								'action'=>'required',
								'formID'=>$formname,
								'field'=>'field_'.$formname.'_'.$value->name,
								'input'=>$formname.'_'.$value->name,
								'message'=>'Invalid Input'
							);
							notify($required);
						}
	
					}
	
				}
			}

		}


	}