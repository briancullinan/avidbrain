<?php

	$app->meta = new stdClass();
	$app->meta->title = 'How It Works - '.SITENAME_PROPPER;
	$app->meta->h1 = 'How It Works';


		if(isset($app->user->usertype)){
			if($app->user->usertype=='tutor'){
				$app->redirect('/how-it-works/faqs/tutors');
			}
			elseif($app->user->usertype=='student'){
				$app->redirect('/how-it-works/faqs/tutors');

			}
		}
		else{
			$app->redirect('/how-it-works/faqs');
		}
