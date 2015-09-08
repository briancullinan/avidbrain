<?php
	
	if(isset($app->managesubjects)){
		
		$update = array(
			'subject_name'=>$app->managesubjects->subject_name,
			'keywords'=>$app->managesubjects->keywords,
			'description'=>$app->managesubjects->description,
			'subject_slug'=>$app->managesubjects->subject_slug,
			//'parent_slug'=>$app->managesubjects->parent_slug
		);
		
		$app->connect->update('avid___available_subjects',$update,array('id'=>$app->managesubjects->id));
		
		$app->redirect('/admin-everything/manage-subjects/'.$category);
		
	}
	elseif(isset($app->addnewsubject)){
		
		//notify($app->addnewsubject);
		
		$app->addnewsubject->subject_slug = makeslug($app->dependents->ROMANIZE,$app->addnewsubject->subject_name);
		
		$insert = array(
			'subject_parent'=>$app->addnewsubject->subject_parent,
			'subject_name'=>$app->addnewsubject->subject_name,
			'description'=>$app->addnewsubject->description,
			'keywords'=>$app->addnewsubject->keywords,
			'subject_slug'=>$app->addnewsubject->subject_slug,
			'parent_slug'=>$app->addnewsubject->parent_slug
		);
		
		$app->connect->insert('avid___available_subjects',$insert);
		$app->redirect('/admin-everything/manage-subjects/'.$category);
		
		
	}
	elseif(isset($app->addcategory)){
		
		$app->addcategory->parent_slug = makeslug($app->dependents->ROMANIZE,$app->addcategory->name);
		
		$insertCat = array(
			'parent_slug'=>$app->addcategory->parent_slug,
			'subject_parent'=>$app->addcategory->name
		);
		
		$app->connect->insert('avid___available_subjects',$insertCat);
		
		$app->redirect('/admin-everything/manage-subjects/');
	}
	else{
		notify($app->keyname);
	}