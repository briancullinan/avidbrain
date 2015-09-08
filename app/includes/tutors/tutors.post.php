<?php
	
	if(isset($app->search) && !empty($app->search)){	
		foreach($app->search as $keys => $unset){
			if(empty($unset)){
				unset($app->search->$keys);
			}
		}
	}
	
	$jsonSearch = json_encode($app->search);
	$app->setCookie('searching',$jsonSearch, '2 days');

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.email');
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$data	=	$data->from('avid___user','user');
	
	$data	=	$data->where('user.usertype = :usertype')->setParameter(":usertype","tutor");
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');
	
//	notify($app->search);
		
	
		$arrays = array();
		if(isset($app->search->search)){
			$data	=	$data->addSelect('subjects.subject_name');
			$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
			$data	=	$data->andWhere('subjects.subject_name LIKE :subject_name');
			$data	=	$data->andWhere('subjects.status = :verified')->setParameter(':verified','verified');
			$data	=	$data->setParameter(':subject_name',"%".$app->search->search."%");
		}
		if(isset($app->search->zipcode)){
			$zipcodedata = get_zipcode_data($app->connect,$app->search->zipcode);
			if(empty($app->search->distance)){
				$app->search->distance = 15;
			}
			
			if(empty($zipcodedata)){
				new Flash(
					array('action'=>'alert','message'=>'Invalid Zipcode')
				);
			}
			else{
				if(isset($zipcodedata->lat)){
					$getDistance = "
						round(((acos(sin((" . $zipcodedata->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipcodedata->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipcodedata->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515) 
					";
					
					$app->getDistance = true;
					
					$asDistance = ' as distance ';
					$data	=	$data->addSelect($getDistance.$asDistance)->setParameter(':distance',$app->search->distance)->having("distance <= :distance");
				}
			}
		}
		
		if(isset($app->search->advanced) && $app->search->advanced=='on' || isset($app->search->advanced) && $app->search->advanced==true){
			
			if(isset($app->search->name)){
				//
				$data	=	$data->addSelect('user.first_name, user.last_name');
				$data	=	$data->andWhere('CONCAT(user.first_name," ",user.last_name) LIKE "%'.$app->search->name.'%"');
			}
			if(isset($app->search->gender)){
				//
				$data	=	$data->addSelect('profile.gender')->andWhere('profile.gender = :gender AND profile.gender IS NOT NULL')->setParameter(':gender',$app->search->gender);
				//notify('genders');
				
			}
			if(isset($app->search->pricerangeLower) && isset($app->search->pricerangeUpper)){
				//
				$data	=	$data->addSelect('profile.hourly_rate');
				$data	=	$data->andWhere('profile.hourly_rate BETWEEN :pricerangeLower and :pricerangeUpper');
				$data	=	$data->andWhere('profile.hourly_rate IS NOT NULL');
				$data	=	$data->setParameter(':pricerangeLower',$app->search->pricerangeLower);
				$data	=	$data->setParameter(':pricerangeUpper',$app->search->pricerangeUpper);
			}
		}
		
		
	$data	=	$data->groupBy('user.email');

	// Count * Offset
	if(isset($app->filterby)){
		
		if($app->filterby=='closestdistance' && isset($getDistance)){
			$data	=	$data->orderBy('distance','ASC');		
		}
		elseif($app->filterby=='furthestdistance' && isset($getDistance)){
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
		elseif($app->filterby=='higheststarscore'){
			
			$data->addSelect('sessions.review_score')->from('avid___sessions','sessions');
			$data	=	$data->andWhere('sessions.review_score IS NOT NULL AND sessions.from_user = user.email');
			$data	=	$data->orderBy('sessions.review_score','DESC');
		}
		else{
			$data	=	$data->orderBy('user.last_active');
		}
		
	}
	elseif(isset($getDistance)){
		$data	=	$data->orderBy('distance','ASC');	
	}
	else{
		$data	=	$data->orderBy('user.last_active');
	}
	
	//notify($data);
	
	$offsets = new offsets($app->number,$app->dependents->pagination->items_per_page);
	$count	=	$data->execute()->rowCount();
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data	=	$data->addSelect(user_select().','.profile_select().','.account_settings().',user.id');
	
	$app->searchResults = make_search_key_cache($data,$app->connect);
	//notify($app->searchResults);
	
	$middle = NULL;
	if(isset($app->search->search)){
		$middle = $app->search->search;
	}
	
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $app->target->pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
	
	$count = str_replace('.00','',numbers($count));
	
	$s=NULL;
	if($count!=1){
		$s='s';
	}
	
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' '.$middle.' Tutor'.$s;
	$app->meta->h1 = '<span>'.$count.'</span> '.$middle.' Tutor'.$s.' <span class="grey-text">@ '.$app->dependents->SITE_NAME_PROPPER.'</span>';
	$app->meta->keywords = 'examplekeys';
	$app->meta->description = 'exampledescribers';
	
	
	$app->filterbylocation = 'tutorssearch';