<?php
	
	if(isset($subject)){
		$alljobs = $app->connect->createQueryBuilder()->select('
				jobs.*,
				user.zipcode, user.first_name, user.last_name, user.city, user.state_long, user.state_slug, user.city_slug, user.url,
				settings.showfullname
			')->from('avid___jobs','jobs')
				->where('open IS NOT NULL')
				->andWhere('user.status IS NULL')
				->andWhere('subject_slug = :subject')->setParameter(':subject',$subject)
				->orWhere('parent_slug = :subject')->setParameter(':subject',$subject)
				->innerJoin('jobs', 'avid___user', 'user', 'user.email = jobs.email')
				->innerJoin('jobs', 'avid___user_account_settings', 'settings', 'jobs.email = settings.email');
				
			$count = $alljobs->execute()->rowCount();
			$alljobs = $alljobs->orderBy('date','DESC')->execute()->fetchAll();
			
			$s=NULL;
			if($count!=1){
				$s='s';
			}
				
			if(isset($alljobs[0])){
				$app->alljobs = $alljobs;
				
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