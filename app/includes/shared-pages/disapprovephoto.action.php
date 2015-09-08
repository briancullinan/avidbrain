<?php
	
	$filePath = croppedfile($app->currentuser->my_upload);
	$fileName = str_replace($app->dependents->APP_PATH.'uploads/photos/','',$filePath);
	$newfile = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$fileName;
	
	if(file_exists($newfile)){
		unlink($newfile);
	}
	
	$app->currentuser->my_upload_status = 'needs-review';
	$app->currentuser->save();
	
	$app->redirect($app->currentuser->url.'/my-photos');