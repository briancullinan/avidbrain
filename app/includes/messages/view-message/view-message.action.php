<?php
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('messages.*, '.user_select().', '.profile_select().', '.account_settings().'')->from('avid___messages','messages');
	$data	=	$data->where('messages.id = :id AND messages.to_user = :email')->setParameter(':id',$id)->setParameter(':email',$app->user->email);
	$data	=	$data->leftJoin('messages','avid___user','user','messages.from_user = user.email');
	$data	=	$data->leftJoin('messages','avid___user_profile','profile','messages.from_user = profile.email');
	$data	=	$data->leftJoin('messages','avid___user_account_settings','settings','messages.from_user = settings.email');
	$data	=	$data->execute()->fetch();
	
	if(empty($data->id)){
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('messages.*, messages.to_user as from_user, '.user_select().', '.profile_select().', '.account_settings().'')->from('avid___messages','messages');
		$data	=	$data->where('messages.id = :id AND messages.from_user = :email')->setParameter(':id',$id)->setParameter(':email',$app->user->email);
		$data	=	$data->leftJoin('messages','avid___user','user','messages.to_user = user.email');
		$data	=	$data->leftJoin('messages','avid___user_profile','profile','messages.to_user = profile.email');
		$data	=	$data->leftJoin('messages','avid___user_account_settings','settings','messages.to_user = settings.email');
		$data	=	$data->execute()->fetch();
	}
	
	if(isset($data->id)){
		
		if(empty($data->status__read)){
			$app->connect->update('avid___messages',array('status__read'=>1),array('id'=>$id,'to_user'=>$app->user->email));
		}
		
		$app->viewmessage = $data;
		
	}
	else{
		$app->redirect('/messages');
	}
	
	if($data->to_user!=$app->user->email){
		
		$sql = "SELECT id FROM avid___messages WHERE location = :location AND from_user = :to_user AND id > :id ORDER BY id LIMIT 1";
		$prepeare = array(':to_user'=>$app->user->email,':id'=>$id,':location'=>'inbox');
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->id)){
			$app->viewmessage->next = $results->id;
		}
		
		$sql = "SELECT id FROM avid___messages WHERE location = :location AND from_user = :to_user AND id < :id ORDER BY id DESC LIMIT 1";
		$prepeare = array(':to_user'=>$app->user->email,':id'=>$id,':location'=>'inbox');
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->id)){
			$app->viewmessage->prev = $results->id;
		}
		
	}
	elseif($data->location=='inbox'){
		
		$sql = "SELECT id FROM avid___messages WHERE location = :location AND to_user = :to_user AND id > :id ORDER BY id LIMIT 1";
		$prepeare = array(':to_user'=>$app->user->email,':id'=>$id,':location'=>'inbox');
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->id)){
			$app->viewmessage->next = $results->id;
		}
		
		$sql = "SELECT id FROM avid___messages WHERE location = :location AND to_user = :to_user AND id < :id ORDER BY id DESC LIMIT 1";
		$prepeare = array(':to_user'=>$app->user->email,':id'=>$id,':location'=>'inbox');
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->id)){
			$app->viewmessage->prev = $results->id;
		}
	}
	elseif($data->location=='trash'){
		
		$sql = "SELECT id FROM avid___messages WHERE location = :location AND to_user = :to_user AND id > :id ORDER BY id LIMIT 1";
		$prepeare = array(':to_user'=>$app->user->email,':id'=>$id,':location'=>'trash');
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->id)){
			$app->viewmessage->next = $results->id;
		}
		
		$sql = "SELECT id FROM avid___messages WHERE location = :location AND to_user = :to_user AND id < :id ORDER BY id DESC LIMIT 1";
		$prepeare = array(':to_user'=>$app->user->email,':id'=>$id,':location'=>'trash');
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($results->id)){
			$app->viewmessage->prev = $results->id;
		}
		
	}
	
	
	$app->meta = new stdClass();
	$app->meta->title = 'View Message';
	
	
/*
	2698
	2693 **
	2692
*/