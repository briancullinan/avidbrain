<?php
	$usertype = explode('/',$app->request->getPath());
	$usertype=$usertype[1];

$url = '/'.$usertype.'/'.$state.'/'.$city.'/'.$username;

$thefile = NULL;
if(isset($usertype) && isset($state) && isset($city) && isset($username)){

	$urlfix = str_replace('/','--',$url);
	$file = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$urlfix.'*crop*';
	$isthecrophere = glob($file);

	if(isset($app->user->usertype) && $app->user->usertype=='admin'){
		$urlfix = str_replace('/','--',$url);
		$file = $app->dependents->APP_PATH.'uploads/photos/'.$urlfix.'*';
		$isthecrophere = glob($file);
		if(isset($isthecrophere[0])){
			$thefile = $isthecrophere[0];
			$cropped = croppedfile($thefile);
		}
		if(isset($cropped) && file_exists($cropped)){
			$thefile = $cropped;
		}

		if(empty($thefile)){
			$thefile = $app->dependents->APP_PATH.'uploads/photos/empty-image.jpg';
			$img = $app->imagemanager->make($thefile);
		}

		$img = $app->imagemanager->make($thefile);
	}
	elseif(isset($app->user->url) && $app->user->url==$url){
		$cropped = croppedfile($app->user->my_upload);
		if(file_exists($cropped)){
			$thefile = $cropped;
		}
		else{
			$thefile = $app->user->my_upload;
		}
		$img = $app->imagemanager->make($thefile);
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
