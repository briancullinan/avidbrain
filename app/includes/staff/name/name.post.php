<?php
	if(isset($app->messagingsystem)){
					
		$app->sendmessage->to_user = $app->staff->email;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $app->messagingsystem->subject;
		$app->sendmessage->message = $app->messagingsystem->message;
		if(isset($app->messagingsystem->extra)){
			$app->sendmessage->parent_id = $app->messagingsystem->extra;
		}
		$app->sendmessage->newmessage();
			
		$app->mailgun->to = $app->staff->email;
		$app->mailgun->subject = $app->messagingsystem->subject;
		$app->mailgun->message = $app->messagingsystem->message;
		$app->mailgun->send();
		
		new Flash(array('action'=>'kill-form','formID'=>'messagingsystem','message'=>'Message Sent'));
		
	}
