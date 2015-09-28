<?php
	
	if(isset($app->defaultphototype->type)){
		
		$app->currentuser->showmyphotoas = $app->defaultphototype->type;
		$app->currentuser->save();
		$app->redirect($app->currentuser->url.'/my-photos');	
		
	}
	
	if(isset($app->customizeavatar)){
		unset($app->customizeavatar->target);
		
		$jsonencode = json_encode($app->customizeavatar);
		$app->currentuser->custom_avatar = $jsonencode;
		$app->currentuser->save();
		
		if(empty($app->customizeavatar->dontshow)){
			new Flash(
				array(
					'action'=>'alert',
					'message'=>'Avatar Saved'
				)
			);	
		}
		
	}
	
	if(isset($app->currentuser->email) && isset($app->user->email) && $app->currentuser->email == $app->user->email){
		if(isset($app->myavatar)){
		
			$app->currentuser->my_avatar = $app->myavatar->name;
			$app->currentuser->save();
			$app->redirect($app->currentuser->url.'/my-photos');
			
		}
		elseif(isset($app->editprofile)){
			
			if(isset($app->editprofile->birthday)){
				$app->editprofile->birthday = str_replace(array('	',"\n","\r"),'',$app->editprofile->birthday);
			}
			
			
			$allowed = array(
				'cancellation_rate',
				'travel_distance',
				'cancellation_policy',
				'online_tutor',
				'hourly_rate',
				'zipcode',
				'birthday',
				'first_name',
				'last_name',
				'short_description',
				'personal_statement',
				'gender'
			);
			
			if(isset($app->user->usertype) && $app->user->usertype=='admin'){
				$allowed[] = 'short_description_verified';
				$allowed[] = 'personal_statement_verified';
			}
			
			foreach($allowed as $issetValue){
				if(isset($app->editprofile->$issetValue)){
					$app->currentuser->$issetValue = $app->editprofile->$issetValue;
				}	
			}
			
			if(isset($app->currentuser->short_description_verified) && isset($app->editprofile->short_description) && $app->editprofile->short_description != $app->currentuser->short_description_verified){
				$app->currentuser->short_description_verified = NULL;
			}
			
			if(isset($app->currentuser->personal_statement_verified) && isset($app->editprofile->personal_statement) && $app->editprofile->personal_statement != $app->currentuser->personal_statement_verified){
				$app->currentuser->personal_statement_verified = NULL;
			}
			
			
			if(isset($app->editprofile->hourly_rate) && $app->editprofile->hourly_rate < 20){
				new Flash(array('action'=>'alert','message'=>'$20 Minimum Required'));
			}
			if(isset($app->editprofile->hourly_rate) && $app->editprofile->hourly_rate > 500){
				new Flash(array('action'=>'alert','message'=>'$500 Maximum Rate'));
			}
			if(isset($app->editprofile->gender) && !in_array($app->editprofile->gender,array(NULL,'male','female'))){
				new Flash(array('action'=>'alert','message'=>'Invalid Gender'));
			}
			if(isset($app->editprofile->online_tutor) && !in_array($app->editprofile->online_tutor,array('online','offline','both'))){
				new Flash(array('action'=>'alert','message'=>'Invalid Tutor Type'));
			}
			
			if(isset($app->editprofile->hourly_rate) && !is_numeric($app->editprofile->hourly_rate)){
				new Flash(array('action'=>'alert','message'=>'Invalid Number'));
			}
			if(isset($app->editprofile->travel_distance) && !is_numeric($app->editprofile->travel_distance)){
				new Flash(array('action'=>'alert','message'=>'Invalid Number'));
			}
			if(isset($app->editprofile->cancellation_policy) && !is_numeric($app->editprofile->cancellation_policy)){
				new Flash(array('action'=>'alert','message'=>'Invalid Number'));
			}
			if(isset($app->editprofile->cancellation_rate) && !is_numeric($app->editprofile->cancellation_rate)){
				new Flash(array('action'=>'alert','message'=>'Invalid Number'));
			}
			if(isset($app->editprofile->cancellation_rate) && $app->editprofile->cancellation_rate > 100){
				new Flash(array('action'=>'alert','message'=>'$100 Maximum Cancellation Rate'));
			}
			
			
			if(isset($app->editprofile->zipcode)){
				$zipData = get_zipcode_data($app->connect,$app->editprofile->zipcode);
			
				if($zipData==false){
					new Flash(array('action'=>'required','message'=>"Invalid Zip Code"));
				}
				
				$directory = $app->dependents->APP_PATH.'uploads/photos/';
				
				$oldurl = str_replace('/','--',$app->currentuser->url);
				$olduploads = glob($directory.$oldurl.'*');
				
				$app->currentuser->url = update_zipcode($app->currentuser,$zipData);
				$app->currentuser->city = $zipData->city;
				$app->currentuser->city_slug = $zipData->city_slug;
				$app->currentuser->zipcode = $zipData->zipcode;
				$app->currentuser->state = $zipData->state;
				$app->currentuser->state_long = $zipData->state_long;
				$app->currentuser->state_slug = $zipData->state_slug;
				
				$app->currentuser->lat = $zipData->lat;
				$app->currentuser->long = $zipData->long;
				
				$newupload = str_replace('/','--',$app->currentuser->url);
				
				$checkforapproved = str_replace($directory,'',$app->currentuser->my_upload);
				$approvedDir = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$checkforapproved;
				$newname = str_replace($oldurl,$newupload,$approvedDir);
				$newname = croppedfile($newname);
				if(file_exists(croppedfile($approvedDir))){
					rename(croppedfile($approvedDir), $newname);
				}
				
				if(is_array($olduploads)){
					foreach($olduploads as $oldname){
						$newname = str_replace($oldurl,$newupload,$oldname);
						rename($oldname,$newname);
					}
				}
				if(isset($app->currentuser->my_upload)){
					$app->currentuser->my_upload = str_replace($oldurl,$newupload,$app->currentuser->my_upload);
				}
			}
			
			
			$app->currentuser->save();
			
			if(isset($oldurl)){
				new Flash(array('action'=>'jump-to','location'=>$app->currentuser->url,'message'=>'Account URL Changed'));
			}
			
			
			new Flash(array('action'=>'alert','message'=>'Profile Updated'));
			
		}
		elseif(isset($app->upload) && $upload = makefileupload((object)$_FILES['upload'],'file')){
			
			if(isset($upload->tmp_name)){
				
				$uploaddir = $app->dependents->APP_PATH.'uploads/photos/';
				//$uploadfile = $uploaddir.'/'.$app->currentuser->email.getfiletype($upload->name);
				$uploadfile = $uploaddir.str_replace('/','--',$app->currentuser->url).getfiletype($upload->name);
				
				$img = $app->imagemanager->make($upload->tmp_name)->save($uploadfile);
				$width = $img->width();
				$height = $img->height();
				$mime = $img->mime();
				
				$resize = NULL;
				
				$minimumWidth = 150;
				if($width < $minimumWidth){
					$resize = $minimumWidth;
				}
				elseif($width > $app->upload->width){
					$resize = $app->upload->width;
				}
				
				if(isset($resize)){
					$img->resize($resize, NULL, function ($constraint) {
					    $constraint->aspectRatio();
					})->save();
				}
				
				$app->currentuser->my_upload = $uploadfile;
				$app->currentuser->my_upload_status = 'needs-review';
				$app->currentuser->save();
				$app->redirect($app->currentuser->url.'/my-photos');
				
			}
			
		}
		elseif(isset($app->addvideo)){
			
			// Check to see if the url is a youtube url			
			if(strpos($app->addvideo->newvideo, 'https://youtu.be/') === false){
				new Flash(array('action'=>'alert','message'=>'Invalid Youtube Link'));
			}
			
			$sql = "SELECT `order` FROM avid___user_videos WHERE email = :email ORDER BY `order` DESC LIMIT 1";
			$prepeare = array(':email'=>$app->currentuser->email);
			$sortMax = $app->connect->executeQuery($sql,$prepeare)->fetch();
			$next = NULL;
			if(isset($sortMax->order)){
				$next = ($sortMax->order + 1);
			}
			else{
				$next = 1;
			}
			
			$insert = array(
				'email'=>$app->currentuser->email,
				'date'=>thedate(),
				'url'=>$app->addvideo->newvideo,
				'`order`'=>$next,
			);
			$app->connect->insert('avid___user_videos',$insert);
			
			new Flash(array('action'=>'jump-to','location'=>$app->request->getPath(),'message'=>'Video Added'));
		}
		elseif(isset($app->videosorder)){
			unset($app->videosorder->target);
			
			foreach($app->videosorder as $key=> $neworderarray){
				$sql = "UPDATE avid___user_videos SET `order` = :neworder WHERE id = :id AND email = :email";
				$prepeare = array(':email'=>$app->currentuser->email,':id'=>$key,':neworder'=>($neworderarray+1));
				$results = $app->connect->executeQuery($sql,$prepeare);
			}
			new Flash(array('action'=>'alert','message'=>'Video Order Saved'));
			
		}
		else{
			notify($app->keyname);
		}
	}
	else{
		
		if(isset($app->user->email) && isset($app->messagingsystem)){
			
			$app->sendmessage->to_user = $app->currentuser->email;
			$app->sendmessage->from_user = $app->user->email;
			$app->sendmessage->location = 'inbox';
			$app->sendmessage->send_date = thedate();
			$app->sendmessage->subject = $app->messagingsystem->subject;
			$app->sendmessage->message = $app->messagingsystem->message;
			if(isset($app->messagingsystem->extra)){
				$app->sendmessage->parent_id = $app->messagingsystem->extra;
			}
			$app->sendmessage->newmessage();
			
			if($app->currentuser->getemails=='yes'){
				$app->mailgun->to = $app->currentuser->email;
				$app->mailgun->subject = $app->messagingsystem->subject;
				$app->mailgun->message = $app->messagingsystem->message;
				$app->mailgun->send();
			}
			
			new Flash(array('action'=>'kill-form','formID'=>'messagingsystem','message'=>'Message Sent'));
			
		}
		
	}