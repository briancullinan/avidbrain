<?php
	
	if(isset($step)){
		$includestep = $app->target->base.'tutor-walkthrough/step-'.$step.'.php';
	}
	else{
		$includestep = $app->target->base.'tutor-walkthrough/step-0.php';
	}
	
	if(file_exists($includestep)){
		include($includestep);
	}
?>