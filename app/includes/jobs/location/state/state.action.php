<?php
	
	if(isset($state)){
		$alljobs = $app->connect->createQueryBuilder()->select('
				jobs.*,
				user.zipcode, user.first_name, user.last_name, user.city, user.state_long, user.state_slug, user.city_slug, user.url,
				settings.showfullname
			')->from('avid___jobs','jobs')
				->where('open IS NOT NULL')
				->andWhere('user.status IS NULL')
				->andWhere('user.state_slug = :state')->setParameter(':state',$state)
				->innerJoin('jobs', 'avid___user', 'user', 'user.email = jobs.email')
				->innerJoin('jobs', 'avid___user_account_settings', 'settings', 'jobs.email = settings.email');
				
			$count = $alljobs->execute()->rowCount();
			$alljobs = $alljobs->orderBy('date','DESC')->execute()->fetchAll();
			#notify($alljobs);
			
			$s=NULL;
			if($count!=1){
				$s='s';
			}
				
			if(isset($alljobs[0])){
				$app->alljobs = $alljobs;
				
				$jobinfo = $alljobs[0];
				
				$app->meta = new stdClass();
				$app->meta->title = ucwords($jobinfo->state_long).' Tutoring Job'.$s;
				$app->meta->h1 = '<span>'.$count.'</span> '.ucwords($jobinfo->state_long).' Tutoring Job'.$s;	
				
			}
	}