<?php
	
	if($type=='whiteboard'){
		$app->target->include = $app->target->base.'whiteboard.php';
	}
	elseif($type=='questions-and-answers'){
		$app->target->include = $app->target->base.'questions-and-answers.php';
	}