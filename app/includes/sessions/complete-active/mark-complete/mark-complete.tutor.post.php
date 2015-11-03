<?php

	if($app->markcomplete->to_user){

		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('promotions_active.*, promotions.email as shared_email, user.first_name, user.last_name, user.url')->from('avid___promotions_active','promotions_active');
		$data	=	$data->where('promotions_active.email = :email AND promotions_active.used IS NULL AND promotions_active.activated IS NOT NULL')->setParameter(':email',$app->markcomplete->to_user);
		$data	=	$data->leftJoin('promotions_active','avid___promotions','promotions','promotions_active.promocode = promotions.promocode');
		$data	=	$data->leftJoin('promotions_active','avid___user','user','user.email = promotions.email');
		$data	=	$data->setMaxResults(1);
		$data	=	$data->orderBy('value','DESC');
		$myrewards	=	$data->execute()->fetch();
	}

	if(isset($app->completesession)){

		if(isset($app->completesession->session_subject) && isset($app->markcomplete->session_subject) && $app->completesession->session_subject!=$app->markcomplete->session_subject){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'Tutoring Subject Already Set'));
		}

		if(isset($app->completesession->session_rate) && $app->completesession->session_rate< 30){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$30</span> Minimum Session Limit'));
		}

		if(isset($app->completesession->session_rate) && $app->completesession->session_rate>500){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$500</span> Maximum Session Limit'));
		}
		if(session_cost($app->completesession,1)<30){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$30</span> Minimum Session Limit'));
		}

		if(session_cost($app->completesession,1) > 1000){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span>$1,000</span> Maximum Session Limit'));
		}



		if(isset($app->markcomplete->session_status) && isset($app->completesession->secret)){
			new Flash(array('action'=>'required','formID'=>'setupsession','message'=>'<span><i class="fa fa-warning"></i></span> Account Already Charged '));
		}
		elseif(isset($app->completesession->secret)){

			if(isset($myrewards->id)){

				//notify($myrewards);

				$sql = "UPDATE avid___promotions_active SET activated = 1 WHERE  sharedwith = :sharedwith AND promocode = :promocode AND activated IS NULL LIMIT 1";
				$prepare = array(
					':promocode'=>$myrewards->promocode,
					':sharedwith'=>$app->markcomplete->to_user
				);
				$app->connect->executeQuery($sql,$prepare);

			}

			if(crediterror($app->connect,$app->markcomplete->to_user)==true){
				new Flash(
					array(
						'action'=>'alert',
						'message'=>'Invalid Credit Card'
					)
				);
			}

			$payrate = calculate_payrate($app->connect,$app->markcomplete,$app->user);

			$creditcard = get_creditcard($app->markcomplete->customer_id);
			if($creditcard==NULL){

				$html = '<p class="confirm-payment-box orange white-text"> '.short($app->markcomplete).' has no credit card on file, before you can charge this session they need to add one. </p>';
				$html.= '<p><a class="btn btn-block" href="'.$app->markcomplete->url.'/send-message" target="_blank">Send Message</a></p>';
				new Flash(
					array('action'=>'confirm-payment','html'=>$html,'message'=>'Please Confirm','secret'=>random_all(12))
				);

			}

			$amount = (session_cost($app->completesession,1)*100);
			$amount = stripe_transaction($amount);

			//notify($amount);

			if(isset($myrewards->value)){
				$value = ($myrewards->value*100);
				$amountAfterDiscount = ($amount-$value);
				if($amountAfterDiscount<=0){
					$amountAfterDiscount = 0;
				}
			}
			else{
				$amountAfterDiscount = $amount;
			}

			$amount = $amountAfterDiscount;

			//notify($amountAfterDiscount);

			$payment = array(
				'amount' => $amount,
				'currency' => 'usd',
				'customer' => $app->markcomplete->customer_id,
				'description' => 'Tutoring Session',
				'receipt_email' => $app->markcomplete->to_user
			);


			// Update Session
			$session = array(
				'pending'=>NULL,
				'session_date'=>$app->completesession->session_date,
				'session_cost'=>$amount,
				'session_length'=>$app->completesession->session_length,
				'session_status'=>'complete',
				'payrate'=>$payrate,
				'taxes'=>1,
				'payment_details'=>NULL
			);

			if(isset($amountAfterDiscount) && $amountAfterDiscount>0){
				try{
					$chargeCard = \Stripe\Charge::create($payment);
				}
				catch(\Stripe\Error\Card $e){
					$stripeErrors = handleStripe($e);
					if(isset($stripeErrors->message)){
						$errorMessage = str_replace('Your card','The card',$stripeErrors->message);
						$stripeErrors->message = $errorMessage;
					}
					$insert = array(
						'status'=>$stripeErrors->status,
						'type'=>$stripeErrors->type,
						'code'=>$stripeErrors->code,
						'message'=>$stripeErrors->message,
						'email'=>$app->markcomplete->to_user,
						'date'=>thedate(),
						'session_id'=>$id
					);

					// Email Student

					$subject = 'Your credit card was declined';
					$message = '<p>Please verify that your credit card is active, so your tutor can charge your for your last tutoring session.</p>';
					$message.= '<p><a href="/payment/credit-card" class="btn btn-s red white-text">Update Payment Info</a></p>';

					if(isset($app->setupsession->getemails) && $app->markcomplete->getemails=='yes'){

						$app->mailgun->to = $app->markcomplete->to_user;
						$app->mailgun->subject = $subject;
						$app->mailgun->message = $message;
						$app->mailgun->send();

					}

					$app->sendmessage->to_user = $app->markcomplete->to_user;
					$app->sendmessage->from_user = $app->user->email;
					$app->sendmessage->location = 'inbox';
					$app->sendmessage->send_date = thedate();
					$app->sendmessage->subject = $subject;
					$app->sendmessage->message = $message;
					$app->sendmessage->newmessage();

					$updateSession = array(
						'payment_details'=>'Credit Card Error',
						'pending'=>NULL
					);
					$app->connect->update('avid___sessions',$updateSession,array('id'=>$app->markcomplete->id,'from_user'=>$app->user->email));

					$app->connect->insert('avid___crediterrors',$insert);

					new Flash(
						array(
							'action'=>'jump-to',
							'message'=>$errorMessage,
							'location'=>'/sessions/broken-sessions'
						)
					);
				}
			}
			else{
				$chargeCard = new stdClass();
				$chargeCard->id = NULL;
			}


			//
				// Update Session
				$app->connect->update('avid___sessions',$session,array('id'=>$app->markcomplete->id,'from_user'=>$app->user->email));

				// Remove Promo
				if(isset($myrewards->id)){
					$app->connect->update('avid___promotions_active',array('used'=>1),array('id'=>$myrewards->id));
				}

				// Add Payment
				$payment = array(
					'email'=>$app->markcomplete->to_user,
					'type'=>'Tutoring Session',
					'amount'=>$amount,
					'date'=>thedate(),
					'session_id'=>$app->markcomplete->id,
					'recipient'=>$app->user->email
				);

				if(isset($chargeCard->id)){
					$payment['charge_id'] = $chargeCard->id;
				}
				if(isset($myrewards->id)){
					$payment['discount'] = $myrewards->id;
				}

				$app->connect->insert('avid___user_payments',$payment);

				$subject = 'Session Charged';
				$message = '<p>'.short($app->user).' just charged your for your '.$app->markcomplete->session_subject.' tutoring session.</p>';
				$message.='<p><a href="/sessions/view/'.$app->markcomplete->id.'">View Session Details</a></p>';
				$message.='<p>You must be logged into to view session information.</p>';
				//$message.='<p><a class="btn" href="/sessions/view/'.$id.'">View Session Details</a></p>';

				$app->mailgun->to = $app->markcomplete->to_user;
				$app->mailgun->subject = $subject;
				$app->mailgun->message = $message;
				$app->mailgun->send();

				$app->sendmessage->to_user = $app->markcomplete->to_user;
				$app->sendmessage->from_user = $app->user->email;
				$app->sendmessage->location = 'inbox';
				$app->sendmessage->send_date = thedate();
				$app->sendmessage->subject = $subject;
				$app->sendmessage->message = $message;
				$app->sendmessage->newmessage();


				new Flash(array('action'=>'jump-to','location'=>'/sessions/view/'.$app->markcomplete->id,'formID'=>'completesession','message'=>'Credit Card Charged <i class="fa fa-heart"></i>'));

		}
		else{

			if(empty($app->markcomplete->customer_id)){
				$html = '<p class="confirm-payment-box orange white-text"> '.short($app->markcomplete).' has no credit card on file, before you can charge this session they need to add one. </p>';
				$html.= '<p><a class="btn btn-block" href="'.$app->markcomplete->url.'/send-message" target="_blank">Send Message</a></p>';
				new Flash(
					array('action'=>'confirm-payment','html'=>$html,'message'=>'Please Confirm','secret'=>random_all(12))
				);
			}
			else{

				#$cost = (session_cost($app->completesession)*100);
				#$cost = stripe_transaction($cost);
				#$cost = numbers(($cost/100));
				$cost = session_cost($app->completesession);

				$html = '<p class="confirm-payment-box orange white-text"> You are about to charge '.short($app->markcomplete).' <strong>$'.$cost.'</strong>, please confirm below. </p>';
				$html.='<div><button id="confirm-charge" class="btn btn-block btn-l btn-notice greenbutton"> <i class="fa fa-check"></i> Confirm Charge</button></div>';
				$html.='<div><a id="cancel-charge" href="/sessions/setup/'.$id.'" class="btn btn-block red"> <i class="fa fa-times"></i> Cancel Charge</button></div>';
				new Flash(
					array('action'=>'confirm-payment','html'=>$html,'message'=>'<i class="fa fa-chevron-left"></i> Please confirm charge','secret'=>random_all(12))
				);
			}
		}

	}
