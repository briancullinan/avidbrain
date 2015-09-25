<?php
	
	use PicoFeed\Reader\Reader;
	use PicoFeed\PicoFeedException;
	
	$app->homepagesubjects = array(1,2,3);	
	$app->howitworks = true;
	
	//$app->connect->cache->delete("topsubjects");
	$topsubjects = $app->connect->cache->get("topsubjects");
	if($topsubjects == null) {
	   
	   $sql = "SELECT subject_slug,parent_slug,subject_name,count(subject_name) as count FROM avid___user_subjects WHERE usertype = :usertype AND status = :verified GROUP BY subject_name ORDER BY count(subject_name) DESC LIMIT 8";
		$prepeare = array(':usertype'=>'tutor',':verified'=>'verified');
		$topsubjects = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	    $app->connect->cache->set("topsubjects", $topsubjects, 3600);
	}
	$app->topsubjects = $topsubjects;
	
	
	//$app->connect->cache->delete("toptutors");
	$toptutors = $app->connect->cache->get("toptutors");
	if($toptutors == null && !empty($topsubjects)) {
		
			if(isset($topsubjects)){
				$count = (count($topsubjects)-1);
			}
			
			$topsubs = NULL;
			if(isset($topsubjects[0])){			
				$topsubs = $topsubjects[rand(0,$count)];	
			}
		
			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('user.*,'.everything().',subjects.subject_name, subjects.subject_slug, subjects.parent_slug')->from('avid___user','user');
			$data	=	$data->where('user.usertype = :usertype')->setParameter(':usertype','tutor');
			$data	=	$data->andWhere('user.status IS NULL');
			$data	=	$data->andWhere('user.hidden IS NULL');
			$data	=	$data->andWhere('user.lock IS NULL');
			$data	=	$data->andWhere('profile.my_upload IS NOT NULL');
			$data	=	$data->andWhere('profile.my_upload_status = "verified"');
			$data	=	$data->andWhere('subjects.subject_slug = :subject_slug')->setParameter(':subject_slug',$topsubs->subject_slug);
			$data	=	$data->andWhere('subjects.parent_slug = :parent_slug')->setParameter(':parent_slug',$topsubs->parent_slug);
			$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
			$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
			
			$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
			
			
			$data	=	$data->groupBy('user.email');
			$data	=	$data->orderBy('RAND()');
			$data	=	$data->setMaxResults('6');
			$data	=	$data->execute()->fetchAll();
			
			$toptutors = $data;
			
			$app->connect->cache->set("toptutors", $data, 3600);
		
	}
	
	if(count($toptutors)>0){
		$zero = $toptutors[0];
		$app->topsuburl = '/categories/'.$zero->parent_slug.'/'.$zero->subject_slug;
		$app->topsubjectname = $zero->subject_name;
		$app->toptutors = $toptutors;
	}
	
	
	$cachedmotivation = $app->connect->cache->get("cachedMotivation");
	if($cachedmotivation == null) {
	    $sql = "SELECT * FROM avid___motivation  ORDER BY RAND() LIMIT 1";
		$prepare = array(':usertype'=>'tutor');
		$returnedData = $app->connect->executeQuery($sql,$prepare)->fetch();
	    $cachedmotivation = $returnedData;
	    $app->connect->cache->set("cachedMotivation", $returnedData, 3600);
	}
	
	$app->cachedmotivation = $cachedmotivation;

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('jobs.*,user.status,'.everything())->from('avid___jobs','jobs');
	$data	=	$data->where('open IS NOT NULL AND applicants IS NULL AND user.status IS NULL');
	$data	=	$data->innerJoin('jobs','avid___user','user','user.email = jobs.email');
	$data	=	$data->innerJoin('jobs','avid___user_profile','profile','profile.email = jobs.email');
	$data	=	$data->innerJoin('jobs','avid___user_account_settings','settings','settings.email = jobs.email');
	$data	=	$data->orderBy('id','DESC');
	$data	=	$data->groupBy('jobs.subject_name');
	$data	=	$data->setMaxResults('6');
	$data	=	$data->execute()->fetchAll();
	if(!empty($data)){
		$app->students = $data;
	}

	try {
	
	    $reader = new Reader;
	    $resource = $reader->download($app->dependents->social->qa.'/feed/qa.rss');
	
	    $parser = $reader->getParser(
	        $resource->getUrl(),
	        $resource->getContent(),
	        $resource->getEncoding()
	    );
	
	    $app->feed = $parser->execute();
	}
	catch (Exception $e) {
	    // Do something...
	}