<?php
	$cropped = croppedfile($app->currentuser->my_upload);
	
	$approvedfile = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$cropped;
	$myfile = $app->dependents->APP_PATH.'uploads/photos/'.$app->currentuser->my_upload;
	$cropped = $app->dependents->APP_PATH.'uploads/photos/'.$cropped;

	if(file_exists($approvedfile)){
		$img = $app->imagemanager->make($approvedfile)->rotate(90)->save();
	}

	$img = $app->imagemanager->make($myfile)->rotate(90)->save();
	if(file_exists($cropped)){
		$img = $app->imagemanager->make($cropped)->rotate(90)->save();
	}
	$app->redirect($app->currentuser->url.'/my-photos');
