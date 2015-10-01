<?php
	
	$app->secondary = $app->target->secondary;
	$app->filterby = $app->getCookie('filterby');
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id')->from('avid___user','user');
	$data	=	$data->where('user.usertype = :usertype')->setParameter(':usertype','tutor');
	$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$data	=	$data->innerJoin('user','avid___available_subjects','av_subjects','av_subjects.subject_slug = :subject');
	
	if(isset($app->filterby)){
		
		if($app->filterby=='furthestdistance' && isset($getDistance)){
			$data	=	$data->orderBy('distance','DESC');		
		}
		elseif($app->filterby=='highestrate'){
			$data	=	$data->orderBy('profile.hourly_rate','DESC');
		}
		elseif($app->filterby=='lowestrate'){
			$data	=	$data->orderBy('profile.hourly_rate','ASC');
			$data	=	$data->andWhere('profile.hourly_rate IS NOT NULL');
		}
		elseif($app->filterby=='lastactive'){
			$data	=	$data->addSelect('user.last_active');
			$data	=	$data->orderBy('user.last_active','DESC');
		}
		else{
			//notify($app->filterby);
		}
		
	}
	elseif(isset($getDistance)){
		$data	=	$data->orderBy('rand()');	
	}
	
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');
	$data	=	$data->andWhere('subjects.subject_slug = :subject')->setParameter(':subject',$subject);
	$data	=	$data->andWhere('subjects.parent_slug = :parent_slug')->setParameter(':parent_slug',$category);
	$data	=	$data->andWhere('subjects.parent_slug = av_subjects.parent_slug')->setParameter(':parent_slug',$category);
	$data	=	$data->andWhere('subjects.status = :verified')->setParameter(':verified','verified');
	
	$app->number = (isset($number) ? $number : NULL);
	
	$offsets = new offsets($app->number,$app->dependents->pagination->items_per_page);
	$data	=	$data->groupBy('user.email');
	$count	=	$data->execute()->rowCount();
	$data	=	$data->addSelect('user.id,subjects.subject_name,subjects.parent_slug,subjects.subject_slug,av_subjects.description,av_subjects.keywords,av_subjects.subject_parent as subject_parent');
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data	=	$data->addSelect(everything().',user.email');
	
	$data = make_search_key_cache($data,$app->connect);
	
	if($count>0){
		
		$app->searchResults = $data;
		
		$app->zero = $data[0];
		
		#notify($app->zero);
		//notify($app->zero);
	}
	else{
		
		$zero = new stdClass();
		$zero->subject_parent = ucwords(str_replace('-',' ',$category));
		$zero->subject_name = ucwords(str_replace('-',' ',$subject));
		
		$app->zero = $zero;
		
		$app->meta = new stdClass();
		$app->meta->title = 'exampletitle';
		$app->meta->h1 = 'pageh1';
		#$app->meta->keywords = 'examplekeys';
		#$app->meta->description = 'exampledescribers';
	}
	
	$app->filterbylocation = 'subjects---'.$category.'---'.$subject;
	
	$pagebase = '/categories/'.$category.'/'.$subject.'/page';
		
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
	
	$s=NULL;
	if($count!=1){
		$s='s';
	}
	
	$cachedname = $category.$subject."--cachedsubjectinfo";
	//$cachedsubjectinfo = $app->connect->cache->delete($cachedname);
	$cachedsubjectinfo = $app->connect->cache->get($cachedname);
	if($cachedsubjectinfo == null) {
		
		$sql = "SELECT * FROM avid___available_subjects WHERE parent_slug = :parent_slug AND subject_slug = :subject_slug";
		$prepare = array(':parent_slug'=>$category,':subject_slug'=>$subject);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		
	    $returnedData = $results;
	    $cachedsubjectinfo = $returnedData;
	    $app->connect->cache->set($cachedname, $returnedData, 6400);
	}
	
	$app->meta = new stdClass();
	$app->meta->title = $app->zero->subject_name.' Tutor'.$s.' @ '.$app->dependents->SITE_NAME_PROPPER;
	$app->meta->h1 = '<span>'.$count.'</span> '.$app->zero->subject_name.' Tutor'.$s;
	if(isset($app->zero->keywords)){
		$app->meta->keywords = $app->zero->keywords;
	}
	if(isset($app->zero->description)){
		$app->meta->description = $app->zero->description;
	}
	
	if(isset($cachedsubjectinfo->keywords)){
		$app->meta->keywords = $cachedsubjectinfo->keywords;
	}
	if(isset($cachedsubjectinfo->description)){
		$app->meta->description = truncate($cachedsubjectinfo->description,128);
	}
	
	if(isset($cachedsubjectinfo->description)){
		$app->pagedescription = $cachedsubjectinfo->description;
	}
	
	$searching = new stdClass();
	$searching->search = $app->zero->subject_name;
	
	$app->searching = $searching;