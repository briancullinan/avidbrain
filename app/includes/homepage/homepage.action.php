<?php
	
	use PicoFeed\Reader\Reader;
	use PicoFeed\PicoFeedException;

	if(isset($app->user->email)){
		
		if(isset($app->user->usertype) && $app->user->usertype=='admin'){
			$app->redirect('/admin-everything');
			///$app->target->include = str_replace('.include.','.admin.',$app->target->include);
			///$app->target->css = "";
		}
		elseif(empty($app->user->zipcode)){
			unset($app->leftnav);
			$app->target->css = "hide-everything";
			$app->target->include = str_replace('loggedin','add.zipcode',$app->target->loggedin);
			
			if(empty($app->user->url) && isset($app->user->zipcode)){
				//$app->user->url = make_my_url($app->user,$numbers);
			}
		}
		elseif(isset($app->user->email) && empty($app->user->welcome)){
			$app->target->include = str_replace('loggedin','welcome',$app->target->loggedin);
			$app->target->css = "";
			
			//$numbers = unique_username($app->connect,1);
			$app->user->welcome = 1;
			//$app->user->username = $numbers;
			$app->user->save();
			
			
			if(empty($app->user->settings())){
				$sql = "INSERT INTO avid___user_account_settings SET email = :email";
				$prepare = array(':email'=>$app->user->email);
				$settings = $app->connect->executeQuery($sql,$prepare);
			}
			
		}
		elseif(isset($app->user->email) && isset($app->user->welcome)){
			$app->target->include = $app->target->user->include;
			$app->target->css = "";
		}
		
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('promotions.*, user.first_name, user.last_name, user.url')->from('avid___promotions_active','promotions');
		$data	=	$data->where('promotions.email = :myemail AND used IS NULL AND promotions.activated IS NOT NULL')->setParameter(':myemail',$app->user->email);
		$data	=	$data->innerJoin('promotions','avid___user','user','user.email = promotions.sharedwith');
		$data	=	$data->orderBy('id','DESC');
		$data	=	$data->execute()->fetchAll();
		
		if(isset($data[0])){
			$app->myrewards = $data;
		}
		
		if($app->user->usertype=='tutor'){
			
			function page_views($app){
				
				$googleAPIcachename = $app->user->email.'-googleAPI';
				
				$cacheapianalytics = $app->connect->cache->get($googleAPIcachename);
				if($cacheapianalytics == null) {
					$starting = explode(' ',$app->user->signup_date);
					$starting = $starting[0];
					$p12FilePath = $app->dependents->APP_PATH.'dependents/google-api.p12';
					$serviceClientId = '572852330695-0hbkh6fr4okvdvqk6tncit8154aqbtne.apps.googleusercontent.com';
					$serviceAccountName = '572852330695-0hbkh6fr4okvdvqk6tncit8154aqbtne@developer.gserviceaccount.com';
					$scopes = array('https://www.googleapis.com/auth/analytics.readonly');
					$googleAssertionCredentials = new Google_Auth_AssertionCredentials($serviceAccountName,$scopes,file_get_contents($p12FilePath));
					$client = new Google_Client();
					$client->setAssertionCredentials($googleAssertionCredentials);
					$client->setClientId($serviceClientId);
					$client->setApplicationName("Project");
					$analytics = new Google_Service_Analytics($client);
					$analyticsViewId    = 'ga:101662413';
					$startDate          = $starting;
					$endDate            = date('Y-m-d');
					$metrics            = 'ga:pageviews';
					$data = $analytics->data_ga->get($analyticsViewId, $startDate, $endDate, $metrics, array(
					    'dimensions'    => 'ga:pagePath',
					    'filters'       => 'ga:pagePath=='.$app->user->url,
					    'sort'          => '-ga:pageviews',
					));
					$pageviews = $data->totalsForAllResults;
					$returnedData = $pageviews['ga:pageviews'];
				    $cacheapianalytics = $returnedData;
				    $app->connect->cache->set($googleAPIcachename, $returnedData, 3600);
				}
				
				return $cacheapianalytics;
			}
			
			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('user.id,user.username,user.promocode,user.first_name,user.last_name,'.everything())->from('avid___user','user');
			$data	=	$data->where('user.promocode = :promocode')->setParameter(':promocode',$app->user->email);
			$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
			$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
			$data	=	$data->execute()->fetchAll();
			if(isset($data[0])){
				$app->mystudents = $data;
			}
		}
		
	}
	else{
		
		$app->homepagesubjects = array(1,2,3);
	
		$app->howitworks = true;
		
		
		//$app->connect->cache->delete("topsubjects");
		$topsubjects = $app->connect->cache->get("topsubjects");
		if($topsubjects == null) {
		   
		   $sql = "SELECT subject_slug,parent_slug,subject_name,count(subject_name) as count FROM avid___user_subjects WHERE usertype = :usertype AND status = :verified GROUP BY subject_name ORDER BY count(subject_name) DESC LIMIT 5";
			$prepeare = array(':usertype'=>'tutor',':verified'=>'verified');
			$topsubjects = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
		    $app->connect->cache->set("topsubjects", $topsubjects, 1200);
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
				
				$app->connect->cache->set("toptutors", $data, 1200);
			
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
		    $app->connect->cache->set("cachedMotivation", $returnedData, 1200);
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
		
	}
	
	
	
	$app->meta = new stdClass();
	$app->meta->title = 'Find A Tutor, Teacher, Coach, Mentor @ '.$app->dependents->SITE_NAME_PROPPER;
	$app->meta->h1 = false;
	$app->meta->keywords = 'avidbrain,tutor,teacher,coach,mentor,educator,instructor,professor,scholar,PHD';
	$app->meta->description = 'Teach Something. Learn Anything.';