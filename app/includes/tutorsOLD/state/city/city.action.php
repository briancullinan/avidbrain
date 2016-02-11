<?php

	$app->secondary = $app->target->secondary;
	$app->filterby = $app->getCookie('filterby');

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id')->from('avid___user','user');
	$data	=	$data->where('user.usertype = :usertype AND state_slug IS NOT NULL AND city_slug = :city_slug AND state_slug = :state_slug')->setParameter(':usertype','tutor')->setParameter(':state_slug',$state)->setParameter(':city_slug',$city);
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');
	if(empty($app->user->email)){
		$data	=	$data->andWhere('settings.loggedinprofile = "no"');
	}

	$data	=	$data->orderBy('user.state_slug','ASC');
	$data	=	$data->groupBy('user.email');


	$app->number = (isset($number) ? $number : NULL);
	$offsets = new offsets($app->number,PERPAGE);


	$data	=	$data->addSelect(everything().',user.email,user.id');

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
			$data	=	$data->orderBy('user.state_slug','ASC');
		}

	}
	elseif(isset($getDistance)){
		$data	=	$data->orderBy('distance','ASC');
	}
	$count	=	$data->execute()->rowcount();
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data	=	$data->execute()->fetchAll();

	if($count==0 && $app->filterby=='higheststarscore'){
		$app->setCookie('filterby','lastactive', '2 days');
		$app->redirect($app->request->getPath());
	}

	if(empty($data)){
		$app->redirect('/tutors');
	}

	$pagebase = '/tutors/'.$state.'/'.$city.'/page';

	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();

	$countpropper = str_replace('.00','',numbers($count));


	if(isset($data[0])){
		$zero = $data[0];
		$app->searchResults = $data;

		$new = new stdClass();
		$new->zipcode = $zero->zipcode;
		//$new->distance = 15;

		$app->searching = $new;

		//
		//$app->searchResults = $zero;
	}

	$s=NULL;
	if($count!=1){
		$s='s';
	}

	$app->meta = new stdClass();
	$app->meta->title = ucwords($zero->city).' '.ucwords($zero->state_long).' Tutor'.$s;
	$app->meta->h1 = ' <span>'.$countpropper.'</span> Tutor'.$s.' in '.ucwords($zero->city);
	$app->meta->keywords = $zero->city.' tutors, '.$zero->city.' tutoring, '.$zero->city.' lessons, '.$zero->city.' learning, '.$zero->city.' coaching';
	$app->meta->description = 'avid brain tutors are everywhere';

	$app->filterbylocation = 'tutors---'.$state.'---'.$city;
