<?php
	$fixthedatabase = NULL;
	if(isset($fixthedatabase) && isset($app->user->usertype) && $app->user->usertype=='admin'){
		
		function extractusername($string){
			$username = explode('/',$string);
			$username = array_reverse($username);
			$username = $username[0];
			return $username;
		}
		
		$sql = "SELECT * FROM avid___user WHERE username IS NULL AND zipcode IS NOT NULL";
		$missingusername = $app->connect->executeQuery($sql)->fetchAll();
		
		foreach($missingusername as $user){
			$username = extractusername($user->url);
			$sql = "UPDATE avid___user SET username = '$username' WHERE username IS NULL AND email = '$user->email' ";
			$app->connect->executeQuery($sql);
		}
		$completeNext1 = true;
		
		if(isset($completeNext1)){
			
			$sql = "SELECT * FROM avid___user WHERE email IS NULL";
			$nousername = $app->connect->executeQuery($sql)->fetchAll();
			notify($nousername);
		}
		
		exit;
	}