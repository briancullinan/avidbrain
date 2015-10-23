<?php

    if(isset($app->easy)){

        if(empty($app->easy->name)){
            new Flash(array('action'=>'required','message'=>'Please enter your name','formID'=>'itseasy','field'=>'name'));
        }
        elseif(empty($app->easy->email)){
            new Flash(array('action'=>'required','message'=>'Please enter your email address','formID'=>'itseasy','field'=>'email'));
        }
        // elseif(empty($app->easy->password)){
        //     new Flash(array('action'=>'required','message'=>'Please type in a password','formID'=>'itseasy','field'=>'password'));
        // }
        // elseif(strlen($app->easy->password) < 6){
        //     new Flash(array('action'=>'required','message'=>'Passwords must be at least <span>6 characters</span>','formID'=>'itseasy','field'=>'password'));
		// }

        if(doesuserexist($app->connect,$app->easy->email)){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup'));
		}

        $randomSix = random_numbers(5);
        $password = $password = password_hash($randomSix, PASSWORD_DEFAULT);
		$validation_code = random_numbers_guarantee($app->connect,16);

        $inserttemp = array(
			'email'=>$app->easy->email,
			'password'=>$password,
			'usertype'=>'student',
			'signup_date'=>thedate(),
			'promocode'=>'easy-signup',
			'validation_code'=>$validation_code,
			'first_name'=>$app->easy->name,
			'last_name'=>NULL,
			'terms_of_service'=>1,
			//'parent'=>$app->easy->parent,
			'temppass'=>NULL,
			'zipcode'=>NULL,
			'city'=>NULL,
			'state'=>NULL,
			'state_long'=>NULL,
			'`lat`'=>NULL,
			'`long`'=>NULL,
			'phone'=>$app->easy->phone
		);

        $insert = $app->connect->insert('avid___users_temp',$inserttemp);

        $welcomeMessage = '<p>Thank your for signing up.</p>';
		$welcomeMessage.= '<p>Someone will contact you shortly to setup your free Student Profile</p>';

		$app->mailgun->to = $app->easy->email;
		$app->mailgun->subject = 'Welcome to AvidBrain';
		$app->mailgun->message = $welcomeMessage;
		$app->mailgun->send();

        $serverinfo = (object)$_SERVER;
		if(isset($app->easy->name)){$firstname=$app->easy->name;}else{$firstname=NULL;}
		if(isset($app->easy->phone)){$phone=$app->easy->phone;}else{$phone=NULL;}
		if(isset($app->easy->promocode)){$promocode=$app->easy->promocode;}else{$promocode=NULL;}
		if(isset($app->easy->zipcode)){$zipcode=$app->easy->zipcode;}else{$zipcode=NULL;}
		if(isset($serverinfo->REMOTE_ADDR)){$remoteAddress=$serverinfo->REMOTE_ADDR;}else{$remoteAddress=NULL;}
		if(isset($serverinfo->REQUEST_URI)){$url=$serverinfo->REQUEST_URI;}else{$url=NULL;}
		if(isset($serverinfo->HTTP_REFERER)){$referrer=$serverinfo->HTTP_REFERER;}else{$referrer=NULL;}

		$newstudentEmail = '';
		$newstudentEmail.= '<p>Date: '.formatdate(thedate(),'M. jS, Y @ g:i a').'</p>';
		$newstudentEmail.= '<p> Email: '.$app->easy->email.' </p>';
		$newstudentEmail.= '<p> Name: '.$firstname.'  </p>';
		$newstudentEmail.= '<p> Phone: '.$phone.' </p>';
		$newstudentEmail.= '<p> Promo Code: easy-setup </p>';
		$newstudentEmail.= '<p> <strong>Server Info</strong> </p>';
		$newstudentEmail.= '<p> IP Address: '.$remoteAddress.' </p>';
		$newstudentEmail.= '<p> URL: '.$url.' </p>';
		$newstudentEmail.= '<p> Referrer: '.$referrer.' </p>';
		$newstudentEmail.= '<p> Password: '.$randomSix.' </p>';
		$newstudentEmail.= '<p> Activate Account: <a href="'.$app->dependents->DOMAIN.'/validate/'.$validation_code.'">Click Here</a> </p>';



		if($app->dependents->DOMAIN=='http://avidbrain.dev'){
			$toemails = 'david@avidbrain.com';
		}
		else{
			$toemails = 'jake.stoll@avidbrain.com,keith@avidbrain.com,david@avidbrain.com';
		}

		$app->mailgun->to = $toemails;
		$app->mailgun->subject = 'New Easy Setup Signup';
		$app->mailgun->message = $newstudentEmail;
		$app->mailgun->send();


        new Flash(array('action'=>'jump-to','formID'=>'itseasy','location'=>'/confirmation/easy-signup','message'=>'Signup Success'));

    }
