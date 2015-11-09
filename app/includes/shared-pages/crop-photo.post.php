<?php
	if(isset($app->crop)){

		$croppedfile = croppedfile($app->currentuser->my_upload);
		$path = $app->dependents->APP_PATH.'uploads/photos/';
		$myupload = $path.$app->currentuser->my_upload;
		$croppedfile = $path.$croppedfile;

		$cropped = $app->imagemanager->make($myupload)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->save($croppedfile); //->resize(250,250)
		$height = $app->imagemanager->make($croppedfile)->height();
		$width = $app->imagemanager->make($croppedfile)->width();

		if($height > 500 || $width > 500){
			$cropped = $app->imagemanager->make($myupload)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->resize(500,500)->save($croppedfile);
		}

		if($app->currentuser->my_upload_status=='verified'){

			$photos = $app->dependents->APP_PATH.'uploads/photos/';
			$approved = $app->dependents->DOCUMENT_ROOT.'profiles/approved/';
			//
			$myfile = $app->currentuser->my_upload;
			$cropped = croppedfile($myfile);

			copy($photos.$cropped,$approved.$cropped);
		}

		$app->redirect($app->currentuser->url.'/my-photos');
	}
