<?php

	if(isset($app->tutorsignup->tutor)){

		if(isset($app->tutorsignup->tutor->promocode)){
			$app->tutorsignup->tutor->promocode = strtolower($app->tutorsignup->tutor->promocode);
		}

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

		if(isset($app->tutorsignup->tutor->promocode) && $app->tutorsignup->tutor->promocode=='holidays'){
			$sql = "
				SELECT
					user.promocode
				FROM
					avid___user user
				WHERE
					user.promocode = :promocode
			";
			$prepare = array(
				':promocode'=>$app->tutorsignup->tutor->promocode
			);
			$howmany = $app->connect->executeQuery($sql,$prepare)->rowCount();
			if($howmany < 100){
				$app->tutorsignup->tutor->promocode = 'get80';
			}
		}
		elseif(isset($app->tutorsignup->tutor->promocode) && $app->tutorsignup->tutor->promocode=='iteach'){
			$sql = "
				SELECT
					user.promocode
				FROM
					avid___user user
				WHERE
					user.promocode = :promocode
			";
			$prepare = array(
				':promocode'=>$app->tutorsignup->tutor->promocode
			);
			$howmany = $app->connect->executeQuery($sql,$prepare)->rowCount();
			if($howmany < 100){
				$app->tutorsignup->tutor->promocode = 'get80--free-backgroundcheck';
			}
		}

		$password = password_hash($app->tutorsignup->tutor->password, PASSWORD_BCRYPT);
		$tutoredbefore = NULL;
		if(isset($app->tutorsignup->tutor->taughttutored) && $app->tutorsignup->tutor->taughttutored=='on'){
			$tutoredbefore = true;
		}

		$token = password_hash(uniqid().$app->tutorsignup->tutor->email.time(),PASSWORD_BCRYPT);

		$app->tutorsignup->tutor->promocode = NULL;
		if(isset($app->isvalidpromo)){
			$app->tutorsignup->tutor->promocode = $app->isvalidpromo->promocode;
		}


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
			'howdidyouhear'=>$app->tutorsignup->tutor->howdidyouhear,
			'token'=>$token
		);

		$insert = $app->connect->insert('avid___new_temps',$prepare);

		$_SESSION['temptutor']['email'] = $app->crypter->encrypt($app->tutorsignup->tutor->email);
		$_SESSION['temptutor']['token'] = $app->crypter->encrypt($token);

		if(DEBUG==true){
			$emails = 'admins@mindspree.com';
		}
		else{
			$emails = 'admins@mindspree.com';
		}


		$message = '<p>A New tutor has started their application to become a tutor.</p>';
		$message.='<p>Name: '.$app->tutorsignup->tutor->first_name.' '.$app->tutorsignup->tutor->last_name.' </p>';
		$message.='<p>Email: '.$app->tutorsignup->tutor->email.' </p>';
		$message.='<p>Phone: '.$app->tutorsignup->tutor->phone.' </p>';
		$message.='<p>Why Tutor: '.$app->tutorsignup->tutor->reasons.' </p>';

		$app->mailgun->to = $emails;
		$app->mailgun->subject = 'New Tutor Signup';
		$app->mailgun->message = $message;
		$app->mailgun->send();

		$app->mailgun->to = $app->tutorsignup->tutor->email;
		$app->mailgun->subject = 'MindSpree Tutor Signup';
		$app->mailgun->message = 'Thank you for signing up with MindSpree. You may login by going to <a href="'.DOMAIN.'/signup/tutor">Tutor Login</a>';
		$app->mailgun->send();

		$googleHTML = '<!-- Google Code for Tutor Sign Up Conversion Page -->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 945094692;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "DbEpCKHBlWMQpIDUwgM";
		var google_remarketing_only = false;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/945094692/?label=DbEpCKHBlWMQpIDUwgM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>';

		new Flash(array('action'=>'jump-to','formID'=>'tutorsignup','location'=>'/signup/tutor','message'=>'Step 1 Complete'.$googleHTML));

	}
	elseif(isset($app->li)){
		if(empty($app->li->email)){
			new Flash(array('action'=>'required','message'=>'Email Address Required','formID'=>'signuplogin','field'=>'li_email'));
		}
		elseif(empty($app->li->password)){
			new Flash(array('action'=>'required','message'=>'Password Required','formID'=>'signuplogin','field'=>'li_password'));
		}

		$sql = "SELECT id,email,url FROM avid___user WHERE email = :email";
		$prepare = array(':email'=>$app->li->email);
		$isauser = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($isauser->id)){
			new Flash(array('action'=>'jump-to','message'=>'Please Login','formID'=>'signuplogin','location'=>'/login'));
		}

		// Check to see if the user exists
		$sql = "SELECT * FROM avid___new_temps WHERE email = :email";
		$prepare = array(':email'=>$app->li->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(!empty($results->complete)){
			new Flash(array('action'=>'required','message'=>'Your Application Is Under Review','formID'=>'signuplogin','field'=>'li_password'));
		}

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
		elseif($app->aboutme->gender=='--'){
			new Flash(array('action'=>'required','message'=>'Please select an option','formID'=>'aboutme','field'=>'aboutme_gender'));
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
			'`long`'=>$zipcodedata->long,
			'aboutme'=>1
		);

		$app->connect->update('avid___new_temps',$updateaboutme,array('email'=>$app->newtutor->email));

		new Flash(array('action'=>'jump-to','location'=>'/signup/tutor/uploadresume','message'=>'About Me Saved'));

	}
	elseif(isset($app->tutoringinfo)){

		if(isset($app->tutoringinfo->hourly_rate)){
			$period = strpos($app->tutoringinfo->hourly_rate, '.');
			$comma = strpos($app->tutoringinfo->hourly_rate, ',');
		}

		if($period!=false || $comma!=false){
			new Flash(array('action'=>'required','message'=>'Please enter a number only, no commas or periods','formID'=>'tutoringinfo','field'=>'tutoringinfo_hourly_rate'));
		}

		if(isset($app->tutoringinfo->hourly_rate)){
			$app->tutoringinfo->hourly_rate = preg_replace("/[^0-9]/","",$app->tutoringinfo->hourly_rate);
		}

		if(empty($app->tutoringinfo->hourly_rate)){
			new Flash(array('action'=>'required','message'=>'Houlry Rate Required','formID'=>'tutoringinfo','field'=>'tutoringinfo_hourly_rate'));
		}
		elseif(!is_numeric($app->tutoringinfo->hourly_rate)){
			new Flash(array('action'=>'required','message'=>'Invalid Number','formID'=>'tutoringinfo','field'=>'tutoringinfo_hourly_rate'));
		}
		elseif($app->tutoringinfo->hourly_rate<10){
			new Flash(array('action'=>'required','message'=>'$10 Minimum Hourly Rate','formID'=>'tutoringinfo','field'=>'tutoringinfo_hourly_rate'));
		}
		// elseif(empty($app->tutoringinfo->references)){
		// 	new Flash(array('action'=>'required','message'=>'Please provide 3 references','formID'=>'tutoringinfo','field'=>'tutoringinfo_references'));
		// }
		elseif($app->tutoringinfo->travel_distance=='--'){
			new Flash(array('action'=>'required','message'=>'Please select an option','formID'=>'tutoringinfo','field'=>'tutoringinfo_travel_distance'));
		}
		elseif($app->tutoringinfo->online_tutor=='--'){
			new Flash(array('action'=>'required','message'=>'Please select an option','formID'=>'tutoringinfo','field'=>'tutoringinfo_online_tutor'));
		}
		elseif($app->tutoringinfo->cancellation_policy=='--'){
			new Flash(array('action'=>'required','message'=>'Please select an option','formID'=>'tutoringinfo','field'=>'tutoringinfo_cancellation_policy'));
		}
		elseif($app->tutoringinfo->cancellation_rate=='--'){
			new Flash(array('action'=>'required','message'=>'Please select an option','formID'=>'tutoringinfo','field'=>'tutoringinfo_cancellation_rate'));
		}

		$updatetutoringinfo = array(
			'cancellation_policy'=>$app->tutoringinfo->cancellation_policy,
			'cancellation_rate'=>$app->tutoringinfo->cancellation_rate,
			'hourly_rate'=>$app->tutoringinfo->hourly_rate,
			'online_tutor'=>$app->tutoringinfo->online_tutor,
			'travel_distance'=>$app->tutoringinfo->travel_distance,
			//'`references`'=>$app->tutoringinfo->references,
			'tutorinfo'=>1
		);

		$app->connect->update('avid___new_temps',$updatetutoringinfo,array('email'=>$app->newtutor->email));

		new Flash(array('action'=>'jump-to','location'=>'/signup/tutor/uploadaphoto','message'=>'Tutoring Information Saved'));
		//new Flash(array('action'=>'alert','message'=>'Tutoring Information Saved'));
	}
	elseif(isset($app->uploadresume) && $upload = makefileupload((object)$_FILES['uploadresume'],'file')){
		$uploadfile = getfiletype($upload->name);

		$allowed = array(
			'text/plain',
			'application/pdf',
			'text/rtf',
			'application/vnd.oasis.opendocument.text',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
		);
		if(!in_array($upload->type, $allowed)){
			notify(array('action'=>'required','postdata'=>'buffalo','message'=>'Invalid File Type'));
		}
		else{
			//.pdf, .doc, .docx, .rtf, .odt
			$filename = $app->newtutor->email.$uploadfile;
			$uploadPath = APP_PATH.'uploads/resumes/'.$filename;


			move_uploaded_file($upload->tmp_name, $uploadPath);

			$app->connect->update('avid___new_temps',array('my_resume'=>$filename),array('email'=>$app->newtutor->email));

			$app->redirect('/signup/tutor/tutoringinformation');
		}
	}
	elseif(isset($app->uploadphoto) && $upload = makefileupload((object)$_FILES['uploadphoto'],'file')){



		$allowed = array(
			'image/png',
			'image/jpeg',
			'image/jpg',
			'image/gif'
		);
		if(!in_array($upload->type, $allowed)){
			notify(array('action'=>'required','postdata'=>'buffalo','message'=>'Invalid File Type'));
		}
		else{
			$uploadfile = getfiletype($upload->name);
			$filename = $app->newtutor->email.$uploadfile;
			$uploadPath = APP_PATH.'uploads/photos/';

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

			$app->redirect('/signup/tutor/');
		}

	}
	elseif(isset($app->crop)){

		if(isset($app->crop->fullwidth)){
			$filetype = getfiletype($app->newtutor->upload);
			$thefile = $app->newtutor->email.$filetype;
			$checkfile = $thefile;
			$location = APP_PATH.'uploads/photos/';
			if(file_exists($location.$checkfile)){
				$file = $checkfile;
			}

			$img = $app->imagemanager->make($location.$file);
			$cropped = croppedfile($location.$file);
			$croppedfileName = $cropped;


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
			$croppedfile = croppedfile($app->newtutor->upload);
			$croppedfileName = $croppedfile;
			$myfile = APP_PATH.'uploads/photos/'.$app->newtutor->upload;
			$croppedfile = APP_PATH.'uploads/photos/'.$croppedfile;
			$cropped = $app->imagemanager->make($myfile)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->save($croppedfile); //->resize(250,250)
			$height = $app->imagemanager->make($croppedfile)->height();
			$width = $app->imagemanager->make($croppedfile)->width();



			if($height > 500 || $width > 500){
				$cropped = $app->imagemanager->make($myfile)->crop($app->crop->w, $app->crop->h, $app->crop->x, $app->crop->y)->resize(500,500)->save($croppedfile);
			}
		}

		$croppedfileName = str_replace(APP_PATH.'uploads/photos/','',$croppedfileName);///var/www/amozek.dev/app/uploads/photos/



		$app->connect->update('avid___new_temps',array('addaphoto'=>1,'cropped'=>$croppedfileName),array('email'=>$app->newtutor->email));
		$app->redirect('/signup/tutor/mysubjects');

	}
	elseif(isset($app->mysubjects)){

		$parentslug = str_replace('-','',$app->mysubjects->parent_slug);
		$jump = $app->mysubjects->parent_slug;

		unset($app->mysubjects->parent_slug);
		unset($app->mysubjects->target);

		$thesubinfo = array($parentslug=>$app->mysubjects)[$parentslug];

		$make = array();
		foreach($thesubinfo as $key=> $build){
			if(empty($build->remove)){
				if(!empty($build->id)){
					$make[$key]['id'] = $build->id;
				}
				if($build->description){
					$make[$key]['description'] = $build->description;
				}
			}
		}

		$mysubjects = json_encode($make);


		$app->connect->update('avid___new_temps',array('subjectsitutor'=>1,'mysubs_'.$parentslug=>$mysubjects),array('email'=>$app->newtutor->email));

		//new Flash(array('action'=>'alert','message'=>'Subjects Saved'));

		$app->redirect('/signup/tutor/category/'.$jump.'#mysubjects');
	}
	elseif(isset($app->backgroundcheckstep1)){

		// START
			$app->backgroundcheckstep1->phone = preg_replace("/[^0-9,.]/", "", $app->backgroundcheckstep1->phone);
			$app->backgroundcheckstep1->ssn = preg_replace("/[^0-9,.]/", "", $app->backgroundcheckstep1->ssn);

			//notify();
			if(isset($app->backgroundcheckstep1->dob->month) && isset($app->backgroundcheckstep1->dob->day) && isset($app->backgroundcheckstep1->dob->year)){

			}

			//$app->backgroundcheckstep1->birthday = str_replace('-','/',$app->backgroundcheckstep1->birthday);
			if(isset($app->backgroundcheckstep1->middle_name)){
				$checknon = strtolower($app->backgroundcheckstep1->middle_name);
			}

			if(empty($app->backgroundcheckstep1->first_name)){
				new Flash(array('action'=>'required','message'=>'First Name Required','formID'=>'backgroundcheckstep1','field'=>'first_name'));
			}
			elseif(empty($app->backgroundcheckstep1->last_name)){
				new Flash(array('action'=>'required','message'=>'Last Name Required','formID'=>'backgroundcheckstep1','field'=>'last_name'));
			}
			elseif(empty($app->backgroundcheckstep1->middle_name)){
				new Flash(array('action'=>'required','message'=>'Middle Name Required <span>Type NONE, if you dont have a middle name</span>','formID'=>'backgroundcheckstep1','field'=>'middle_name'));
			}
			elseif(empty($app->backgroundcheckstep1->ssn)){
				new Flash(array('action'=>'required','message'=>'Social Security Number Required','formID'=>'backgroundcheckstep1','field'=>'ssn'));
			}
			elseif(!is_numeric($app->backgroundcheckstep1->ssn)){
				new Flash(array('action'=>'required','message'=>'SSN Must Be 9 Digits, No Dashes','formID'=>'backgroundcheckstep1','field'=>'ssn'));
			}
			elseif(strlen($app->backgroundcheckstep1->ssn)!=9){
				new Flash(array('action'=>'required','message'=>'SSN Must Be 9 Digits','formID'=>'backgroundcheckstep1','field'=>'ssn'));
			}
			elseif(empty($app->backgroundcheckstep1->dob->month) || empty($app->backgroundcheckstep1->dob->day) || empty($app->backgroundcheckstep1->dob->year)){
				new Flash(array('action'=>'required','message'=>'Birth Date Required','formID'=>'backgroundcheckstep1','field'=>'birthday'));
			}
			elseif(empty($app->backgroundcheckstep1->zipcode)){
				new Flash(array('action'=>'required','message'=>'Zip Code Required','formID'=>'backgroundcheckstep1','field'=>'zipcode'));
			}
			elseif(strlen($app->backgroundcheckstep1->zipcode)!=5){
				new Flash(array('action'=>'required','message'=>'Zipcode Must Be 5 Digits','formID'=>'backgroundcheckstep1','field'=>'zipcode'));
			}
			elseif(empty($app->backgroundcheckstep1->phone)){
				new Flash(array('action'=>'required','message'=>'Phone Required','formID'=>'backgroundcheckstep1','field'=>'phone'));
			}

			$check = checkdate($app->backgroundcheckstep1->dob->month,$app->backgroundcheckstep1->dob->day,$app->backgroundcheckstep1->dob->year);
			if($check!=true){
				new Flash(array('action'=>'required','message'=>'Invalid Birth Date','formID'=>'backgroundcheckstep1','field'=>'birthday'));
			}
			$birthday = $app->backgroundcheckstep1->dob->year.'-'.$app->backgroundcheckstep1->dob->month.'-'.$app->backgroundcheckstep1->dob->day;

			if(isset($checknon) && $checknon=='none'){
				//$app->backgroundcheckstep1->middle_name = true;
				$app->backgroundcheckstep1->middle_name = 'no_middle_name';
			}

			$update = array(
				'first_name'=>$app->backgroundcheckstep1->first_name,
				'middle_name'=>$app->backgroundcheckstep1->middle_name,
				'last_name'=>$app->backgroundcheckstep1->last_name,
				'zipcode'=>$app->backgroundcheckstep1->zipcode,
				'phone'=>$app->backgroundcheckstep1->phone,
				'dob'=>$app->crypter->encrypt($birthday),
				'ssn'=>$app->crypter->encrypt($app->backgroundcheckstep1->ssn),
				'step1'=>1
			);
			$app->connect->update('avid___new_temps',$update,array('email'=>$app->newtutor->email));

			if(isset($app->backgroundcheckstep1->location) && $app->backgroundcheckstep1->location=='completecheck'){
				$url = '/background-check/step2';
			}
			else{
				$url = '/signup/tutor/step2#steps';
			}

			new Flash(array('action'=>'jump-to','message'=>'Application Info Saved','formID'=>'backgroundcheckstep1','location'=>$url));
		// END

	}
	elseif(isset($app->backgroundcheckstep2)){

		if(empty($app->backgroundcheckstep2->step2)){
			new Flash(array('action'=>'required','message'=>'Please acknowledge receipt of the Summary of Your Rights','formID'=>'backgroundcheckstep2','field'=>'agreement2'));
		}

		$app->connect->update('avid___new_temps',array('step2'=>1),array('email'=>$app->newtutor->email));

		if(isset($app->backgroundcheckstep2->location) && $app->backgroundcheckstep2->location=='completecheck'){
			$url = '/background-check/step3';
		}
		else{
			$url = '/signup/tutor/step3#steps';
		}

		new Flash(array('action'=>'jump-to','message'=>'Summary of Your Rights Acknowledged','formID'=>'backgroundcheckstep1','location'=>$url));

	}
	elseif(isset($app->backgroundcheckstep3)){

		if(empty($app->backgroundcheckstep3->step3)){
			new Flash(array('action'=>'required','message'=>'Please acknowledge Disclosure Regarding Background Investigation','formID'=>'backgroundcheckstep2','field'=>'agreement2'));
		}

		$app->connect->update('avid___new_temps',array('step3'=>1),array('email'=>$app->newtutor->email));

		if(isset($app->backgroundcheckstep3->location) && $app->backgroundcheckstep3->location=='completecheck'){
			$url = '/background-check/step4';
		}
		else{
			$url = '/signup/tutor/step4#steps';
		}

		new Flash(array('action'=>'jump-to','message'=>'Background Investigation Agreement Saved','formID'=>'backgroundcheckstep1','location'=>$url));

	}
	elseif(isset($app->backgroundcheckstep4)){
		//notify($app->backgroundcheckstep4);

		if(empty($app->backgroundcheckstep4->electronic_signature)){
			new Flash(array('action'=>'required','message'=>'Electronic Signature Required','formID'=>'backgroundcheckstep4','field'=>'electronic_signature'));
		}

		$step4 = array(
			'step4'=>1,
			'electronic_signature'=>$app->crypter->encrypt($app->backgroundcheckstep4->electronic_signature),
			'electronic_signature_date'=>thedate()
		);
		if(isset($app->backgroundcheckstep4->sendreport)){
			$step4['send_report'] = $app->backgroundcheckstep4->sendreport;
		}

		$app->connect->update('avid___new_temps',$step4,array('email'=>$app->newtutor->email));

		if(isset($app->backgroundcheckstep4->location) && $app->backgroundcheckstep4->location=='completecheck'){
			$url = '/background-check/step5';
		}
		else{
			$url = '/signup/tutor/step5#steps';
		}

		new Flash(array('action'=>'jump-to','message'=>'Disclosure Regarding Background Investigation Acknowledged','formID'=>'backgroundcheckstep1','location'=>$url));

	}
	elseif(isset($app->stripe)){

		$payment = array(
			'amount'=>'2999',
			'currency'=>'usd',
			'card'=>$app->stripe->stripeToken,
			'description'=>'Purchased Background Check',
			'receipt_email'=>$app->newtutor->email
		);

		// ERRORS
		try {

		 $chargeCard = \Stripe\Charge::create($payment);


		} catch(\Stripe\Error\Card $e) {
		  // Since it's a decline, \Stripe\Error\Card will be caught
		  $body = $e->getJsonBody();
		  $err  = $body['error'];

		  #print('Status is:' . $e->getHttpStatus() . "\n");
		  #print('Type is:' . $err['type'] . "\n");
		  #print('Code is:' . $err['code'] . "\n");
		  // param is '' in this case
		  //print('Param is:' . $err['param'] . "\n");
		  //print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
		  // Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
		  // Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
		  // Authentication with Stripe's API failed
		  // (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
		  // Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
		  // Display a very generic error to the user, and maybe send
		  // yourself an email
		} catch (Exception $e) {
		  // Something else happened, completely unrelated to Stripe
		}

		$url = '/signup/tutor/step6#steps';

			if(isset($err['message'])){
				echo $err['message'].' Please <a href="'.$url.'">Refresh Page</a> and Try Again.';
				exit;
			}

		if(isset($chargeCard->id)){

			$step5 = array(
				'step5'=>'1',
				'charge_id'=>$chargeCard->id
			);

			$app->connect->update('avid___new_temps',$step5,array('email'=>$app->newtutor->email));

			$app->redirect($url);
		}
		else{
			echo 'Error';
			exit;
		}

	}
	elseif(isset($app->finishapplication)){

		if(isset($app->newtutor->complete) && !empty($app->newtutor->complete)){
			notify('UHOH~!');
		}

		if(empty($app->finishapplication->alldone)){
			new Flash(array('action'=>'alert','message'=>'Please Complete Everything Before Submitting'));
		}

		if(empty($app->finishapplication->timeday)){
			$app->finishapplication->timeday = NULL;
		}
		if(empty($app->finishapplication->yesinterview)){
			$app->finishapplication->yesinterview = NULL;
		}

		//$app->finishapplication
		$app->connect->update('avid___new_temps',array('complete'=>1,'timeday'=>$app->finishapplication->timeday,'yesinterview'=>$app->finishapplication->yesinterview),array('email'=>$app->newtutor->email));

		$_SESSION['csrf_token'] = NULL;
		$_SESSION['slim.flash'] = NULL;
		$_SESSION['temptutor']['email'] = NULL;
		$_SESSION['temptutor']['token'] = NULL;
		unset($_SESSION);
		session_destroy();

		$message = '';
		$message.='<p> <strong> Name: </strong> '.$app->newtutor->first_name.' '.$app->newtutor->last_name.' </p>';
		$message.='<p> <strong> Location: </strong> '.$app->newtutor->city.', '.$app->newtutor->state_long.' </p>';
		$message.='<p> <strong> How Did You Hear About Us?: </strong> '.$app->newtutor->howdidyouhear.' </p>';
		$message.='<p> <strong> Short Description: </strong> '.$app->newtutor->short_description.' </p>';
		$message.='<p> <strong> Personal Statement: </strong> '.$app->newtutor->personal_statement.' </p>';
		if(!empty($app->newtutor->yesinterview)){
			$message.='<p> <strong> I would like to have an interview: </strong> '.$app->newtutor->timeday.' </p>';
		}
		if(!empty($app->newtutor->candidate_id)){
			$message.='<p> <strong> Background Check Purchased  </strong> </p>';
		}

		if(DEBUG==true){
			$emails = 'admins@mindspree.com';
		}
		else{
			$emails = 'admins@mindspree.com';
		}

		$app->mailgun->to = $emails;
		$app->mailgun->subject = 'A new tutor has completed their tutor profile';
		$app->mailgun->message = $message;
		$app->mailgun->send();

		$message = '';
		$message.='<p> Thank you for completing the signup process, we will take a look at your application and get back to you shortly. </p>';

		$app->mailgun->to = $app->newtutor->email;
		$app->mailgun->subject = 'MindSpree Tutor Signup';
		$app->mailgun->message = $message;
		$app->mailgun->send();


		new Flash(array('action'=>'jump-to','formID'=>'signuplogin','location'=>'/confirmation/new-tutor-signup','message'=>'Application Submitted For Approval'));

	}
	elseif(isset($app->getprices)){
		$zipData = get_zipcode_data($app->connect,$app->getprices->zipcode);
		if($zipData==false){
			new Flash(array('action'=>'required','message'=>"Zip Code Not Valid"));
		}

		$cachename = strtolower(str_replace(' ','',$app->getprices->subject)).'-'.$app->getprices->zipcode;
		$cachedpricequote = $app->connect->cache->get($cachename);
		if($cachedpricequote == null) {

			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('user.id,profile.hourly_rate')->from('avid___user','user');
			$data	=	$data->where('user.usertype = :usertype')->setParameter(':usertype','tutor');
			$data	=	$data->andWhere('user.status IS NULL');
			$data	=	$data->andWhere('user.hidden IS NULL');
			$data	=	$data->andWhere('profile.hourly_rate IS NOT NULL');
			$data	=	$data->andWhere('user.lock IS NULL');

			$data	=	$data->addSelect('subjects.subject_name');
			$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
			$data	=	$data->andWhere('subjects.subject_name LIKE :subject_name');
			$data	=	$data->andWhere('subjects.status = :verified')->setParameter(':verified','verified');
			$data	=	$data->setParameter(':subject_name',"%".$app->getprices->subject."%");

			$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
			$getDistance = " round(((acos(sin((" . $zipData->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipData->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipData->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515)  ";
			$app->getDistance = true;
			$asDistance = ' as distance ';
			$data	=	$data->addSelect($getDistance.$asDistance)->setParameter(':distance',20)->having("distance <= :distance");
			$data	=	$data->execute()->fetchAll();

			$total = count($data);

			if($total>0){
				$sumTotal = 0;
				foreach($data as $sum){
					$sumTotal = ($sumTotal + $sum->hourly_rate);
				}
				$average = round(($sumTotal/$total));
			}
			else{
				$average = 'Nothing Found';
			}


			$returnedData = $average;

			$cachedpricequote = $returnedData;
			$app->connect->cache->set($cachename, $returnedData, 3600);

		}

		if($cachedpricequote=='Nothing Found'){
			new Flash(array('action'=>'custom','message'=>'<div class="red white-text">Nothing Found</div>','target'=>'.show-prices'));
		}
		else{
			new Flash(array('action'=>'custom','message'=>'<div class="blue white-text">'.$app->getprices->subject.' tutors in '.$zipData->city.' make an average: $'.numbers($cachedpricequote).' an hour</div>','target'=>'.show-prices'));
		}
	}
	elseif(isset($app->myresume->resume_text)){

		$app->connect->update('avid___new_temps',array('resume_text'=>$app->myresume->resume_text,'my_resume'=>$app->myresume->resume_text),array('email'=>$app->newtutor->email));

		#notify($app->myresume->resume_text);
		$app->redirect('/signup/tutor/tutoringinformation');
		#new Flash(array('action'=>'jump-to','formID'=>'signuplogin','location'=>'/confirmation/new-tutor-signup','message'=>'Application Sent'));
	}
