<?php

	$app->user->creditcard();
	if(isset($app->user->creditcard) && $app->user->creditcard->funding=='prepaid'){
		$app->user->creditcard()->delete();
		$app->setCookie('prepaid','Prepaid Cards are Not Valid','2 Days');
		$app->redirect('/payment/credit-card');
	}
	
	
	if(isset($action) && $action=='deletecard'){
		$app->user->creditcard()->delete();
		$cachedPayment = $app->connect->cache->getInfo($app->user->payment);
		if($cachedPayment!=NULL){
			$app->connect->cache->delete($app->user->payment);
		}
		
		$app->connect->update('avid___crediterrors',array('clear'=>1),array('email'=>$app->user->email));
		
		$app->redirect('/payment/credit-card');
	}
	elseif(isset($action) && $action=='updatecard'){
		$app->updatecard = true;
	}