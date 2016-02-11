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

	$photos = APP_PATH.'uploads/photos/';
	$approved = DOCUMENT_ROOT.'profiles/approved/';

	$myfile = $app->currentuser->my_upload;
	$cropped = croppedfile($myfile);

	copy($photos.$cropped, $approved.$cropped);

	$app->currentuser->my_upload_status = 'verified';
	$app->currentuser->save();

	$app->redirect($app->currentuser->url.'/my-photos');
