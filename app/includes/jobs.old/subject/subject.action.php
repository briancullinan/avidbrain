<?php

	if(isset($subject)){

		$selectInitial = "jobs.id";
		$select = "
			jobs.*,
			user.zipcode, user.first_name, user.last_name, user.city, user.state_long, user.state_slug, user.city_slug, user.url,
			settings.showfullname
		";

		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select($selectInitial)->from('avid___jobs','jobs');
		$data	=	$data->where('subject_slug = :subject')->setParameter(':subject',$subject);
		$data	=	$data->andWhere('jobs.open IS NOT NULL');
		//$data	=	$data->andWhere('user.usertype = :usertype')->setParameter(':usertype','student');
		$data	=	$data->andWhere('user.status IS NULL');
		$data	=	$data->orWhere('parent_slug = :subject')->setParameter(':subject',$subject);
		if(isset($app->user->usertype) && $app->user->usertype=='admin'){

		}
		else{
			$data	=	$data->andWhere('jobs.flag IS NULL');
		}

		// INNER JOIN
		$data	=	$data->leftJoin('jobs','avid___user','user','jobs.email = user.email');
		$data	=	$data->leftJoin('jobs','avid___user_profile','profile','jobs.email = profile.email');
		$data	=	$data->leftJoin('jobs','avid___user_account_settings','settings','jobs.email = settings.email');

		$data	=	$data->orderBy('jobs.date','DESC');

		$count	=	$data->execute()->rowCount();

		$data	=	$data->addSelect($select);

		$offsets = new offsets((isset($number) ? $number : NULL),PERPAGE);
		$count = $data->execute()->rowCount();
		$data = $data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->execute()->fetchAll();
		$pagify = new Pagify();
		$config = array(
			'total'    => $count,
			'url'      => '/jobs/'.$subject.'/page',
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);
		$pagify->initialize($config);
		$app->pagination = $pagify->get_links();
		//notify($offsets->perpage);
		if($count>0){
			$s=NULL;
			if($count!=1){
				$s='s';
			}

			$app->alljobs = $data;
			$alljobs = $data;

			$jobinfo = $alljobs[0];

			if($subject==$jobinfo->subject_slug){
				$name = $jobinfo->subject_name;
			}
			if($subject==$jobinfo->parent_slug){
				$name = fix_parent_slug($jobinfo->parent_slug);
			}

			$app->meta = new stdClass();
			$app->meta->title = $name.' Tutoring Job'.$s;
			$app->meta->h1 = '<span>'.$count.'</span> '.$name.' Tutoring Job'.$s;

		}
	}
