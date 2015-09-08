<?php
	
	// Check to see if the user has all ther Location Data Set
	if(isset($app->user->zipcode) && empty($app->user->city_slug)){
		
		$updatezip = get_zipcode_data($app->connect,$app->user->zipcode);
		if(isset($updatezip->id)){
			$app->user->city = $updatezip->city;
			$app->user->state = $updatezip->state;
			$app->user->state_long = $updatezip->state_long;
			$app->user->lat = $updatezip->lat;
			$app->user->long = $updatezip->long;
			$app->user->state_slug = $updatezip->state_slug;
			$app->user->city_slug = $updatezip->city_slug;
			$app->user->save();
		}
	}