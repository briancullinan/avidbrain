<?php

	if(isset($app->refundme) && empty($app->viewsession->viewsession->refund_amount)){

		if(!empty($app->viewsession->refund_amount)){
			new Flash(array('action'=>'required','formID'=>'refund','message'=>"Refund Already Sent"));
		}

		if($app->refundme->amount<1 || $app->refundme->amount > ($app->viewsession->session_cost/100)){
			new Flash(array('action'=>'required','formID'=>'refund','message'=>"Invalid Amount"));
		}
		elseif(empty($app->refundme->dispute_response)){
			new Flash(array('action'=>'required','formID'=>'refund','message'=>"Please write a response"));
		}

		if($app->refundme->amount == ($app->viewsession->session_cost/100)){
			$fullrefund = true;
		}

		$refund = array(
			'refund_amount'=>($app->refundme->amount*100),
			'dispute_response'=>$app->refundme->dispute_response
		);

		$sql = "SELECT * FROM avid___user_payments WHERE recipient = :email and session_id = :id";
		$prepeare = array(':email'=>$app->user->email,':id'=>$id);
		$charge_id = $app->connect->executeQuery($sql,$prepeare)->fetch();

		if(isset($charge_id->charge_id)){

			try{
				$charge = \Stripe\Charge::retrieve($charge_id->charge_id);
				$refundstripe = $charge->refunds->create(array(
					'amount'=>($app->refundme->amount*100),
					'reason'=>'requested_by_customer'
				));
			}
			catch(\Stripe\Error\Card $e){
				$stripeErrors = handleStripe($e);
				$insert = array(
					'status'=>$stripeErrors->status,
					'type'=>$stripeErrors->type,
					'code'=>$stripeErrors->code,
					'message'=>$stripeErrors->message,
					'email'=>$app->user->email,
					'date'=>thedate(),
					'session_id'=>$app->viewsession->id
				);
				$app->connect->insert('avid___crediterrors',$insert);
				new Flash(
					array(
						'action'=>'alert',
						'message'=>$stripeErrors->message
					)
				);
			}

		}

		if(isset($charge->id)){
			$newrefund = array(
				'email'=>$app->user->email,
				'type'=>'Tutoring Session Refund',
				'amount'=>($app->refundme->amount*100),
				'date'=>thedate(),
				'charge_id'=>$refundstripe->id,
				'session_id'=>$id,
				'recipient'=>$app->viewsession->to_user
			);

			$subject = 'Session Refunded';
			$message = '<p>'.short($app->user).' has refunded you $'.$app->refundme->amount.' from your last tutoring session.</p>';
			$message.='<p><a href="'.DOMAIN.'/sessions/view/'.$id.'">View Session</a></p>';

			if(isset($app->viewsession->getemails) && $app->viewsession->getemails=='yes'){

				$app->mailgun->to = $app->viewsession->to_user;
				$app->mailgun->subject = $subject;
				$app->mailgun->message = $message;
				$app->mailgun->send();

			}

			$app->sendmessage->to_user = $app->viewsession->to_user;
			$app->sendmessage->from_user = $app->user->email;
			$app->sendmessage->location = 'inbox';
			$app->sendmessage->send_date = thedate();
			$app->sendmessage->subject = $subject;
			$app->sendmessage->message = $message;
			$app->sendmessage->newmessage();

			$app->connect->update('avid___sessions',$refund,array('from_user'=>$app->user->email,'id'=>$id));
			$app->connect->insert('avid___user_payments',$newrefund);

			new Flash(
				array('action'=>'jump-to','message'=>'Refund Sent','location'=>'/sessions/view/'.$id)
			);
		}



	}
	elseif(isset($app->contactus)){

		$contest = array(
			'contest_dispute'=>1,
			'contest_dispute_text'=>$app->contactus->message
		);

		$message = '<p>'. $app->contactus->message.'</p>';
		$message.='<p><a href="'.DOMAIN.'/sessions/view/'.$id.'">View Session</a></p>';

		$app->mailgun->to = 'support@mindspree.com';
		$app->mailgun->subject = 'Contest Dispute';
		$app->mailgun->message = $message;
		$app->mailgun->send();


		$app->connect->update('avid___sessions',$contest,array('from_user'=>$app->user->email,'id'=>$id));

		new Flash(
			array('action'=>'jump-to','message'=>'Messes Sent To Support','location'=>'/sessions/view/'.$id)
		);


	}
	else{
		notify(SITENAME_PROPPER);
	}
