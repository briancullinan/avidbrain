<?php
	
	// Symoblic Link
	// Move all files to shared-pages
	
	$filePath = croppedfile($app->currentuser->my_upload);
	$fileName = str_replace($app->dependents->APP_PATH.'uploads/photos/','',$filePath);
	$newfile = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$fileName;
	copy($filePath, $newfile);
	
	$app->currentuser->my_upload_status = 'verified';
	$app->currentuser->save();
	
	$app->redirect($app->currentuser->url.'/my-photos');