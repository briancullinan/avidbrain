<?php



	if(isset($parent_slug)){
		$local = '/searching/'.$parent_slug;
	}
	else{
		$local = '/searching/';
	}


	header("Location: ".$local, true, 301);
	exit;
