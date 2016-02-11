<?php


	// Load Classes
	$classes = glob(APP_PATH.'/classes/*');
	foreach($classes as $classFile){
		include($classFile);
	}
	unset($classes);
