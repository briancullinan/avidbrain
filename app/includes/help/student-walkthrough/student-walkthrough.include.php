<?php
	
	if(isset($step)){
		$includestep = $app->target->base.'student-walkthrough/step-'.$step.'.php';
	}
	else{
		$includestep = $app->target->base.'student-walkthrough/step-0.php';
	}
	
	if(file_exists($includestep)){
		include($includestep);
	}
?>