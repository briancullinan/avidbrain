<?php
	
	if(isset($app->user->usertype) && isset($pagename) && isset($category) && $pagename=='my-photos'){
		
		$pagetype = explode('/',$app->request->getResourceUri());
		$pagetype = $pagetype[1];
		$usertype = $pagetype;
		$pagetype = substr_replace($pagetype, "", -1);
		
		$allowedCategories = array('crop-photo','delete-photo','rotate-right','rotate-left');
		
		if(isset($app->user->usertype) && $app->user->usertype=='admin'){
			$allowedCategories[] = 'approvephoto';
			$allowedCategories[] = 'disapprovephoto';
		}
		
		if(!in_array($category, $allowedCategories)){
			$app->redirect('/'.$usertype);
		}
		else{
			include($app->target->action);
			$fixedInclude = '.'.$category.'.include.';
			$fixedAction = '.'.$category.'.action.';
			$fixedPost = '.'.$category.'.post.';
			
			$app->target->include = str_replace(array('.include.','/'.$usertype.'/','/view-'.$pagetype.'/view-'.$pagetype.'.'),array($fixedInclude,'/shared-pages/','/'),$app->target->include);
			$app->target->action = str_replace(array('.action.','/'.$usertype.'/','/view-'.$pagetype.'/view-'.$pagetype.'.'),array($fixedAction,'/shared-pages/','/'),$app->target->action);
			$app->target->post = str_replace(array('.post.','/'.$usertype.'/','/view-'.$pagetype.'/view-'.$pagetype.'.'),array($fixedPost,'/shared-pages/','/'),$app->target->post);
			
		}
	}
	
	#$app->secondary = $app->target->secondary;
	
	//$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/students','text'=>'Students');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondary;