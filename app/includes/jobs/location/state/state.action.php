<?php

	if(isset($state)){

		$select = "jobs.id";
		$selectFull = "
			jobs.*,
			user.zipcode, user.first_name, user.last_name, user.city, user.state_long, user.state_slug, user.city_slug, user.url,
			settings.showfullname
		";


		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select($select)->from('avid___jobs','jobs');
		$data	=	$data->andWhere('user.usertype = :usertype')->setParameter(':usertype','student');
		$data	=	$data->andWhere('user.status IS NULL');
		$data	=	$data->andWhere('user.state_slug = :state')->setParameter(':state',$state);

		$data	=	$data->innerJoin('jobs','avid___user','user','jobs.email = user.email');
		$data	=	$data->innerJoin('jobs','avid___user_profile','profile','jobs.email = profile.email');
		$data	=	$data->innerJoin('jobs','avid___user_account_settings','settings','jobs.email = settings.email');
		if(isset($app->user->usertype) && $app->user->usertype=='admin'){

		}
		else{
			$data	=	$data->andWhere('jobs.flag IS NULL');
		}

		//$data	=	$data->innerJoin('user','aviduser_profile','profile','user.email = profile.email');
		//$data	=	$data->orderBy('id','DESC');
		//$data	=	$data->groupBy('user.email');
		//$data	=	$data->xxx();

		$count	=	$data->execute()->rowCount();

		$data	=	$data->addSelect($selectFull);

		$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
		$count = $data->execute()->rowCount();
		$data = $data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->execute()->fetchAll();
		$pagify = new Pagify();
		$config = array(
			'total'    => $count,
			'url'      => '/jobs/location/'.$state.'/page',
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);
		$pagify->initialize($config);
		$app->pagination = $pagify->get_links();

		if($count>0){
			$s=NULL;
			if($count!=1){
				$s='s';
			}
			$app->alljobs = $data;
			$jobinfo = $data[0];

			$app->meta = new stdClass();
			$app->meta->title = ucwords($jobinfo->state_long).' Tutoring Job'.$s;
			$app->meta->h1 = '<span>'.$count.'</span> '.ucwords($jobinfo->state_long).' Tutoring Job'.$s;
		}

	}
