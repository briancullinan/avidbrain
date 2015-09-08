<?php
	
	
	$app->filterby = $app->getCookie('filterby');
	
	if(empty($number)){
		$app->number = NULL;
	}
	else{
		$app->number = $number;
	}
	
	if($app->request->isPost()==false){
		$app->searching = json_decode($app->getCookie('searching'));
		$app->search = $app->searching;
		include($app->target->post);
	}
	else{
		$app->searching = $app->search;
	}
	
	$app->advancedsearch = $app->getCookie('advancedsearch');