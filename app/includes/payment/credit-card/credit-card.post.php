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
