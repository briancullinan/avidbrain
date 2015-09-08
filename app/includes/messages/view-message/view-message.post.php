<?php

	if(isset($app->inboxaction->value)){
		
		
		if($app->inboxaction->value=='delete'){
			
			$app->connect->update('avid___messages',array('location'=>'trash'),array('to_user'=>$app->user->email,'id'=>$id));
			
			new Flash(
				array('action'=>'jump-to','location'=>'/messages/view-message/'.$id,'message'=>'<i class="fa fa-trash"></i> Message Sent To Trash')
			);
			
		}
		elseif($app->inboxaction->value=='un-delete'){
			
			$app->connect->update('avid___messages',array('location'=>'inbox'),array('to_user'=>$app->user->email,'id'=>$id));
			
			new Flash(
				array('action'=>'jump-to','location'=>'/messages/view-message/'.$id,'message'=>'<i class="fa fa-trash"></i> Message Sent To Inbox')
			);
			
		}
		elseif($app->inboxaction->value=='markunread'){
			
			$app->connect->update('avid___messages',array('status__read'=>NULL),array('to_user'=>$app->user->email,'id'=>$id));
			
			new Flash(
				array('action'=>'alert','message'=>'<i class="fa fa-star"></i> Message Marked Un-Read')
			);
			
		}
		elseif($app->inboxaction->value=='flag'){
			
			$app->connect->update('avid___messages',array('status__flagged'=>1),array('to_user'=>$app->user->email,'id'=>$id));
			
			new Flash(
				array('action'=>'jump-to','location'=>'/messages/view-message/'.$id,'message'=>'<i class="fa fa-flag"></i> Message Flagged')
			);
			
		}
		elseif($app->inboxaction->value=='un-flag'){
			
			$app->connect->update('avid___messages',array('status__flagged'=>NULL),array('to_user'=>$app->user->email,'id'=>$id));
			
			new Flash(
				array('action'=>'jump-to','location'=>'/messages/view-message/'.$id,'message'=>'<i class="fa fa-flag"></i> Message Un-Flagged')
			);
			
		}
		elseif($app->inboxaction->value=='star'){
			$app->connect->update('avid___messages',array('status__starred'=>1),array('to_user'=>$app->user->email,'id'=>$id));
			
			new Flash(
				array('action'=>'jump-to','location'=>'/messages/view-message/'.$id,'message'=>'<i class="fa fa-flag"></i> Message Starred')
			);
			
		}
		elseif($app->inboxaction->value=='un-star'){
			$app->connect->update('avid___messages',array('status__starred'=>NULL),array('to_user'=>$app->user->email,'id'=>$id));
			
			new Flash(
				array('action'=>'jump-to','location'=>'/messages/view-message/'.$id,'message'=>'<i class="fa fa-flag"></i> Message Un-Starred')
			);
		}
		else{
			notify($app->inboxaction->value);
		}
		
	}