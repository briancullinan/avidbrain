<?php
	$usertype = explode('/',$app->request->getPath());
	$usertype=$usertype[1];

$url = '/'.$usertype.'/'.$state.'/'.$city.'/'.$username;

//notify($url);

if(isset($usertype) && isset($state) && isset($city) && isset($username)){

	$urlfix = str_replace('/','--',$url);
	$file = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$urlfix.'*crop*';
	$isthecrophere = glob($file);

	if(isset($app->user->usertype) && $app->user->usertype=='admin'){
		$sql = "
			SELECT user.url, profile.my_upload FROM avid___user user
			INNER JOIN avid___user_profile profile
			ON user.email = profile.email
			WHERE url = :url AND profile.my_upload IS NOT NULL
		";
		$prepare = array(':url'=>$url);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($results->my_upload)){
			$thefile = $results->my_upload;
			$img = $app->imagemanager->make($thefile);
		}
	}
	elseif(isset($app->user->url) && $app->user->url==$url){
		$img = $app->imagemanager->make($app->user->my_upload);
	}
	elseif(isset($app->user) && isset($isthecrophere[0])){
		$file = $isthecrophere[0];
		$img = $app->imagemanager->make($file);
	}
	else{
		$img = $app->imagemanager->make($app->dependents->APP_PATH.'uploads/photos/empty-image.jpg');
	}

	if(empty($app->user->my_upload) && empty($img)){
		notify('No Image Found');
	}

	header('Content-Type: image/png');
	echo $img->response();
	exit;
}
else{
	notify('No Image Found');
}
