<?php

	if(isset($parent_slug)){
		$app->redirect('/searching/'.$parent_slug);
	}
	else{
		$app->redirect('/searching/');
	}
