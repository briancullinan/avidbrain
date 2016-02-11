<?php
	if(isset($app->crop)){

		$croppedfile = croppedfile($app->currentuser->my_upload);
		$path = APP_PATH.'uploads/photos/';
		$myupload = $path.$app->currentuser->my_upload;
		$croppedfile = $path.$croppedfile;

		if(isset($app->crop->fullwidth)){


			$filetype = getfiletype($app->user->my_upload);
			$thefile = $app->user->username.$filetype;
			$checkfile = $thefile;
			$location = APP_PATH.'uploads/photos/';

			
			if(file_exists($location.$checkfile)){
				$file = $checkfile;
			}

			if(isset($file)){
				$img = $app->imagemanager->make($location.$file);
				$cropped = croppedfile($location.$file);

				if(isset($app->crop->fullwidth)){
					$img->resize($app->crop->fullwidth, NULL, function ($constraint) {
						$constraint->aspectRatio();
					});

					$img->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->save($cropped);

					$height = $img->height();
					$width = $img->width();

					if($height > 500 || $width > 500){
						$img->resize(500,500)->save($cropped);
					}
				}
			}
			else{
				notify('FILE MISSING');
			}
		}
		else{
			$cropped = $app->imagemanager->make($myupload)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->save($croppedfile); //->resize(250,250)
			$height = $app->imagemanager->make($croppedfile)->height();
			$width = $app->imagemanager->make($croppedfile)->width();

			if($height > 500 || $width > 500){
				$cropped = $app->imagemanager->make($myupload)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->resize(500,500)->save($croppedfile);
			}

			if($app->currentuser->my_upload_status=='verified'){

				$photos = APP_PATH.'uploads/photos/';
				$approved = DOCUMENT_ROOT.'profiles/approved/';
				//
				$myfile = $app->currentuser->my_upload;
				$cropped = croppedfile($myfile);

				copy($photos.$cropped,$approved.$cropped);
			}
		}

		$app->connect->update('avid___user_profile',array('my_upload_status'=>NULL),array('email'=>$app->user->email));
		$app->redirect($app->currentuser->url.'/my-photos');
	}
