<?php
	
	function extractusername($string){
		$username = explode('/',$string);
		$username = array_reverse($username);
		$username = $username[0];
		return $username;
	}
	
	// FIX USERS WITH NO URL
	
	$sql = "SELECT * FROM avid___user WHERE url IS NULL AND zipcode IS NOT NULL";
	$prepare = array();
	$missinurl = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	
	foreach($missinurl as $missing){
		$zipData = get_zipcode_data($app->connect,$missing->zipcode);
		$missing->username = unique_username($app->connect,1);
		$missing->url = update_zipcode($missing,$zipData);
		
		$sql = "UPDATE avid___user SET username = :username, url = :url WHERE email = :email";
		$prepare = array(
			':url'=>$missing->url,
			':username'=>$missing->username,
			':email'=>$missing->email
		);
		if($app->connect->executeQuery($sql,$prepare)){
			printer('FIXED NO URL');
		}
	}
	
	// FIX USERS WITH URL BUT NO USERNAME
	
	$sql = "SELECT * FROM avid___user WHERE username IS NULL AND url IS NOT NULL";
	$prepare = array();
	$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	foreach($results as $key=> $missingusername){
		
		$username = extractusername($missingusername->url);
		
		$sql = "UPDATE avid___user SET username = :username WHERE email = :email AND url = :url ";
		$prepare = array(
			':url'=>$missingusername->url,
			':username'=>$username,
			':email'=>$missingusername->email
		);
		if($app->connect->executeQuery($sql,$prepare)){
			printer('Fixed NO USERNAME');
		}
		
	}
?>