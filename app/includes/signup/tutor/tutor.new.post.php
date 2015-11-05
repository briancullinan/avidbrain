<?php

	/*
		state,
		state_long,
		state_slug,
		city,
		city_slug,
		zipcode,
		lat,
		long,
		signup_date,
		phone,
		username,

		hourly_rate,
		travel_distance,
		cancellation_policy,
		cancellation_rate,
		gender,
		short_description,
		personal_statement,
		my_upload,
		my_upload_status,
		online_tutor
	*/

	if(isset($app->tutorsignup->tutor)){

		if(isset($app->tutorsignup->tutor->phone)){
			$app->tutorsignup->tutor->phone = preg_replace("/[^0-9,.]/", "", $app->tutorsignup->tutor->phone);
		}

		if(empty($app->tutorsignup->tutor->first_name)){
			new Flash(array('action'=>'required','message'=>'First Name Required','formID'=>'tutorsignup','field'=>'ts_first_name'));
		}
		elseif(empty($app->tutorsignup->tutor->last_name)){
			new Flash(array('action'=>'required','message'=>'Last Name Required','formID'=>'tutorsignup','field'=>'ts_last_name'));
		}
		elseif(empty($app->tutorsignup->tutor->email)){
			new Flash(array('action'=>'required','message'=>'Email Address Required','formID'=>'tutorsignup','field'=>'ts_email'));
		}
		elseif(doesuserexist($app->connect,$app->tutorsignup->tutor->email)==true){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'tutorsignup','field'=>'ts_email'));
		}
		elseif(empty($app->tutorsignup->tutor->phone)){
			new Flash(array('action'=>'required','message'=>'Telephone Number Required','formID'=>'tutorsignup','field'=>'ts_phone'));
		}
		elseif(empty($app->tutorsignup->tutor->phone)){
			new Flash(array('action'=>'required','message'=>'Telephone Number Required','formID'=>'tutorsignup','field'=>'ts_phone'));
		}
		elseif(strlen($app->tutorsignup->tutor->phone)!=10){
			new Flash(array('action'=>'required','message'=>'Telephone Number Must Be 10 Digits','formID'=>'tutorsignup','field'=>'ts_phone'));
		}
		elseif(empty($app->tutorsignup->tutor->password)){
			new Flash(array('action'=>'required','message'=>'Password Required','formID'=>'tutorsignup','field'=>'ts_password'));
		}
		elseif(strlen($app->tutorsignup->tutor->password) < 6){
			new Flash(array('action'=>'required','message'=>'Password must be at least 6 characters','formID'=>'tutorsignup','field'=>'ts_password'));
		}
		elseif(empty($app->tutorsignup->tutor->reasons)){
			new Flash(array('action'=>'required','message'=>'Why do you want to be a tutor?','formID'=>'tutorsignup','field'=>'ts_reasons'));
		}
		elseif(empty($app->tutorsignup->tutor->agerestrictions)){
			new Flash(array('action'=>'required','message'=>'Please verify your age','formID'=>'tutorsignup','field'=>'ts_agerestrictions'));
		}
		elseif(empty($app->tutorsignup->tutor->legalresident)){
			new Flash(array('action'=>'required','message'=>'Please verify your U.S. Work Status','formID'=>'tutorsignup','field'=>'ts_legalresident'));
		}

		$query = "SELECT email FROM signup_avidbrain.signup___signups WHERE email = :email ";
		$prepare = array(':email'=>$app->tutorsignup->tutor->email);
		$signupcount = $app->connect->executeQuery($query,$prepare)->rowCount();
		if($signupcount>0){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'tutorsignup','field'=>'ts_email'));
		}

		$password = password_hash($app->tutorsignup->tutor->password, PASSWORD_BCRYPT);
		$tutoredbefore = NULL;
		if(isset($app->tutorsignup->tutor->taughttutored) && $app->tutorsignup->tutor->taughttutored=='on'){
			$tutoredbefore = true;
		}

		$token = password_hash(uniqid().$app->tutorsignup->tutor->email.time(),PASSWORD_BCRYPT);

		$prepare = array(
			'usertype'=>'tutor',
			'first_name'=>$app->tutorsignup->tutor->first_name,
			'last_name'=>$app->tutorsignup->tutor->last_name,
			'email'=>$app->tutorsignup->tutor->email,
			'promocode'=>$app->tutorsignup->tutor->promocode,
			'whytutor'=>$app->tutorsignup->tutor->reasons,
			'signupdate'=>thedate(),
			'phone'=>$app->tutorsignup->tutor->phone,
			'password'=>$password,
			'over18'=>true,
			'legalresident'=>true,
			'tutoredbefore'=>$tutoredbefore,
			'linkedinprofile'=>$app->tutorsignup->tutor->linkedinprofile,
			'howdidyouhear'=>$app->tutorsignup->tutor->howdidyouhear,
			'token'=>$token
		);

		$insert = $app->connect->insert('avid___new_temps',$prepare);

		$_SESSION['temptutor']['email'] = $app->crypter->encrypt($app->tutorsignup->tutor->email);
		$_SESSION['temptutor']['token'] = $app->crypter->encrypt($token);

		new Flash(array('action'=>'jump-to','formID'=>'tutorsignup','location'=>'/signup/tutor','message'=>'Step 1 Complete'));

	}
	elseif(isset($app->li)){
		if(empty($app->li->email)){
			new Flash(array('action'=>'required','message'=>'Email Address Required','formID'=>'signuplogin','field'=>'li_email'));
		}
		elseif(empty($app->li->password)){
			new Flash(array('action'=>'required','message'=>'Password Required','formID'=>'signuplogin','field'=>'li_password'));
		}

		// Check to see if the user exists
		$sql = "SELECT * FROM avid___new_temps WHERE email = :email";
		$prepare = array(':email'=>$app->li->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();

		if(isset($results->id) && password_verify($app->li->password,$results->password)){
			$token = password_hash(uniqid().$results->email.time(),PASSWORD_BCRYPT);
			$_SESSION['temptutor']['email'] = $app->crypter->encrypt($results->email);
			$_SESSION['temptutor']['token'] = $app->crypter->encrypt($token);

			$app->connect->update('avid___new_temps',array('token'=>$token),array('email'=>$results->email));

			new Flash(array('action'=>'jump-to','formID'=>'signuplogin','location'=>'/signup/tutor','message'=>'You are now logged in'));
		}
		else{
			new Flash(array('action'=>'required','message'=>'Invalid Password','formID'=>'signuplogin','field'=>'li_password'));
		}
	}
	elseif(isset($app->aboutme)){

		if(isset($app->aboutme->zipcode)){
			$zipcodedata = get_zipcode_data($app->connect,$app->aboutme->zipcode);
		}

		if(empty($app->aboutme->zipcode)){
			new Flash(array('action'=>'required','message'=>'Zip Code Required','formID'=>'aboutme','field'=>'aboutme_zipcode'));
		}
		elseif(empty($zipcodedata->id)){
			new Flash(array('action'=>'required','message'=>'Invalid Zip Code','formID'=>'aboutme','field'=>'aboutme_zipcode'));
		}
		elseif(empty($app->aboutme->short_description)){
			new Flash(array('action'=>'required','message'=>'Short Description Required','formID'=>'aboutme','field'=>'aboutme_short_description'));
		}
		elseif(empty($app->aboutme->personal_statement)){
			new Flash(array('action'=>'required','message'=>'Personal Statement Required','formID'=>'aboutme','field'=>'aboutme_personal_statement'));
		}

		$updateaboutme = array(
			'zipcode'=>$app->aboutme->zipcode,
			'short_description'=>$app->aboutme->short_description,
			'personal_statement'=>$app->aboutme->personal_statement,
			'gender'=>$app->aboutme->gender,
			'state'=>$zipcodedata->state,
			'state_long'=>$zipcodedata->state_long,
			'state_slug'=>$zipcodedata->state_slug,
			'city'=>$zipcodedata->city,
			'city_slug'=>$zipcodedata->city_slug,
			'`lat`'=>$zipcodedata->lat,
			'`long`'=>$zipcodedata->long
		);

		$app->connect->update('avid___new_temps',$updateaboutme,array('email'=>$app->newtutor->email));

		new Flash(array('action'=>'alert','message'=>'About Me Saved'));

	}
	elseif(isset($app->tutoringinfo)){

		if(isset($app->tutoringinfo->hourly_rate)){
			$app->tutoringinfo->hourly_rate = preg_replace("/[^0-9]/","",$app->tutoringinfo->hourly_rate);
		}

		if(empty($app->tutoringinfo->hourly_rate)){
			new Flash(array('action'=>'required','message'=>'Houlry Rate Required','formID'=>'tutoringinfo','field'=>'tutoringinfo_hourly_rate'));
		}
		elseif(!is_numeric($app->tutoringinfo->hourly_rate)){
			new Flash(array('action'=>'required','message'=>'Invalid Number','formID'=>'tutoringinfo','field'=>'tutoringinfo_hourly_rate'));
		}
		elseif(empty($app->tutoringinfo->references)){
			new Flash(array('action'=>'required','message'=>'Please provide 3 references','formID'=>'tutoringinfo','field'=>'tutoringinfo_references'));
		}

		$updatetutoringinfo = array(
			'cancellation_policy'=>$app->tutoringinfo->cancellation_policy,
			'cancellation_rate'=>$app->tutoringinfo->cancellation_rate,
			'hourly_rate'=>$app->tutoringinfo->hourly_rate,
			'online_tutor'=>$app->tutoringinfo->online_tutor,
			'travel_distance'=>$app->tutoringinfo->travel_distance,
			'`references`'=>$app->tutoringinfo->references
		);

		$app->connect->update('avid___new_temps',$updatetutoringinfo,array('email'=>$app->newtutor->email));

		new Flash(array('action'=>'alert','message'=>'Tutoring Information Saved'));
	}
	elseif(isset($app->uploadphoto) && $upload = makefileupload((object)$_FILES['uploadphoto'],'file')){

		$uploadfile = getfiletype($upload->name);
		$filename = $app->newtutor->email.$uploadfile;
		$uploadPath = $app->dependents->APP_PATH.'uploads/tutorphotos/';

		$img = $app->imagemanager->make($upload->tmp_name)->save($uploadPath.$filename);
		$app->connect->update('avid___new_temps',array('upload'=>$filename),array('email'=>$app->newtutor->email));

		//---------------------------------------------------------------------------

		$width = $img->width();
		$height = $img->height();
		$mime = $img->mime();

		$resize = NULL;

		if($width>$app->uploadphoto->width){
			$resize = $app->uploadphoto->width;
		}

		if(isset($resize)){
			$img->resize($resize, NULL, function ($constraint) {
				$constraint->aspectRatio();
			})->save();
		}
		//---------------------------------------------------------------------------

		$app->redirect('/signup/tutor');

	}
	elseif(isset($app->crop)){

		$croppedfile = croppedfile($app->newtutor->upload);
		$croppedfileName = $croppedfile;
		$myfile = $app->dependents->APP_PATH.'uploads/tutorphotos/'.$app->newtutor->upload;
		$croppedfile = $app->dependents->APP_PATH.'uploads/tutorphotos/'.$croppedfile;
		$cropped = $app->imagemanager->make($myfile)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->save($croppedfile); //->resize(250,250)
		$height = $app->imagemanager->make($croppedfile)->height();
		$width = $app->imagemanager->make($croppedfile)->width();

		if($height > 500 || $width > 500){
			$cropped = $app->imagemanager->make($myfile)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->resize(500,500)->save($croppedfile);
		}
		$app->connect->update('avid___new_temps',array('cropped'=>$croppedfileName),array('email'=>$app->newtutor->email));
		$app->redirect('/signup/tutor');

	}
	elseif(isset($app->mysubjects)){

		$parentslug = str_replace('-','',$app->mysubjects->parent_slug);
		$jump = $app->mysubjects->parent_slug;

		unset($app->mysubjects->parent_slug);
		unset($app->mysubjects->target);

		$mysubjects = json_encode(array($parentslug=>$app->mysubjects));

		$app->connect->update('avid___new_temps',array('mysubs_'.$parentslug=>$mysubjects),array('email'=>$app->newtutor->email));
		$app->redirect('/signup/tutor/category/'.$jump.'#jt-'.$jump);
	}
	else{
		notify($app->keyname);
	}
