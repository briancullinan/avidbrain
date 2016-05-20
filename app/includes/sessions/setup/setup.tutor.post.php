<?php

	if(isset($app->setupsession) && isset($app->setup)){

		if(crediterror($app->connect,$app->setup->to_user)==true){
			new Flash(
				array(
					'action'=>'alert',
					'message'=>'Invalid Credit Card'
				)
			);
		}

		$creditcard = get_creditcard($app->setup->customer_id);
		if($creditcard==NULL){

			//notify('OHNO');

			$html = '<p class="confirm-payment-box orange white-text"> '.short($app->setup).' has no credit card on file. Please request they add it, so you can proceed. </p>';
			$html.= '<p><a class="btn btn-block" href="'.$app->setup->url.'/send-message" target="_blank">Send Message</a></p>';
			new Flash(
				array('action'=>'confirm-payment','html'=>$html,'message'=>'Please Confirm','secret'=>random_all(12))
			);

		}


		if(isset($app->setup->session_subject) && isset($app->setupsession->session_subject) && $app->setup->session_subject!=$app->setupsession->session_subject){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'Tutoring Subject Already Set'));
		}

		if(isset($app->setupsession->session_rate) && $app->setupsession->session_rate < MinimumSessionRate){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$'.MinimumSessionRate.'</span> Minimum Session Limit'));
		}

		if(isset($app->setupsession->session_rate) && $app->setupsession->session_rate>MaximumSessionRate){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$'.MaximumSessionRate.'</span> Maximum Session Limit'));
		}

		$updateinfo = array(
			'proposed_length'=>$app->setupsession->proposed_length,
			'session_date'=>$app->setupsession->session_date,
			'session_location'=>$app->setupsession->session_location,
			//'session_online'=>$app->setupsession->session_online,
			'session_rate'=>$app->setupsession->session_rate,
			'session_subject'=>$app->setupsession->session_subject,
			'session_time'=>$app->setupsession->session_time,
			'student_notes'=>$app->setupsession->student_notes,
			'session_timestamp'=>sessionTimestamp($app->setupsession),
			'jobsetup'=>NULL,
			'pending'=>1
		);

		if(isset($app->setupsession->whiteboard) && $app->setupsession->whiteboard=='yes' && empty($app->setup->roomid)){

			$createRoom = array(
				'api_key'=>SCRIBBLAR_ID,
				'function'=>'rooms.add',
				'roomname'=>'Tutor with '.short($app->user),
				'allowguests'=>1,
				'clearassets'=>1,
				'roomowner'=>$app->user->email
			);

			$newroom = scribblar($createRoom);
			$updateinfo['roomid'] = $newroom['result']['roomid'];
		}

		$app->connect->update('avid___sessions',$updateinfo,array('id'=>$app->setup->id));

		if(isset($app->setup->session_timestamp)){
			$subject = 'Tutoring Session Updated';
			$message = '<p>'.short($app->user).' has updated a tutoring session. </p>';
		}
		else{
			$subject = 'New Tutoring Session Setup';
			$message = '<p>'.short($app->user).' has setup a tutoring session. </p>';
		}


		$message.='<p> <strong>Session Rate:</strong> $'.$app->setupsession->session_rate.'/Hour </p>';
		$message.='<p> <strong>Session Date:</strong> '.formatdate(sessionTimestamp($app->setupsession)).' @ '.$app->setupsession->session_time.' </p>';
		$message.='<p> <strong>Session Location:</strong> '.$app->setupsession->session_location.' </p>';
		//$message.='<p> <strong>Online/Offline:</strong> '.online_session($app->setupsession->session_online).' </p>';
		$message.='<p> <strong>Session Subject:</strong> '.$app->setupsession->session_subject.' </p>';
		if(isset($app->setupsession->student_notes)){$message.='<p> <strong>Notes:</strong> '.$app->setupsession->student_notes.' </p>';}

		$message.='<p><a class="btn" href="/sessions/view/'.$app->setup->id.'">View Session Details</a></p>';

		if(isset($app->setupsession->getemails) && $app->setup->getemails=='yes'){

			$app->mailgun->to = $app->setup->to_user;
			$app->mailgun->subject = $subject;
			$app->mailgun->message = $message;
			$app->mailgun->send();

		}

		$app->sendmessage->to_user = $app->setup->to_user;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();

		new Flash(array('action'=>'jump-to','location'=>$app->request->getPath(),'formID'=>'setupsession','message'=>'Session Updated'));

		//	new Flash(array('action'=>'alert','formID'=>'setupsession','message'=>'Session Updated'));

	}
