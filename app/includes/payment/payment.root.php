<?php
	
	function ccbrand($type){
		$type = str_replace(' ','',strtolower($type));
		if($type=='americanexpress'){
			return 'cc-amex';
		}
		elseif($type=='dinersclub' || $type=='jcb'){
			return 'credit-card';
		}
		return 'cc-'.$type;
	}
	
	
	$childen = array();
	$childen['/payment/history'] = (object) array('name'=>'Payment History','slug'=>'/payment/history');
	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		$childen['/payment/credit-card'] = (object) array('name'=>'Add/Edit Credit Card','slug'=>'/payment/credit-card');
	}
	
	if($app->user->usertype=='tutor'){
		$childen['/payment/get-paid'] = (object) array('name'=>'Get Paid','slug'=>'/payment/get-paid');
	}
	
	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/payment','text'=>'Payment');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondaryNav;