<?php

	//notify('cats');

	#$app->connect->cache->delete("subjectcachename");
	$allthesubjects = $app->connect->cache->get("subjectcachename");
	if($allthesubjects == null) {
	    $data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('*')->from('avid___available_subjects','subjects');
		$data	=	$data->orderBy('parent_slug','ASC');
		$data	=	$data->groupBy('subjects.parent_slug');
		$data	=	$data->execute()->fetchAll();
	    $allthesubjects = $data;
	    $app->connect->cache->set("subjectcachename", $allthesubjects, 3600);
	}

	if($allthesubjects!=NULL){
		$app->allthesubjects = $allthesubjects;
	}

	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Tutors - Categories';
	$app->meta->h1 = $app->dependents->SITE_NAME_PROPPER.' Tutored Categories';
	$app->meta->keywords = 'Find a tutor, avidbrain, tutors';
