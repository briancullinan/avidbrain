<?php
	
	//location
	//action
	//number
	
	//notify($location);
	
	$redirect = NULL;
	
	if($location=='tutorssearch'){
		$redirect = '/tutors';
	}
	elseif($location=='studentsearch'){
		$redirect = '/students';
	}
	elseif(strpos($location, '---') !== false){
		$location = explode('---',$location);
		$redirect='';
		foreach($location as $slug){
			$redirect.='/'.$slug;
		}
	}
	else{
		//notify($location);
	}
	
	if(isset($number)){
		$redirect = $redirect.'/page/'.$number;
	}
	
	$app->setCookie('filterby',$action, '2 days');
	
	$app->redirect($redirect);