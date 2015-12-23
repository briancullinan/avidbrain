<?php

	#$category = str_replace('-tutors','',$category);

	//$app->connect->cache->delete("categorycachename".$category);
	$allsubjectsincategory = $app->connect->cache->get("categorycachename".$category);
	if($allsubjectsincategory == null) {
	    $data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('*')->from('avid___available_subjects','subjects');
		$data	=	$data->orderBy('subject_name','ASC');
		$data	=	$data->where('parent_slug = :parent_slug AND subject_name IS NOT NULL')->setParameter(':parent_slug',$category);
		//$data	=	$data->groupBy('subjects.parent_slug');
		$data	=	$data->execute()->fetchAll();
		//notify($data);
	    $allsubjectsincategory = $data;
	    $app->connect->cache->set("categorycachename".$category, $allsubjectsincategory, 3600);
	}

	if($allsubjectsincategory!=NULL){
		$app->zero = $allsubjectsincategory[0];
		$app->allsubjectsincategory = $allsubjectsincategory;
	}

	if(empty($allsubjectsincategory) && isset($category)){

		$cachedfind = 'cached-finder-'.$category;

		$findredirect = $app->connect->cache->get($cachedfind);
		if($findredirect == null) {

		    $sql = "SELECT parent_slug FROM avid___available_subjects WHERE subject_slug = :subject_slug LIMIT 1";
			$prepeare = array(':subject_slug'=>$category);
			$findredirect = $app->connect->executeQuery($sql,$prepeare)->fetch();

		    $app->connect->cache->set($cachedfind, $findredirect, 3600);
		}

		if(isset($findredirect->parent_slug)){
			$app->redirect('/categories/'.$findredirect->parent_slug.'/'.$category);
		}

	}

	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' '.$app->zero->subject_parent.' Tutors';
	$app->meta->h1 = $app->zero->subject_parent.' Tutors';
	$app->meta->keywords = 'Find a tutor, avidbrain, tutors';
