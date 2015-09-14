<?php

	if(isset($app->setupsession)){
		
		#notify($app->setupsessionwith);
		#notify($app->setupsession);
		
		if(crediterror($app->connect,$app->setupsessionwith->email)==true){
			new Flash(
				array(
					'action'=>'alert',
					'message'=>'Invalid Credit Card'
				)
			);
		}
		
		$creditcard = get_creditcard($app->setupsessionwith->customer_id);
		
		if($creditcard==NULL){
			
			#notify('OHNO');
		
			$html = '<p class="confirm-payment-box orange white-text"> '.short($app->setupsessionwith).' has no credit card on file. Please request they add it, so you can proceed. </p>';
			$html.= '<p><a class="btn btn-block" href="'.$app->setupsessionwith->url.'/send-message" target="_blank">Send Message</a></p>';
			new Flash(
				array('action'=>'confirm-payment','html'=>$html,'message'=>'Please Confirm','secret'=>random_all(12))
			);
			
		}
		
		$total = (($app->setupsession->session_rate * $app->setupsession->proposed_length) / 60);
		
		if(isset($app->setupsession->session_subject) && isset($app->setupsession->session_subject) && $app->setupsession->session_subject!=$app->setupsession->session_subject){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'Tutoring Subject Already Set'));
		}
		
		if(isset($app->setupsession->session_rate) && $app->setupsession->session_rate< 30){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$30</span> Minimum Session Limit'));
		}
		
		if(isset($app->setupsession->session_rate) && $app->setupsession->session_rate>500){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$500</span> Maximum Session Limit'));
		}
		
		if($total>500){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$500</span> Maximum Session Limit'));
		}
		
		$newsession = array(
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
			'pending'=>1,
			'to_user'=>$app->setupsessionwith->email,
			'from_user'=>$app->user->email,
			'creation_date'=>thedate(),
			'pending'=>1
		);
		
		if(isset($app->setupsession->whiteboard) && $app->setupsession->whiteboard=='yes'){
			$createRoom = array(
				'api_key'=>$app->dependents->scribblarAPI,
				'function'=>'rooms.add',
				'roomname'=>'Tutor with '.short($app->user),
				'allowguests'=>1,
				'clearassets'=>1,
				'roomowner'=>$app->user->email
			);
			
			$newroom = scribblar($createRoom);
			$newsession['roomid'] = $newroom['result']['roomid'];
			$roomid = $newroom['result']['roomid'];
		}
		
		//notify($newsession);
		$app->connect->insert('avid___sessions',$newsession);
		$lastid = $app->connect->lastInsertId();
		
		$subject = 'New Tutoring Session Setup';
		$message = '<p>'.short($app->user).' has setup a tutoring session. </p>';
		
		
		$message.='<p> <strong>Session Rate:</strong> $'.$app->setupsession->session_rate.'/Hour </p>';
		$message.='<p> <strong>Session Date:</strong> '.formatdate(sessionTimestamp($app->setupsession)).' @ '.$app->setupsession->session_time.' </p>';
		$message.='<p> <strong>Session Location:</strong> '.$app->setupsession->session_location.' </p>';
		//$message.='<p> <strong>Online/Offline:</strong> '.online_session($app->setupsession->session_online).' </p>';
		$message.='<p> <strong>Session Subject:</strong> '.$app->setupsession->session_subject.' </p>';
		if(isset($app->setupsession->student_notes)){$message.='<p> <strong>Notes:</strong> '.$app->setupsession->student_notes.' </p>';}
		
		$message.='<p><a class="btn" href="/sessions/view/'.$lastid.'">View Session Details</a></p>';
		
		if(isset($app->setupsessionwith->getemails) && $app->setupsessionwith->getemails=='yes'){
			
			$app->mailgun->to = $app->setupsessionwith->email;
			$app->mailgun->subject = $subject;
			$app->mailgun->message = $message;
			$app->mailgun->send();
			
		}
		
		$app->sendmessage->to_user = $app->setupsessionwith->email;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();
		
		new Flash(array('action'=>'jump-to','location'=>'/sessions/setup/'.$lastid,'formID'=>'setupsession','message'=>'New Session Setup'));
		
		
	}
