<?php
	
	if(isset($username)){
		
		$cachedName = 'shortiecheck--'.$username;
		$checkusername = $app->connect->cache->get($cachedName);
		if($checkusername == null) {
			
			$sql = "SELECT username,url FROM avid___user WHERE username = :username";
			$prepare = array(':username'=>$username);
			$results = $app->connect->executeQuery($sql,$prepare)->fetch();
			
			if(isset($results->username) && isset($results->url)){
				$returnedData = $results->url;
			}
			else{
				$returnedData = '/tutors';
			}
		    
		    $checkusername = $returnedData;
		    $app->connect->cache->set($cachedName, $returnedData, 3600);
		}
		
		$app->redirect($checkusername);
		
		
	}