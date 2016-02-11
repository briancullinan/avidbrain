<?php
	notify(SITENAME_PROPPER);
	$subject = str_replace('-tutors','',$subject);
	
	$app->meta = new stdClass();
	$app->meta->title = 'exampletitle';
	$app->meta->h1 = $city.' '.$state.' '.$subject.' Tutors';
	#$app->meta->keywords = 'examplekeys';
	#$app->meta->description = 'exampledescribers';
