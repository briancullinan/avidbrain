<?php

	$url = '';
	if(isset($state) && isset($city) && isset($username)){
		$url = "/tutors/$state/$city/$username";
	}


	$app->target->css = str_replace('main','view-user---',$app->target->css);
	$app->secondary = false;
	//notify($app->target);

	$sql = "
		SELECT
			user.id,
			user.email,
			user.usertype,
			user.last_active,
			user.city,
			user.state,
			user.state_long,
			user.state_slug,
			user.zipcode,
			user.first_name,
			user.last_name,
			user.url,
			user.username,
			user.signup_date,

			profile.hourly_rate,
            profile.my_avatar,
            profile.my_avatar_status,
            profile.my_upload,
            profile.my_upload_status,
            profile.short_description_verified,
            profile.personal_statement_verified
		FROM
			avid___user user

		INNER JOIN avid___user_profile profile on profile.email = user.email

		WHERE
			user.url = :url
	";
	$prepare = array(
		':url'=>$url
	);
	$actualuser = $app->connect->executeQuery($sql,$prepare)->fetch();
	if(isset($actualuser->id)){
		$app->actualuser = $actualuser;
	}
