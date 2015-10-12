<?php
	$usertype = explode('/',$app->request->getPath());
	$usertype=$usertype[1];

$url = '/'.$usertype.'/'.$state.'/'.$city.'/'.$username;

if(isset($usertype) && isset($state) && isset($city) && isset($username)){

	$urlfix = str_replace('/','--',$url);
	$file = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$urlfix.'*crop*';
	$isthecrophere = glob($file);

	if(isset($app->user->usertype) && $app->user->usertype=='admin'){
		$urlfix = str_replace('/','--',$url);
		$file = $app->dependents->APP_PATH.'uploads/photos/'.$urlfix.'*';
		$isthecrophere = glob($file);
		if(isset($isthecrophere[0])){
			$isthecrophere = str_replace('.crop.','.',$isthecrophere[0]);
			$img = $app->imagemanager->make($isthecrophere);
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
}


header('Content-Type: image/png');
echo $img->response();
exit;
