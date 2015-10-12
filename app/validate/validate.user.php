<?php

	if(isset($app->user->email) && empty($app->user->welcome) && $app->request->isPost()==false && $app->request->getPath()!='/logout' && $app->user->usertype!='admin'){

		redirect('/');

	}

	if(isset($app->user->usertype) && $app->user->usertype=='admin'){

		$tutornode = password_verify('tutornode',$app->user->password);
		if($tutornode==true && $app->request->getPath()!='/admin-everything/edit-profile'){
			//$app->redirect('/admin-everything/edit-profile');
			redirect('/admin-everything/edit-profile');

		}


	}
