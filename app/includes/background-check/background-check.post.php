<?php
    if(isset($app->stripe)){
        $payment = array(
			'amount'=>'2999',
			'currency'=>'usd',
			'card'=>$app->stripe->stripeToken,
			'description'=>'Purchased Background Check',
			'receipt_email'=>$app->newtutor->email
		);

		// ERRORS
		try {

		 $chargeCard = \Stripe\Charge::create($payment);


		} catch(\Stripe\Error\Card $e) {
		  // Since it's a decline, \Stripe\Error\Card will be caught
		  $body = $e->getJsonBody();
		  $err  = $body['error'];

		  #print('Status is:' . $e->getHttpStatus() . "\n");
		  #print('Type is:' . $err['type'] . "\n");
		  #print('Code is:' . $err['code'] . "\n");
		  // param is '' in this case
		  //print('Param is:' . $err['param'] . "\n");
		  //print('Message is:' . $err['message'] . "\n");
		} catch (\Stripe\Error\RateLimit $e) {
		  // Too many requests made to the API too quickly
		} catch (\Stripe\Error\InvalidRequest $e) {
		  // Invalid parameters were supplied to Stripe's API
		} catch (\Stripe\Error\Authentication $e) {
		  // Authentication with Stripe's API failed
		  // (maybe you changed API keys recently)
		} catch (\Stripe\Error\ApiConnection $e) {
		  // Network communication with Stripe failed
		} catch (\Stripe\Error\Base $e) {
		  // Display a very generic error to the user, and maybe send
		  // yourself an email
		} catch (Exception $e) {
		  // Something else happened, completely unrelated to Stripe
		}

		$url = '/background-check/step6';

			if(isset($err['message'])){
				echo $err['message'].' Please <a href="'.$url.'">Refresh Page</a> and Try Again.';
				exit;
			}

		if(isset($chargeCard->id)){

			$step5 = array(
				'step5'=>'1',
				'charge_id'=>$chargeCard->id
			);

			$app->connect->update('avid___new_temps',$step5,array('email'=>$app->newtutor->email));

			$app->redirect($url);
		}
		else{
			echo 'Error';
			exit;
		}
    }
