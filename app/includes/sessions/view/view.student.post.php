<?php

	if(isset($app->sessionreviews)){

		if(empty($app->sessionreviews->review_text) && empty($app->sessionreviews->review_score)){
			new Flash(array('action'=>'required','formID'=>'sessionreviews','message'=>'Please leave a score, or a review'));
		}

		if(isset($app->sessionreviews->review_text) && strlen($app->sessionreviews->review_text) > 500){
			new Flash(array('action'=>'required','formID'=>'sessionreviews','message'=>'<span>500</span> Characters Maximum '.strlen($app->sessionreviews->review_text).'/500'));
		}

		$subject = short($app->user).' has reviewed your latest tutoring session';
		$message = '<p>'.short($app->user).' has reviewed your latest tutoring session.</p>';
		$message = '<p><a href="/sessions/view/'.$id.'">View Session Details</a></p>';


		if(isset($app->sessionreviews->review_score) && $app->sessionreviews->review_score>0){

			$stars = get_stars($app->sessionreviews->review_score);

			$message.= '<p>Star Score: '.$app->sessionreviews->review_score.'/5 Stars</p>';

		}
		if(isset($app->sessionreviews->review_text)){
			$message.= '<p>Review: '.$app->sessionreviews->review_text.'</p>';
		}

		$messageview = '<p> <a href="'.DOMAIN.'">View More Info</a> </p>';

		if(isset($app->viewsession->getemails) && $app->viewsession->getemails=='yes'){
			$app->mailgun->to = $app->viewsession->from_user;
			$app->mailgun->subject = $subject;
			$app->mailgun->message = $message.$messageview;
			$app->mailgun->send();
		}

		$app->sendmessage->to_user = $app->viewsession->from_user;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();


		$update = array(
			'review_score'=>$app->sessionreviews->review_score,
			'review_text'=>$app->sessionreviews->review_text,
			'review_date'=>thedate(),
			'review_name'=>$app->user->email
		);

		//notify($update);

		$app->connect->update('avid___sessions', $update, array('to_user' => $app->user->email,'id'=>$id));
		if(empty($stars->icons)){
			$stars = new stdClass();
			$stars->icons = NULL;
		}

		new Flash(array('action'=>'jump-to','formID'=>'sessionreviews','location'=>'/sessions/view/'.$id,'message'=>'Review Posted '.$stars->icons));


	}
	elseif(isset($app->disputeclaim)){

		$subject = short($app->user).' has filed a payment dispute.';
		$message = '<p>'.short($app->user).' has filed a payment dispute for your last tutoring session.</p>';
		$message.='<p><strong>Reason:</strong> '.$app->disputeclaim->dispute_reason.'</p>';
		$message.='<p><a class="btn" href="/sessions/view/'.$id.'">View Session Info</a></p>';

		if(isset($app->viewsession->getemails) && $app->viewsession->getemails=='yes'){
			$app->mailgun->to = $app->viewsession->from_user;
			$app->mailgun->subject = $subject;
			$app->mailgun->message = $message;
			$app->mailgun->send();
		}

		$app->sendmessage->to_user = $app->viewsession->from_user;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();

		$dispute = array(
			'dispute'=>1,
			'dispute_date'=>thedate(),
			'dispute_text'=>$app->disputeclaim->dispute_reason,
			'session_status'=>'dispute'
		);

		$app->connect->update('avid___sessions', $dispute, array('to_user' => $app->user->email,'id'=>$id));


		new Flash(array('action'=>'jump-to','formID'=>'sessionreviews','location'=>'/sessions/view/'.$id,'message'=>'Dispute Filed'));

	}
	elseif(isset($app->disputeaction->value)){

		//notify('imaturtle');

		if($app->disputeaction->value=='yes'){
			$dispute = array(
				'dispute'=>NULL,
				'session_status'=>'complete'
			);

			$app->connect->update('avid___sessions', $dispute, array('to_user' => $app->user->email,'id'=>$id));

			new Flash(array('action'=>'jump-to','formID'=>'sessionreviews','location'=>'/sessions/view/'.$id,'message'=>'Dispute Removed'));
		}
		elseif($app->disputeaction->value=='no'){

			$message = 'Please help with a contested session. Session Info: <a href="/sessions/view/'.$id.'">View Session</a>';

			$contest = array(
				'dispute_support'=>1,
				'contest_dispute_text'=>$message
			);

			$app->mailgun->to = 'support@mindspree.com';
			$app->mailgun->subject = 'Contest Dispute';
			$app->mailgun->message = $message;
			$app->mailgun->send();


			$app->connect->update('avid___sessions',$contest,array('to_user'=>$app->user->email,'id'=>$id));

			new Flash(
				array('action'=>'jump-to','message'=>'Messes Sent To Support','location'=>'/sessions/view/'.$id)
			);

		}
	}
	else{
		notify(SITENAME_PROPPER);
	}
