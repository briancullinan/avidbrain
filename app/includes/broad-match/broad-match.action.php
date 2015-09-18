<?php
	$app->filterby = $app->getCookie('filterby');
	$app->secondary = $app->target->secondary;
	
	$broadMatch = $parent_slug;
	$app->broadMatchCap = ucwords(str_replace('-',' ',$broadMatch));
	
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
	
	if(!in_array($broadMatch, $allowed_parent_slugs)){
		$app->redirect('/tutors');
	}
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id')->from('avid___user','user');
	$data	=	$data->where('subjects.parent_slug = :parent_slug')->setParameter(':parent_slug',$broadMatch);
	
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
	
	$count	=	$data->select('user.id')->execute()->rowCount();
	$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
	
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	
	$data	=	$data->addSelect('user.email,user.first_name,user.last_name,user.url,user.status,subjects.parent_slug,'.everything());
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