<?php
	if(isset($app->user->email) && $app->user->email==$app->currentuser->email){
		include('pages-my-subjects.edit.php');
	}
	else{
		include('pages-my-subjects.view.php');
	}
?>