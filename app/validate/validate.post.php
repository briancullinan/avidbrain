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

		if(!empty($app->$key->target)){
			$formname = $app->$key->target;
			$submittedData = $app->$key;

			$formPost = new Forms($app->connect);
			$formPost->formname = $formname;
			$formPost->url = NULL;
			$formPost->build = false;
			$formPost->makeform();

			if(!empty($formPost->questions)){
				foreach($formPost->questions as $questionKey => $question){
					$formValue = $question->name;
					$submittedValue = $submittedData->$formValue;
					if(isset($question->required) && empty($submittedValue)){
						$required = (object)array(
							'flash'=>$flash,
							'action'=>'required',
							'formID'=>$formname,
							'field'=>'field_'.$formname.'_'.$question->name,
							'input'=>$formname.'_'.$question->name,
							'message'=>$question->required_text
						);
						if(isset($flash)){
							$required->error_message = $question->required_text;
							$required->postdata = $submittedData;
						}
						notify($required);
						if(isset($flash)){

							redirect(DOMAIN.$app->request->getPath());

						}
					}
					elseif(isset($question->required) && isset($question->extra) && $extras=json_decode($question->extra)){
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
								'field'=>'field_'.$formname.'_'.$question->name,
								'input'=>$formname.'_'.$question->name,
								'message'=>'Invalid Input'
							);
							notify($required);
						}

					}
				}
			}
		}

	}
