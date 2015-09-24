<?php
	
	function linkify_tweet($tweet) {
			
	  //Convert urls to <a> links
	  $tweet = preg_replace("/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/", "<a target=\"_blank\" href=\"$1\">$1</a>", $tweet);
	
	  //Convert hashtags to twitter searches in <a> links
	  $tweet = preg_replace("/#([A-Za-z0-9\/\.]*)/", "<a target=\"_new\" href=\"http://twitter.com/search?q=$1\">#$1</a>", $tweet);
	
	  //Convert attags to twitter profiles in <a> links
	  $tweet = preg_replace("/@([A-Za-z0-9\/\.]*)/", "<a href=\"http://www.twitter.com/$1\">@$1</a>", $tweet);
	
	  return $tweet;
	
	}
	
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
	
	function uniquepromocode($connect){
		$random = random_all(8);
		$sql = "SELECT promocode FROM avid___promotions WHERE promocode = :promocode";
		$prepare = array(':promocode'=>$random);
		$results = $connect->executeQuery($sql,$prepare)->rowCount();
		
		if($results==0){
			return $random;
		}
		else{
			return uniquepromocode($connect);
		}
		
	}
	function signupcode($connect,$email){
		
		$promocodevalues = new stdClass();
		$sql = "SELECT * FROM avid___promotions WHERE email = :email";
		$prepare = array(':email'=>$email);
		$results = $connect->executeQuery($sql,$prepare)->fetch();
		
		if(isset($results->id)){
			$promocodevalues->promocode = $results->promocode;
			$promocodevalues->value = $results->value;
		}
		else{
			
			$random = uniquepromocode($connect);
			$value = 30;
			$connect->insert('avid___promotions',array('promocode'=>$random,'value'=>$value,'email'=>$email));
			$promocode = $random;
			$promocodevalues->promocode = $random;
			$promocodevalues->value = $value;
		}
		
		return $promocodevalues;
	}
	
	
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
		$data	=	$data->where('promotions.email = :myemail AND promotions.used IS NULL AND promotions.activated IS NOT NULL')->setParameter(':myemail',$app->user->email);
		$data	=	$data->leftJoin('promotions','avid___user','user','user.email = promotions.sharedwith');
		$data	=	$data->orderBy('id','DESC');
		$data	=	$data->execute()->fetchAll();
		//notify($data);
		
		if(isset($data[0])){
			$app->myrewards = $data;
		}
		
		$app->target->action = $app->target->user->action;
	}
	else{
		$app->target->action = str_replace('.action.','.loggedout.action.',$app->target->action);
	}
	
	
	$app->meta = new stdClass();
	$app->meta->title = 'Find A Tutor, Teacher, Coach, Mentor @ '.$app->dependents->SITE_NAME_PROPPER;
	$app->meta->h1 = false;
	$app->meta->keywords = 'avidbrain,tutor,teacher,coach,mentor,educator,instructor,professor,scholar,PHD';
	$app->meta->description = 'Teach Something. Learn Anything.';