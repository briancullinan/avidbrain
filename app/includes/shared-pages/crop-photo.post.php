<?php
	if(isset($app->crop)){
		
		$croppedfile = croppedfile($app->currentuser->my_upload);
		$cropped = $app->imagemanager->make($app->currentuser->my_upload)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->save($croppedfile); //->resize(250,250)
		$height = $app->imagemanager->make($croppedfile)->height();
		$width = $app->imagemanager->make($croppedfile)->width();
		
		if($height > 500 || $width > 500){
			$cropped = $app->imagemanager->make($app->currentuser->my_upload)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->resize(500,500)->save($croppedfile);
		}
		
		if($app->currentuser->my_upload_status=='verified'){
			$filePath = croppedfile($app->currentuser->my_upload);
			$fileName = str_replace($app->dependents->APP_PATH.'uploads/photos/','',$filePath);
			$newfile = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$fileName;
			copy($filePath, $newfile);
		}
		
		$app->redirect($app->currentuser->url.'/my-photos');
	}
	else{
		
/*
		$img = $app->imagemanager->make($app->currentuser->my_upload);
		
		$img->resize($app->cropresize->size, NULL, function ($constraint) {
		    $constraint->aspectRatio();
		})->save();
		
		$app->redirect('/tutors/scottsdale/arizona/zebras/my-photos/crop-photo');
*/
		
	}
