<?php

    //notify('snakes');

    unset($app->makechanges->target);

    //notify($app->makechanges);

    $allowed = [
        'mytagline',
        'statement',
        'first_name',
        'last_name',
        'hourly_rate',
        'city',
        'state_long',
        'gender',
        'travel_distance',
        'cancellation_policy',
        'cancellation_rate',
        'online_tutor',
        'locationinfo',
        'zipcode'
    ];

    function checkagainst($array,$allowed){
        foreach($array as $key=> $checkAgainst){
            if(!in_array($key, $allowed)){
                return true;
            }
        }
    }

    if($app->actualuser->email==$app->user->email && isset($app->mysubjects)){

        if(isset($app->mysubjects->newitem)){

            $sql = "SELECT sortorder FROM avid___user_subjects WHERE email = :email ORDER BY sortorder DESC LIMIT 1";
            $prepeare = array(':email'=>$app->actualuser->email);
            $sortMax = $app->connect->executeQuery($sql,$prepeare)->fetch();

            $insert = [
                'email'=>$app->actualuser->email,
                'subject_slug'=>$app->mysubjects->subject_slug,
                'parent_slug'=>$app->mysubjects->parent_slug,
                'description'=>$app->mysubjects->description,
                'last_modified'=>thedate(),
                'status'=>'needs-review',
                'usertype'=>'tutor',
                'subject_name'=>$app->mysubjects->subject_name,
                'sortorder'=>($sortMax->sortorder+1)
            ];

            $app->connect->insert('avid___user_subjects',$insert);
        }

        

        if(isset($app->mysubjects->status) && $app->mysubjects->status=='approve'){
            $update = [
                'description'=>$app->mysubjects->description,
                'description_verified'=>$app->mysubjects->description,
                'last_modified'=>thedate(),
                'status'=>'verified'
            ];
            $app->connect->update('avid___user_subjects',$update,array('email'=>$app->actualuser->email,'id'=>$app->mysubjects->id));
        }
        elseif(isset($app->mysubjects->status) && $app->mysubjects->status=='reject'){
            $update = [
                'description'=>$app->mysubjects->description_verified,
                'description_verified'=>NULL,
                'last_modified'=>thedate(),
                'status'=>'needs-review'
            ];
            //notify($update);
            $app->connect->update('avid___user_subjects',$update,array('email'=>$app->actualuser->email,'id'=>$app->mysubjects->id));
        }
        elseif(isset($app->mysubjects->status) && $app->mysubjects->status=='save'){

            if(isset($app->mysubjects->description_verified)){
                $description = $app->mysubjects->description_verified;
            }
            else{
                $description = $app->mysubjects->description;
            }

            $update = [
                'description'=>$description,
                'last_modified'=>thedate(),
                'status'=>'needs-review'
            ];
            $app->connect->update('avid___user_subjects',$update,array('email'=>$app->actualuser->email,'id'=>$app->mysubjects->id));
        }
        elseif(isset($app->mysubjects->status) && $app->mysubjects->status=='delete'){
            $app->mysubjects->subject_slug = NULL;
            $app->connect->delete('avid___user_subjects',array('email'=>$app->actualuser->email,'id'=>$app->mysubjects->id));
        }
        else{
            printer('UHOH!');
        }
        $app->redirect($app->actualuser->url.'/my-subjects/'.$app->mysubjects->parent_slug.'/'.$app->mysubjects->subject_slug);
    }
    elseif($app->actualuser->email==$app->user->email && isset($app->makechanges)){

        if(checkagainst($app->makechanges,$allowed)!==true){

            $updateUser = [];
            $updateProfile = [];

            if(isset($app->makechanges->mytagline)){

                if(isset($app->adminnow)){
                    $updateProfile['short_description_verified'] = $app->makechanges->mytagline;
                }
                elseif(!empty($app->actualuser->short_description_verified) && $app->makechanges->mytagline != $app->actualuser->short_description_verified){
                    $updateProfile['short_description'] = $app->makechanges->mytagline;
                }
                elseif(!empty($app->actualuser->short_description_verified) && $app->makechanges->mytagline == $app->actualuser->short_description_verified){
                    $updateProfile['short_description'] = $app->makechanges->mytagline;
                    $updateProfile['short_description_verified'] = $app->makechanges->mytagline;
                }
                else{
                    $updateProfile['short_description'] = $app->makechanges->mytagline;
                }

            }

            if(isset($app->makechanges->statement)){

                if(isset($app->adminnow)){
                    $updateProfile['personal_statement_verified'] = $app->makechanges->statement;
                }
                elseif(!empty($app->actualuser->personal_statement_verified) && $app->makechanges->statement != $app->actualuser->personal_statement_verified){
                    $updateProfile['personal_statement'] = $app->makechanges->statement;
                }
                elseif(!empty($app->actualuser->personal_statement_verified) && $app->makechanges->statement == $app->actualuser->personal_statement_verified){
                    $updateProfile['personal_statement'] = $app->makechanges->statement;
                    $updateProfile['personal_statement_verified'] = $app->makechanges->statement;
                }
                else{
                    $updateProfile['personal_statement'] = $app->makechanges->statement;
                }

            }

            if(isset($app->makechanges->zipcode) && isset($app->makechanges->locationinfo)){
                $zipdata = get_zipcode_data($app->connect,$app->makechanges->zipcode);
                if(isset($zipdata->id)){

                    $updateUser['zipcode'] = $zipdata->zipcode;
                    $updateUser['state'] = $zipdata->state;
                    $updateUser['state_long'] = $zipdata->state_long;
                    $updateUser['`lat`'] = $zipdata->lat;
                    $updateUser['`long`'] = $zipdata->long;
                    $updateUser['state_slug'] = $zipdata->state_slug;
                    $updateUser['city_slug'] = $zipdata->city_slug;
                    $updateUser['city'] = $zipdata->city;

                    $updateUser['url'] = update_zipcode($app->actualuser,$zipdata);
                }
            }


            $updateUser['first_name'] = ($app->makechanges->first_name ? $app->makechanges->first_name : $app->actualuser->first_name);
            $updateUser['last_name'] = ($app->makechanges->last_name ? $app->makechanges->last_name : $app->actualuser->last_name);
            $updateProfile['hourly_rate'] = ($app->makechanges->hourly_rate ? $app->makechanges->hourly_rate : $app->actualuser->hourly_rate);
            $updateProfile['gender'] = ($app->makechanges->gender ? $app->makechanges->gender : $app->actualuser->gender);
            $updateProfile['travel_distance'] = ($app->makechanges->travel_distance ? $app->makechanges->travel_distance : $app->actualuser->travel_distance);
            $updateProfile['cancellation_policy'] = ($app->makechanges->cancellation_policy ? $app->makechanges->cancellation_policy : $app->actualuser->cancellation_policy);
            $updateProfile['cancellation_rate'] = ($app->makechanges->cancellation_rate ? $app->makechanges->cancellation_rate : $app->actualuser->cancellation_rate);
            $updateProfile['online_tutor'] = ($app->makechanges->online_tutor ? $app->makechanges->online_tutor : $app->actualuser->online_tutor);

            if(isset($updateUser['url'])){
                $url = $updateUser['url'];
            }
            else{
                $url = $app->actualuser->url;
            }

            $app->connect->update('avid___user_profile',$updateProfile,array('email'=>$app->actualuser->email));
            $app->connect->update('avid___user',$updateUser,array('email'=>$app->actualuser->email));
            $app->redirect($url);
        }
        else{
            notify($app->makechanges);
            notify('UHOH!');
        }

    }
    elseif(isset($app->myavatar->name)){
        $app->connect->update('avid___user_profile',array('my_avatar'=>$app->myavatar->name),array('email'=>$app->actualuser->email));
        $app->redirect($app->actualuser->url.'/my-photos');
    }
    elseif(isset($app->myphoto->status)){

        $path = APP_PATH.'uploads/photos/';
        $pathApproved = DOCUMENT_ROOT.'profiles/approved/';
        $myfile = $app->actualuser->my_upload;
        $upload = $path.$myfile;
        $cropped = croppedfile($path.$myfile);
        $approved = $pathApproved.$myfile;

        if($app->myphoto->status=='crop'){
            $app->redirect($app->actualuser->url.'/my-photos/crop-photo');
        }
        elseif($app->myphoto->status=='delete'){
            $deleteRequest = array(
        		'type'=>'My Photo',
        		'email'=>$app->actualuser->email
        	);

        	$app->connect->delete('avid___user_needsprofilereview',$deleteRequest);

        	if(file_exists($upload)){
        		unlink($upload);
        	}
        	if(file_exists($cropped)){
        		unlink($cropped);
        	}
        	if(file_exists($approved)){
        		unlink($approved);
        	}

            $delete = ['my_upload'=>NULL,'my_upload_status'=>NULL];
            $app->connect->update('avid___user_profile',$delete,array('email'=>$app->actualuser->email));


        }
        elseif($app->myphoto->status=='rotate-right'){
            $app->imagemanager->make($cropped)->rotate(-90)->save();
        }
        elseif($app->myphoto->status=='rotate-left'){
            $app->imagemanager->make($cropped)->rotate(90)->save();
        }
        elseif($app->myphoto->status=='approve'){

            $deleteRequest = array(
            	'type'=>'My Photo',
            	'email'=>$app->actualuser->email
            );

            $delete = $app->connect->delete('avid___user_needsprofilereview',$deleteRequest);

            if($delete==true){
            	$app->mailgun->to = $app->actualuser->email;
            	$app->mailgun->subject = 'Your photo has been approved';
            	$app->mailgun->message = 'Congratulations, your photo has been approved.';
            	$app->mailgun->send();
            }

            $photos = APP_PATH.'uploads/photos/';
            $approved = DOCUMENT_ROOT.'profiles/approved/';

            $myfile = $app->actualuser->my_upload;
            $cropped = croppedfile($myfile);

            copy($photos.$cropped, $approved.$cropped);

            $app->connect->update('avid___user_profile',array('my_upload_status'=>'verified'),array('email'=>$app->actualuser->email));

        }
        elseif($app->myphoto->status=='reject'){
            $filePath = croppedfile($app->actualuser->my_upload);
            $fileName = str_replace(APP_PATH.'uploads/photos/','',$filePath);
            $newfile = DOCUMENT_ROOT.'profiles/approved/'.$fileName;

            if(file_exists($newfile)){
            	unlink($newfile);
            }


            $app->connect->update('avid___user_profile',array('my_upload_status'=>'needs-review'),array('email'=>$app->actualuser->email));
        }

        $app->redirect($app->actualuser->url.'/my-photos');
    }
    elseif(isset($app->upload)){
        if(isset($app->upload) && $upload = makefileupload((object)$_FILES['upload'],'file')){

			if(isset($upload->tmp_name)){

				$uploaddir = APP_PATH.'uploads/photos/';

				$type = getfiletype($upload->name);
				$filename = $app->actualuser->username.$type;
				$uploadfile = $uploaddir.$filename;

				$img = $app->imagemanager->make($upload->tmp_name)->save($uploadfile);
				$width = $img->width();
				$height = $img->height();
				$mime = $img->mime();

                $app->connect->update('avid___user_profile',array('my_upload'=>$filename,'my_upload_status'=>'needs-review'),array('email'=>$app->actualuser->email));

				$app->redirect($app->actualuser->url.'/my-photos/crop-photo');

			}

		}
    }
    elseif(isset($app->resizecrop)){

        $app->img->resize($app->resizecrop->width, NULL, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        $app->redirect($app->actualuser->url.'/my-photos/crop-photo');

    }
    elseif(isset($app->crop)){
        // MIGHT Work
        $croppedfile = croppedfile($app->actualuser->my_upload);
		$path = APP_PATH.'uploads/photos/';
		$myupload = $path.$app->actualuser->my_upload;
		$croppedfile = $path.$croppedfile;

		if(isset($app->crop->fullwidth)){


			$filetype = getfiletype($app->actualuser->my_upload);
			$thefile = $app->actualuser->username.$filetype;
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

			if($app->actualuser->my_upload_status=='verified'){

				$photos = APP_PATH.'uploads/photos/';
				$approved = DOCUMENT_ROOT.'profiles/approved/';
				//
				$myfile = $app->actualuser->my_upload;
				$cropped = croppedfile($myfile);

				copy($photos.$cropped,$approved.$cropped);
			}
		}

		$app->connect->update('avid___user_profile',array('my_upload_status'=>NULL),array('email'=>$app->actualuser->email));
		$app->redirect($app->actualuser->url.'/my-photos');
        // MIGHT NOT
    }
    elseif(isset($app->administer)){
        //notify($app->actualuser);
        $updateuser = [];

        $lock = 1;
        $status = NULL;
        if($app->administer->status=='free-and-clear'){
            $lock = NULL;
            $status = NULL;
            $updateuser['hidden'] = NULL;
        }
        else{
            $status = $app->administer->status;
        }


        if($app->administer->anotheragency=='yes'){
            $app->administer->anotheragency = 1;
        }
        else{
            $app->administer->anotheragency = NULL;
        }

        $updateuser['anotheragency'] = $app->administer->anotheragency;
        $updateuser['anotheragency_rate'] = $app->administer->anotheragency_rate;
        $updateuser['`lock`'] = $lock;
        $updateuser['status'] = $status;


        $app->connect->update('avid___user',$updateuser,array('email'=>$app->actualuser->email));


        new Flash(
        	array(
        		'action'=>'alert',
        		'message'=>'Profile Updated'
        	)
        );
    }
