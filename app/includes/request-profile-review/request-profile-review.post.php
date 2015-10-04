<?php

	if(isset($app->requestprofilereview) && $app->requestprofilereview->status=='reviewmyprofile' && $app->user->usertype=='tutor'){
		
		if(empty($app->requestprofilereview->type)){
			$app->requestprofilereview->type = 'Not Set';
		}
		
		$needsreview = array(
			'email'=>$app->user->email,
			'date'=>thedate(),
			'url'=>$app->user->url,
			'usertype'=>$app->user->usertype,
			'type'=>$app->requestprofilereview->type
		);
		
		$app->mailgun->to = 'david'.$app->dependents->mailgun->EMAIL_DOMAIN;
		$app->mailgun->subject = 'Someone needs their profile reviewed';
		$app->mailgun->message = "Please review this user: ".$app->dependents->DOMAIN.$app->user->url." <br> Reason:  ".$app->requestprofilereview->type;
		$app->mailgun->send();
		
		$app->user->lock = 1;
		$app->user->hidden = 1;
		$app->user->status = 'needs-review';
		$app->user->sessiontoken = NULL;
		$app->user->save();
		
		
		$delete = $app->connect->delete('avid___user_needsprofilereview', array('email' => $app->user->email));
		
		$insert = $app->connect->insert('avid___user_needsprofilereview',$needsreview);
		
		$app->redirect('/logout');
		
	}
	elseif(isset($app->requestprofilereview) && $app->user->usertype=='student' && $app->requestprofilereview->type=='My Photo'){
		
		notify('Please Review My Photo');
		
	}