<?php
	
	if(isset($app->trashcan->status) && $app->trashcan->status=='empty-trash'){
		
		$sql = "UPDATE avid___messages SET location = :trashed WHERE to_user = :to_user AND location = :location";
		$prepare = array(
			':trashed'=>'trashed',
			':to_user'=>$app->user->email,
			':location'=>'trash'
		);
		$allgone = $app->connect->executeQuery($sql,$prepare);
		
		$app->redirect('/messages/trash');
		
	}
