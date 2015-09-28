<?php

	if(isset($app->paytutorsessioninfo)){
		
		//echo $app->dependents->stripe->STRIPE_SECRET; exit;
		
		$transferInfo = array(
			"amount" => $app->paytutorsessioninfo->amount,
			"currency" => "usd",
			"destination" => $app->paytutorsessioninfo->account_id,
			"description" => "Bi-Monthly Tutor Payment"
		);
			
		
		$notes = NULL;
		try{

			$transfer = \Stripe\Transfer::create($transferInfo);
		}
		catch(\Stripe\Error\Card $e) {
			notify($e);
		  // Since it's a decline, \Stripe\Error\Card will be caught
		  $body = $e->getJsonBody();
		  $err  = $body['error'];
		
		  print('Status is:' . $e->getHttpStatus() . "\n");
		  print('Type is:' . $err['type'] . "\n");
		  print('Code is:' . $err['code'] . "\n");
		  // param is '' in this case
		  print('Param is:' . $err['param'] . "\n");
		  print('Message is:' . $err['message'] . "\n");
		  exit;
		} catch (\Stripe\Error\RateLimit $e) {
		  // Too many requests made to the API too quickly
		  echo 'Too many requests made to the API too quickly';
		  exit;
		} catch (\Stripe\Error\InvalidRequest $e) {
		  // Invalid parameters were supplied to Stripe's API
			notify($e);
		  echo "Invalid parameters were supplied to Stripe's API";
		  exit;
		} catch (\Stripe\Error\Authentication $e) {
		  // Authentication with Stripe's API failed
		  // (maybe you changed API keys recently)
		  echo "Authentication with Stripe's API failed";
		  exit;
		} catch (\Stripe\Error\ApiConnection $e) {
		  // Network communication with Stripe failed
		  echo 'Network communication with Stripe failed';
		  exit;
		} catch (\Stripe\Error\Base $e) {
		  // Display a very generic error to the user, and maybe send
		  // yourself an email
		  echo 'Display a very generic error to the user, and maybe send';
		  exit;
		} catch (Exception $e) {
		  // Something else happened, completely unrelated to Stripe
		  echo 'Something else happened, completely unrelated to Stripe';
		  exit;
		}
		
		if(isset($app->paytutorsessioninfo->paybgcheck)){
			$notes = 'Paid Background Check';
			$paidbg = array(
				'email'=>$app->paytutorsessioninfo->email,
				'date'=>thedate(),
				'adminemail'=>$app->user->email
			);
			$app->connect->insert('avid___paid_bgchecks',$paidbg);
		}
		
		$payment = array(
			'email'=>$app->paytutorsessioninfo->email,
			'type'=>'Bi-Monthly Tutor Payment',
			'amount'=>$app->paytutorsessioninfo->amount,
			'date'=>thedate(),
			'charge_id'=>$transfer->id,
			'notes'=>$notes,
			'recipient'=>$app->paytutorsessioninfo->email,
			'paidout'=>1
		);
		
		$app->connect->insert('avid___user_payments',$payment);
		
		foreach($app->paytutorsessioninfo->sessionid as $key => $setaspaid){
			$app->connect->update('avid___sessions',array('paidout'=>1),array('id'=>$key,'from_user'=>$app->paytutorsessioninfo->email));	
		}
		
		$app->redirect('/admin-everything/pay-tutors');
		
	}



exit;