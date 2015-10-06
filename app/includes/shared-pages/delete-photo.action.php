<?php

	$cropped = croppedfile($app->currentuser->my_upload);
	$fileName = str_replace($app->dependents->APP_PATH.'uploads/photos/','',$cropped);
	$approvedfile = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$fileName;
	if(file_exists($approvedfile)){
		unlink($approvedfile);
	}
	if(file_exists($app->currentuser->my_upload)){
		unlink($app->currentuser->my_upload);
	}
	if(file_exists($cropped)){
		unlink($cropped);
	}

	$app->showmyphotoas = NULL;
	$app->currentuser->my_upload = NULL;
	$app->currentuser->save();
	$app->redirect($app->currentuser->url.'/my-photos');
