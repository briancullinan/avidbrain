<?php
	
	
	// Load Classes
	$classes = glob($app->dependents->APP_PATH.'classes/*');
	foreach($classes as $classFile){
		include($classFile);
	}
	unset($classes);