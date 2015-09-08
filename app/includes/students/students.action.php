<?php
	
	$app->filterby = $app->getCookie('filterby');
	
	if(empty($number)){
		$app->number = NULL;
	}
	else{
		$app->number = $number;
	}
	
	if($app->request->isPost()==false){
		$app->searchingforstudents = json_decode($app->getCookie('searchingforstudents'));
		$app->searchingforstudents = $app->searchingforstudents;
		include($app->target->post);
	}
	else{
		$app->searchingforstudents = $app->searchingforstudents;
	}
	
	
	$app->filterbylocation = 'studentsearch';