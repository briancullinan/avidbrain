<?php

	$deleteRequest = array(
		'type'=>'My Photo',
		'email'=>$app->user->email
	);

	$app->connect->delete('avid___user_needsprofilereview',$deleteRequest);

	$path = APP_PATH.'uploads/photos/';
	$pathApproved = DOCUMENT_ROOT.'profiles/approved/';
	$myfile = $app->currentuser->my_upload;

	$upload = $path.$myfile;
	$cropped = croppedfile($path.$myfile);
	$approved = $pathApproved.$myfile;

	if(file_exists($upload)){
		unlink($upload);
	}
	if(file_exists($cropped)){
		unlink($cropped);
	}
	if(file_exists($approved)){
		unlink($approved);
	}

	$app->showmyphotoas = NULL;
	$app->currentuser->my_upload = NULL;
	$app->currentuser->my_upload_status = NULL;
	$app->currentuser->save();
	$app->redirect($app->currentuser->url.'/my-photos');
