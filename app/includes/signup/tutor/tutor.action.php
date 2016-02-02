<?php

	if(isset($method) && isset($action)){
		if($action=='trash'){

			$upload = $app->dependents->APP_PATH.'uploads/photos/'.$app->newtutor->upload;
			$cropped = $app->dependents->APP_PATH.'uploads/photos/'.$app->newtutor->cropped;

			try{
				unlink($upload);
				unlink($cropped);
			}
			catch(Exception $e){
			}

			$app->connect->update('avid___new_temps',array('upload'=>NULL,'cropped'=>NULL),array('email'=>$app->newtutor->email));

			$app->redirect('/signup/tutor');
		}
		elseif($action=='crop'){

			$app->connect->update('avid___new_temps',array('cropped'=>NULL),array('email'=>$app->newtutor->email));

			$app->redirect('/signup/tutor');

		}
		elseif($action=='rotateright'){

			$cropped = $app->dependents->APP_PATH.'uploads/photos/'.$app->newtutor->cropped;
			$img = $app->imagemanager->make($cropped)->rotate(-90)->save();
			$app->redirect('/signup/tutor');

		}
		elseif($action=='rotateleft'){
			$cropped = $app->dependents->APP_PATH.'uploads/photos/'.$app->newtutor->cropped;
			$img = $app->imagemanager->make($cropped)->rotate(90)->save();
			$app->redirect('/signup/tutor');
		}
	}

	$app->meta = new stdClass();
	$app->meta->title = 'Tutor Signup - '.$app->dependents->SITE_NAME_PROPPER;
	$app->meta->h1 = false;
	$app->meta->keywords = 'tutor,signup,'.$app->dependents->SITE_NAME;

	$app->titleAdd = NULL;
	if(isset($promocode)){
		$promocode = strtolower($promocode);
		//$promocode
		if($promocode=='cl_ny'){
			$app->titleAdd = 'New York';
			$app->target->css.=' new-york ';
		}
		elseif($promocode=='cl_boston'){
			$app->titleAdd = 'Boston';
			$app->target->css.=' boston ';
		}
		elseif($promocode=='cl_dc'){
			$app->titleAdd = 'Washington D.C.';
			$app->target->css.=' washingtondc ';
		}
		elseif($promocode=='cl_sf'){
			$app->titleAdd = 'San Francisco';
			$app->target->css.=' sanfrancisco ';
		}
		elseif($promocode=='cl_sandiego'){
			$app->titleAdd = 'San Diego';
			$app->target->css.=' sandiego ';
		}
		elseif($promocode=='cl_phoenix'){
			$app->titleAdd = 'Phoenix';
			$app->target->css.=' phoenix ';
		}
		elseif($promocode=='cl_la'){
			$app->titleAdd = 'Los Angeles';
			$app->target->css.=' losangeles ';
		}
		elseif($promocode=='holidays'){
			$app->titleAdd = NULL;
			$promoactivate = new stdClass();
			$promoactivate->class = ' holidays-activate ';
			$promoactivate->text = 'Get 80% Pay';
			$app->promoactivate = $promoactivate;
			$app->target->css.=' holidays ';
		}
		elseif($promocode=='iteach'){
			//$app->titleAdd = 'iteach';
			$app->replace = ' Teachers ';
			$app->replacetext = 'Year after year we see teachers work harder and get paid less. At AvidBrain we want to change this, that is why we are excited to lauch iteach: our new program to introduce teachers to AvidBrain and empower them with the skills they already have. <strong>Over the next 18 months, we will on-board 50,000 members of the  education community to the AvidBrain platform.</strong>';
			$promoactivate = new stdClass();
			$promoactivate->class = ' holidays-activate ';
			$promoactivate->text = 'Get 80% Pay';
			$app->promoactivate = $promoactivate;
			$app->target->css.=' iteach ';
		}


	}
