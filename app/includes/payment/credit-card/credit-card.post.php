<?php

	if(isset($app->user->customer_id)){

		$checkcard = $app->user->creditcard();

		if(isset($app->stripe)){
			// No Card, but current user
			$customer = \Stripe\Customer::retrieve($app->user->customer_id);
			$customer->sources->create(array("card" => $app->stripe->stripeToken));
		}
		else{
			$cachedPayment = $app->connect->cache->getInfo($app->user->payment);
			if($cachedPayment!=NULL){
				$app->connect->cache->delete($app->user->payment);
			}

			if(isset($app->user) && isset($app->user->creditcardonfile)){
				$app->user->creditcard()->delete();
			}
		}

		$app->connect->delete('avid___crediterrors',array('email'=>$app->user->email,'clear'=>1));

		$app->redirect('/payment/credit-card');

	}
	elseif(isset($app->stripe)){

		if(isset($app->waitingtoemail->id)){

		    $subject = 'You have a message from a new student';
		    $message = '<p>A new student has signed up, from your profile.</p>';
		    $message.= '<p>Message From Student: '.$app->waitingtoemail->send_message.' </p>';

		    if(isset($app->waitingtoemail->getemails) && $app->waitingtoemail->getemails=='yes'){

		        $app->mailgun->to = $app->waitingtoemail->to_user;
		        $app->mailgun->subject = $subject;
		        $app->mailgun->message = $message;
		        $app->mailgun->send();

		    }

		    $app->sendmessage->to_user = $app->waitingtoemail->to_user;
		    $app->sendmessage->from_user = $app->waitingtoemail->from_user;
		    $app->sendmessage->location = 'inbox';
		    $app->sendmessage->send_date = thedate();
		    $app->sendmessage->subject = $subject;
		    $app->sendmessage->message = $message;
		    $app->sendmessage->newmessage();

			$app->connect->delete('avid___waiting_to_email',array('id'=>$app->waitingtoemail->id));

		}

		$usertype = strtoupper($app->user->usertype);

		$customer = \Stripe\Customer::create(array(
			"description" => "New $usertype: ".$app->user->email,
			"card" => $app->stripe->stripeToken,
			"email" => $app->user->email
		));

		$app->user->customer_id = $customer->id;
		$app->user->save();
		$app->redirect('/payment/credit-card');

	}
