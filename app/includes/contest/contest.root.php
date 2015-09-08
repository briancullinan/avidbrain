<?php
	
	$app->secondary = $app->target->secondary;
	

	if(empty($app->contest->ipadgiveaway)){
		$app->redirect('/signup/students');
	}