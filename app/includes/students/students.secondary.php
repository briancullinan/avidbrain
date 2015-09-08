<?php
	if(isset($app->currentuser->url) && empty($app->currentuser->hidden) || isset($app->currentuser->thisisme)){
		include($app->target->secondaryNav);
	}
	else{
		include('secondary.search.php');
	}
?>