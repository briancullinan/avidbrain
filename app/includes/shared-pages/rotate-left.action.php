<?php
	$cropped = croppedfile($app->currentuser->my_upload);
	
	$fileName = str_replace($app->dependents->APP_PATH.'uploads/photos/','',$cropped);
	$approvedfile = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$fileName;
	if(file_exists($approvedfile)){	
		$img = $app->imagemanager->make($approvedfile)->rotate(90)->save();
	}
	
	$img = $app->imagemanager->make($app->currentuser->my_upload)->rotate(90)->save();
	if(file_exists($cropped)){
		$img = $app->imagemanager->make($cropped)->rotate(90)->save();	
	}
	$app->redirect($app->currentuser->url.'/my-photos');