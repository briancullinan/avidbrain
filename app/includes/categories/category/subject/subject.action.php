<?php

	if(isset($subject)){
		$app->redirect('/searching/'.$subject);
	}
	else{
		$app->redirect('/searching/');
	}
