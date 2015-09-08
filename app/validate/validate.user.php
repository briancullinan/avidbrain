<?php
	
	if(isset($app->user->email) && empty($app->user->welcome) && $app->request->isPost()==false && $app->request->getPath()!='/logout' && $app->user->usertype!='admin'){
		
		redirect('/');
		
	}