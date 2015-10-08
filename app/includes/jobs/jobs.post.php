<?php

$jsonSearch = json_encode($app->searchingforjobs);
$app->setCookie('searchingforjobs',$jsonSearch, '2 days');
if(isset($app->searchingforjobs) && !empty($app->searchingforjobs)){
	foreach($app->searchingforjobs as $key=> $unset){
		if(empty($unset)){
			unset($app->searchingforjobs->$key);
		}
	}
}

	$select = "
		jobs.*,
		user.city,
		user.state_long,
		user.zipcode,
		user.first_name,
		user.last_name,
		user.url,
		settings.getemails,
		settings.showfullname,
		settings.anotheragency,
		settings.anotheragancy_rate,
		settings.showmyprofile,
		settings.avidbrainnews,
		settings.textmessages,
		settings.newjobs,
		settings.negotiableprice
	";

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select($select)->from('avid___jobs','jobs');
	$data	=	$data->where('jobs.open IS NOT NULL');

	$data	=	$data->andWhere('user.usertype = :usertype')->setParameter(':usertype','student');
	$data	=	$data->andWhere('user.status IS NULL');

	$search = NULL;
	if(isset($app->searchingforjobs->search) && !empty($app->searchingforjobs->search)){
		$search=true;
		$data	=	$data->andWhere('CONCAT(jobs.subject_name," ",jobs.subject_slug) LIKE :subject_name')->setParameter(':subject_name',"%".$app->searchingforjobs->search."%");

	}

	if(isset($app->searchingforjobs->zipcode) && !empty($app->searchingforjobs->zipcode)){
		$search=true;

		$zipcodedata = get_zipcode_data($app->connect,$app->searchingforjobs->zipcode);

		if(empty($app->searchingforjobs->distance)){
			$app->searchingforjobs->distance = 15;
		}

		if(empty($zipcodedata)){
			new Flash(
				array('action'=>'alert','message'=>'Invalid Zip Code')
			);
		}
		else{
			if(isset($zipcodedata->lat)){
				$getDistance = "
					round(((acos(sin((" . $zipcodedata->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipcodedata->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipcodedata->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515)
				";

				$app->getDistance = true;

				$asDistance = ' as distance ';
				$data	=	$data->addSelect($getDistance.$asDistance)->setParameter(':distance',$app->searchingforjobs->distance)->having("distance <= :distance");
			}
		}
	}


	if(isset($app->searchingforjobs->pricerangeLower) && isset($app->searchingforjobs->pricerangeUpper)){

		$data	=	$data->andWhere('jobs.price_range_low >= :pricelow');
		$data	=	$data->andWhere('jobs.price_range_high <= :pricehigh');

		$data	=	$data->setParameter(':pricelow',$app->searchingforjobs->pricerangeLower);
		$data	=	$data->setParameter(':pricehigh',$app->searchingforjobs->pricerangeUpper);
	}

	$data	=	$data->innerJoin('jobs','avid___user_profile','profile','profile.email = jobs.email');
	$data	=	$data->innerJoin('jobs','avid___user_account_settings','settings','settings.email = jobs.email');
	$data	=	$data->innerJoin('jobs','avid___user','user','user.email = jobs.email');
	if(isset($asDistance)){
		//$data	=	$data->orderBy('jobs.distance','DESC');
		$data	=	$data->orderBy('distance','ASC');
	}
	else{
		$data	=	$data->orderBy('jobs.date','DESC');
	}

	$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
	$count = $data->execute()->rowCount();
	$alljobs = $data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->execute()->fetchAll();
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $app->target->pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();

	//$data	=	$data->execute()->fetchAll();

	//notify($count);

	if($count>0){
		$app->alljobs = $alljobs;
	}
	$name = NULL;
	if(isset($app->searchingforjobs->search)){
		$name = ucwords($app->searchingforjobs->search);
	}


	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		$app->meta = new stdClass();
		$app->meta->title = 'Post a Tutoring Job';
		$app->meta->h1 = 'Post a Tutoring Job';
	}
	else{
		$app->meta = new stdClass();
		$app->meta->title = $count.' '.$name.'  Tutoring Jobs';
		$app->meta->h1 = '<span>'.$count.'</span> '.$name.' Tutoring Jobs';
	}
