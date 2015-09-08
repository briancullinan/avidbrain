<?php
	$childen = array();
	if(isset($app->user->creditcardonfile)){
		$childen['compose'] = (object) array('name'=>'Compose','slug'=>'/messages/compose');
	}
	$childen['unread'] = (object) array('name'=>'Unread','slug'=>'/messages/unread');
	$childen['sent'] = (object) array('name'=>'Sent','slug'=>'/messages/sent');
	$childen['trash'] = (object) array('name'=>'Trash','slug'=>'/messages/trash');
	
	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/messages','text'=>'Messages');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondaryNav;