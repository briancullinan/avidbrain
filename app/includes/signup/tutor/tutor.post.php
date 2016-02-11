<?php

	if(isset($app->getprices)){

		//notify($app->getprices);

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
	elseif(isset($app->tutorsignup->tutor)){

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

		//notify($app->tutorsignup->tutor);

		$query = "SELECT email FROM signup_avidbrain.signup___signups WHERE email = :email ";
		$prepare = array(':email'=>$app->tutorsignup->tutor->email);
		$signupcount = $app->connect->executeQuery($query,$prepare)->rowCount();
		if($signupcount>0){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'tutorsignup','field'=>'ts_email'));
		}


		$message = 'Welcome to '.SITENAME_PROPPER.', please call 1-800-485-3138 to setup an interview.';
		$messagePlus = '<p>Please allow 24 hours to process your application.</p>';
		$messagePlus.= '<p><a href="https://signup.avidbrain.com/interview-schedule.html" target="_blank">View our current interview schedule.</a></p>';

		$app->mailgun->to = $app->tutorsignup->tutor->email;
		$app->mailgun->subject = 'Thank you for signing up with '.SITENAME_PROPPER;
		$app->mailgun->message = $message.$messagePlus;
		$app->mailgun->send();

		try{
			$app->twilio->account->messages->create(array(
				'To' => $tophone,
				'From' => TWILIO_NUMBER,
				'Body' => $message
			));
		}
		catch(Exception $e){
			//echo '<pre>'; print_r($e); echo '</pre>';
		}

		$password = password_hash($app->tutorsignup->tutor->password, PASSWORD_BCRYPT);
		$tutoredbefore = NULL;
		if(isset($app->tutorsignup->tutor->taughttutored) && $app->tutorsignup->tutor->taughttutored=='on'){
			$tutoredbefore = true;
		}

		$prepare = array(
			'name'=>$app->tutorsignup->tutor->first_name.' '.$app->tutorsignup->tutor->last_name,
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
			'howdidyouhear'=>$app->tutorsignup->tutor->howdidyouhear
		);

		$insert = $app->connect->insert('signup_avidbrain.signup___signups',$prepare);

		new Flash(array('action'=>'jump-to','formID'=>'tutorsignup','location'=>'/confirmation/tutor-signup','message'=>'Signup Success'));

	}
