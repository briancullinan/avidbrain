<?php

	// Symoblic Link
	// Move all files to shared-pages

	$deleteRequest = array(
		'type'=>'My Photo',
		'email'=>$app->currentuser->email
	);

	$delete = $app->connect->delete('avid___user_needsprofilereview',$deleteRequest);

	if($delete==true){
		$app->mailgun->to = $app->currentuser->email;
		$app->mailgun->subject = 'Your photo has been approved';
		$app->mailgun->message = 'Congratulations, your photo has been approved.';
		$app->mailgun->send();
	}

	$filePath = croppedfile($app->currentuser->my_upload);
	$fileName = str_replace($app->dependents->APP_PATH.'uploads/photos/','',$filePath);
	$newfile = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$fileName;
	copy($filePath, $newfile);

	$app->currentuser->my_upload_status = 'verified';
	$app->currentuser->save();

	$app->redirect($app->currentuser->url.'/my-photos');
