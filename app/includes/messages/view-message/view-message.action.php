<?php

	$sql = "
		SELECT
			messages.id,
			messages.from_user,
			messages.to_user,
			CASE
			    WHEN messages.from_user = :myemail then messages.from_user
			    WHEN messages.to_user = :myemail then messages.to_user
			END as email,

			CASE
			    WHEN messages.from_user != :myemail then messages.from_user
			    WHEN messages.to_user != :myemail then messages.to_user
			END as messageuser,

			CASE
			    WHEN messages.from_user = :myemail then 'from_user'
			    WHEN messages.to_user = :myemail then 'to_user'
			END as type,
			messages.*
		FROM
			avid___messages messages
		WHERE
			messages.id = :id
				AND
			messages.from_user = :myemail
				OR
			messages.id = :id
				AND
			messages.to_user = :myemail
	";
	$prepare = array(
		':id'=>$id,
		':myemail'=>$app->user->email
	);
	$message = $app->connect->executeQuery($sql,$prepare)->fetch();
	//notify($message);


	if(isset($message->id)){
		$app->message = $message;

		if(empty($data->status__read)){
			$app->connect->update('avid___messages',array('status__read'=>1),array('id'=>$id,'to_user'=>$app->user->email));
		}

		$prevnext = (object)[];

		$sql = "
			SELECT
				messages.id as next
			FROM
				avid___messages messages
			WHERE
				messages.id > :id
					AND
				messages.$message->type = :myemail
			ORDER BY messages.id LIMIT 1
		";

		$prepare = array(
			':id'=>$id,
			':myemail'=>$app->user->email
		);
		if(!empty($next = $app->connect->executeQuery($sql,$prepare)->fetch())){
			$prevnext->next = $next->next;
		}

		$sql = "
			SELECT
				messages.id as prev
			FROM
				avid___messages messages
			WHERE
				messages.id < :id
					AND
				messages.$message->type = :myemail
			ORDER BY messages.id DESC LIMIT 1
		";

		$prepare = array(
			':id'=>$id,
			':myemail'=>$app->user->email
		);
		if(!empty($prev = $app->connect->executeQuery($sql,$prepare)->fetch())){
			$prevnext->prev = $prev->prev;
		}

		$app->message->prevnext = $prevnext;

		$app->message->user = getmessageuserinfo($app->connect,$app->message->messageuser,$app->user);
		if(empty($app->message->user)){
			$app->message->user = getmessageuserinfo($app->connect,'support@avidbrain.com',$app->user);
		}
		//notify($app->message->user);
		//notify($app->message);
		// echo $messageuser->name;
		// echo $messageuser->url;
		// echo $messageuser->image;


	}


	function getmessageuserinfo($connect,$email,$user){
		$parent_company_email = parent_company_email($email);
		if($parent_company_email==true){
			$sql = "
				SELECT
					CONCAT(admins.first_name,' ',admins.last_name) as name,
					admins.url,
					admins.my_avatar as image,
					admins.email
				FROM
					avid___admins admins
				WHERE
					admins.email = :email
			";
		}
		else{

			$sql = "
				SELECT
					user.email,
					user.first_name,
					user.last_name,
					user.url,
					profile.my_avatar,
					profile.my_avatar_status,
					profile.my_upload,
					profile.my_upload_status
				FROM
					avid___user user
				INNER JOIN
					avid___user_profile profile on profile.email = user.email
				WHERE
					user.email = :email
			";

		}
		$prepare = array(
			':email'=>$email
		);
		$results = $connect->executeQuery($sql,$prepare)->fetch();

		if(isset($results->first_name)){
			$results->image = userphotographs($user,$email);
	        $results->name = short($results);
		}

		return $results;
	}
