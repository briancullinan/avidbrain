<?php
	if(isset($app->contactus)){
		
		$contactus = array(
			'name'=>$app->contactus->name,
			'email'=>$app->contactus->email,
			'message'=>$app->contactus->message,
			'date'=>thedate()
		);
		
		if(isset($app->user->email)){
			$contactus['activeuser'] = 1;
		}
		
		$app->connect->insert('avid___help_contactus',$contactus);
		
		new Flash(
			array(
				'action'=>'kill-form',
				'message'=>'Message Sent <i class="fa fa-heart"></i>',
				'formID'=>'contactus'
			)
		);
		
		
	}
