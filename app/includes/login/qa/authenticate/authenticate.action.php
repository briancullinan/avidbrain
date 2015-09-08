<?php
	
	$app->dualauthemail = $app->crypter->decrypt($app->getCookie('dualauth'));
	
	if(isset($app->dualauthemail) && !empty($app->dualauthemail)){
		
	}
	else{
		$app->redirect('/login');
	}