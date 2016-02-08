<?php



	if(isset($parent_slug)){
		$local = '/searching/'.$parent_slug;
	}
	else{
		$local = '/searching/';
	}

	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: ".$local, true, 301);
	exit;
