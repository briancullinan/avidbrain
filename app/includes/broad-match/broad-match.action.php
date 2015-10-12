<?php

	$app->filterby = $app->getCookie('filterby');
	$app->secondary = $app->target->secondary;

	$broadMatch = $parent_slug;
	$app->broadMatchCap = ucwords(str_replace('-',' ',$broadMatch));

	$app->filterbylocation = 'maincats-'.$broadMatch.'-tutors';
	//notify($app->filterbylocation);

	$app->connect->cache->delete("allowed_parent_slugs");
	$allowed_parent_slugs = $app->connect->cache->get("allowed_parent_slugs");
	if($allowed_parent_slugs == null) {

		$sql = "SELECT parent_slug FROM avid___available_subjects GROUP BY parent_slug";
		$prepare = array(':usertype'=>'tutor');
		$returnedData = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		$returnedArray = array();
		foreach($returnedData as $parent){
			$returnedArray[] = $parent->parent_slug;
		}
	    $allowed_parent_slugs = $returnedArray;
	    $app->connect->cache->set("allowed_parent_slugs", $returnedArray, 3600);
	}

	$allowed_parent_slugs[] = 'liberal-arts';

	if(!in_array($broadMatch, $allowed_parent_slugs)){
		$app->redirect('/tutors');
	}

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id')->from('avid___user','user');

	if($broadMatch=='liberal-arts'){
		$data	=	$data->where('subjects.parent_slug = "english" AND subjects.subject_slug = "literature"');
		$data	=	$data->orWhere('subjects.parent_slug = "history" AND subjects.subject_slug = "geography"');
		$data	=	$data->orWhere('subjects.parent_slug = "science" AND subjects.subject_slug = "philosophy"');
		$data	=	$data->orWhere('subjects.parent_slug = "history" AND subjects.subject_slug = "anthropology"');
		$data	=	$data->orWhere('subjects.parent_slug = "business" AND subjects.subject_slug = "economics"');
		$data	=	$data->orWhere('subjects.parent_slug = "science" AND subjects.subject_slug = "sociology"');
		$data	=	$data->orWhere('subjects.parent_slug = "language"');

	}
	else{
		$data	=	$data->where('subjects.parent_slug = :parent_slug')->setParameter(':parent_slug',$broadMatch);
	}

	$data	=	$data->andWhere('user.usertype = :usertype')->setParameter(":usertype","tutor");
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');

	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
	//$data	=	$data->orderBy('id','DESC');
	$data	=	$data->groupBy('user.email');
	//$data	=	$data->xxx();


	$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);

	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);

	if(isset($app->filterby) && !empty($app->filterby)){
		if($app->filterby=='highestrate'){
			$data	=	$data->orderBy('profile.hourly_rate','DESC');
		}
		elseif($app->filterby=='lowestrate'){
			$data	=	$data->andWhere('profile.hourly_rate IS NOT NULL');
			$data	=	$data->orderBy('profile.hourly_rate','ASC');
		}
		elseif($app->filterby=='lastactive'){
			$data	=	$data->orderBy('user.last_active');
		}
		elseif($app->filterby=='higheststarscore'){
			$data->addSelect('sessions.review_score')->from('avid___sessions','sessions');
			$data	=	$data->andWhere('sessions.review_score IS NOT NULL AND sessions.from_user = user.email');
			$data	=	$data->orderBy('sessions.review_score','DESC');
		}
	}
	else{
		$data	=	$data->orderBy('user.last_active');
	}

	$count	=	$data->select('user.id')->execute()->rowCount();
	notify($count);
	$data	=	$data->addSelect('user.email,user.first_name,user.last_name,user.url,user.status,subjects.parent_slug,'.everything());


	if($count==0 && $app->filterby=='higheststarscore'){
		$app->setCookie('filterby','lastactive', '2 days');
		$app->redirect($app->request->getPath());
	}

	$data	=	$data->execute()->fetchAll();
	if(isset($data[0])){
		$app->broadmatch = $data;
	}

	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => '/'.$parent_slug.'-tutors/page/',
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();


	$app->meta = new stdClass();
	$app->meta->title = $app->broadMatchCap.' Tutors';
	$app->meta->h1 = $app->broadMatchCap.' Tutors';
	#$app->meta->keywords = 'examplekeys';
	#$app->meta->description = 'exampledescribers';
	//$app->broadMatchCap.' Tutors'


	$file = $app->dependents->DOCUMENT_ROOT.'images/categories/'.$broadMatch.'.jpg';
	if(file_exists($file)){
		$app->meta->h1 = false;
		$app->wideconent = '<div class="widecontent '.$broadMatch.' valign-wrapper"> <div class="valign">'.$app->broadMatchCap.' Tutors</div> </div>';
	}
