<?php
	
	if($app->user->usertype=='student'){
		$type='to_user';
		$type2 = 'from_user';
	}
	elseif($app->user->usertype=='tutor'){
		$type='from_user';
		$type2= 'to_user';
	}
	
	$viewsession	=	$app->connect->createQueryBuilder()->
			select('sessions.*, user.first_name, user.last_name, user.usertype, user.url, user.customer_id, profile.cancellation_rate,profile.custom_avatar, profile.showmyphotoas, profile.cancellation_policy, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, settings.showfullname, settings.getemails')->from('avid___sessions','sessions')->
			where('sessions.id = :id')->setParameter(':id',$id)->
			andWhere($type.' = :myemail')->setParameter(':myemail',$app->user->email)->
			innerJoin('sessions','avid___user','user','user.email = sessions.'.$type2)->
			innerJoin('sessions','avid___user_profile','profile','profile.email = sessions.'.$type2)->
			innerJoin('sessions','avid___user_account_settings','settings','settings.email = sessions.'.$type2)->
			execute()->fetch();
			
			if(empty($viewsession->id)){
				$app->redirect('/sessions');
			}
			else{
				$app->viewsession = $viewsession;
				$app->viewsession->dateDiff = sessionDateDiff($app->viewsession->session_timestamp);
			}
			
	$app->meta = new stdClass();
	$app->meta->title = 'View Tutoring Session';
	$app->meta->h1 = 'View Tutoring Session';
	
	
	if(isset($action)){
		
		if($action=='cancel'){
		
			if(can_i_cancel($app->viewsession)==true){
				
				$session = array(
					'pending'=>NULL,
					'session_date'=>$app->viewsession->session_date,
					'session_cost'=>NULL,
					'session_length'=>NULL,
					'session_status'=>'canceled-session',
					'payrate'=>NULL
				);
				
				$app->connect->update('avid___sessions',$session,array('id'=>$app->viewsession->id,'to_user'=>$app->user->email));
				
				$subject = 'Session Canceled ';
				$message = '<p>'.short($app->user).' just canceled your tutoring session.</p>';
				$message.='<p><a href="/sessions/view/'.$app->viewsession->id.'">View Session Details</a></p>';
				
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
				
				$app->redirect('/sessions/view/'.$app->viewsession->id);
				
			}
			else{
				
				if(!empty($app->viewsession->session_status)){
					$app->redirect('/sessions/view/'.$app->viewsession->id);
				}
				
				$email = new stdClass();
				$email->email =$app->viewsession->to_user;
				$payrate = calculate_payrate($app->connect,$app->viewsession,$email);
				$amount = ($app->viewsession->cancellation_rate*100);
				$amount = stripe_transaction($amount);
				
				$cancelsessionwithcharge = array(
					'amount' => $amount,
					'currency' => 'usd',
					'customer' => $app->user->customer_id,
					'description' => 'Canceled Tutoring Session With $'.$app->viewsession->cancellation_rate.' Charge',
					'receipt_email' => $app->viewsession->to_user
				);
				
				$session = array(
					'pending'=>NULL,
					'session_date'=>$app->viewsession->session_date,
					'session_cost'=>$amount,
					'session_length'=>NULL,
					'session_status'=>'canceled-session',
					'payrate'=>$payrate
				);
				
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
					$payment = array(
						'email'=>$app->viewsession->to_user,
						'type'=>'Canceled Tutoring Session',
						'amount'=>$amount,
						'date'=>thedate(),
						'charge_id'=>$chargeCard->id,
						'session_id'=>$app->viewsession->id,
						'recipient'=>$app->viewsession->from_user
					);
					
					$app->connect->insert('avid___user_payments',$payment);
					
					$app->connect->update('avid___sessions',$session,array('id'=>$app->viewsession->id,'to_user'=>$app->user->email));
					
					
					$subject = 'Session Canceled with $'.$app->viewsession->cancellation_rate.' Charge ';
					$message = '<p>'.short($app->user).' just canceled your tutoring session.</p>';
					$message.='<p><a href="/sessions/view/'.$app->viewsession->id.'">View Session Details</a></p>';
					
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
					
					$app->redirect('/sessions/view/'.$app->viewsession->id);
				}
				
			}
		}
		
	}