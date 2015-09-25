<?php
	
	$setup	=	$app->connect->createQueryBuilder()->
			select('sessions.*, user.first_name, user.last_name, user.usertype, user.url, user.customer_id, profile.custom_avatar, profile.showmyphotoas, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, settings.getemails,settings.showfullname')->from('avid___sessions','sessions')->
			where('sessions.jobid = :id')->setParameter(':id',$id)->orWhere('sessions.id = :id')->
			andWhere('from_user = :from_user')->setParameter(':from_user',$app->user->email)->
			innerJoin('sessions','avid___user','user','user.email = sessions.to_user')->
			innerJoin('sessions','avid___user_profile','profile','profile.email = sessions.to_user')->
			innerJoin('sessions','avid___user_account_settings','settings','settings.email = sessions.to_user')->
			execute()->fetch();
			
			
			if($setup->session_status=='canceled-session'){
				$app->redirect('/sessions/view/'.$id);
			}
			elseif(isset($setup->session_status) && $setup->session_status=='complete' || isset($setup->dispute)){
				$app->redirect('/sessions/view/'.$id);
			}
			
			if(empty($setup->id)){
				$app->redirect('/sessions');
			}
			else{
				$app->setup = $setup;
				if(isset($app->setup->session_timestamp)){			
					$app->setup->dateDiff = sessionDateDiff($app->setup->session_timestamp);
				}
			}
			
//			notify($action);
			
	if(isset($action) && $action=='cancel'){
		
		
		$email = new stdClass();
		$email->email =$app->setup->to_user;
		$payrate = calculate_payrate($app->connect,$app->viewsession,$email);
		$amount = ($app->user->cancellation_rate*100);
		$amount = stripe_transaction($amount);
		
		$cancelsessionwithcharge = array(
			'amount' => $amount,
			'currency' => 'usd',
			'customer' => $app->setup->customer_id,
			'description' => 'Canceled Tutoring Session With $'.$app->user->cancellation_rate.' Charge',
			'receipt_email' => $app->setup->to_user
		);
		
		$session = array(
			'pending'=>NULL,
			'session_date'=>$app->setup->session_date,
			'session_cost'=>$amount,
			'session_length'=>NULL,
			'session_status'=>'canceled-session',
			'payrate'=>$payrate,
			'payment_details'=>NULL
		);
		
		if(isset($app->setup->roomid)){
			$session['roomid'] = NULL;
			$deleteroom = array(
				'api_key'=>'27D1B127-9CCB-A496-810CC85CDECC42D1',
				'function'=>'rooms.delete',
				'roomid'=>$app->setup->roomid
			);
			$newroom = scribblar($deleteroom);
		}
		
		try{
			$chargeCard = \Stripe\Charge::create($cancelsessionwithcharge);
		}
		catch(\Stripe\Error\Card $e){
			
			$stripeErrors = handleStripe($e);
			$insert = array(
				'status'=>$stripeErrors->status,
				'type'=>$stripeErrors->type,
				'code'=>$stripeErrors->code,
				'message'=>$stripeErrors->message,
				'email'=>$app->setup->to_user,
				'date'=>thedate(),
				'session_id'=>$id
			);
			$app->connect->insert('avid___crediterrors',$insert);
			$message = str_replace('Your card was','Credit card',$stripeErrors->message);
			
			$updateSession = array(
				'payment_details'=>'Credit Card Error',
				'pending'=>NULL
			);
			$app->connect->update('avid___sessions',$updateSession,array('id'=>$id,'from_user'=>$app->user->email));
			
			new Flash(
				array(
					'action'=>'jump-to',
					'message'=>$message,
					'location'=>'/sessions/broken-sessions/'
				)
			);
			
		}
		
		if(isset($chargeCard->id)){
			//
			$payment = array(
				'email'=>$app->setup->to_user,
				'type'=>'Canceled Tutoring Session',
				'amount'=>$amount,
				'date'=>thedate(),
				'charge_id'=>$chargeCard->id,
				'session_id'=>$app->setup->id,
				'recipient'=>$app->setup->from_user
			);
			
			$app->connect->insert('avid___user_payments',$payment);
			$app->connect->update('avid___sessions',$session,array('id'=>$id,'from_user'=>$app->user->email));
			
			
			$subject = 'Session Canceled with $'.$app->user->cancellation_rate.' Charge ';
			$message = '<p>'.short($app->user).' just canceled your tutoring session.</p>';
			$message.='<p><a href="/sessions/view/'.$app->setup->id.'">View Session Details</a></p>';
			
			if(isset($app->setup->getemails) && $app->setup->getemails=='yes'){
				
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
			
			$app->redirect('/sessions/view/'.$app->setup->id);
			//
		}
	}
	elseif(isset($action) && $action=='cancelnocharge'){
		
		$subject = 'Session Canceled';
		$message = '<p>'.short($app->user).' just canceled your tutoring session.</p>';
		$message.='<p><a href="/sessions/view/'.$app->setup->id.'">View Session Details</a></p>';
		
		$session = array(
			'pending'=>NULL,
			'session_length'=>NULL,
			'session_status'=>'canceled-session',
			'payrate'=>NULL,
			'payment_details'=>NULL
		);
		
		if(isset($app->setup->roomid)){
			$session['roomid'] = NULL;
			
			$deleteroom = array(
				'api_key'=>'27D1B127-9CCB-A496-810CC85CDECC42D1',
				'function'=>'rooms.delete',
				'roomid'=>$app->setup->roomid
			);
			
			$newroom = scribblar($deleteroom);
			
		}
		
		if(isset($app->setup->getemails) && $app->setup->getemails=='yes'){
			
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
		
		$app->connect->update('avid___sessions',$session,array('id'=>$id,'from_user'=>$app->user->email));
		
		$app->redirect('/sessions/view/'.$app->setup->id);
		
	}
			
	$app->meta = new stdClass();
	$app->meta->title = 'Setup Tutoring Session';
	$app->meta->h1 = 'Setup Tutoring Session';