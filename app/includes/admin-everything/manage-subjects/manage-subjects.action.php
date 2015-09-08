<?php
	$sql = "SELECT subject_parent,parent_slug FROM avid___available_subjects GROUP BY subject_parent ORDER BY subject_parent ASC";
	$prepare = array();
	$categories = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	$app->categories = $categories;

	if(isset($action)){
		
		$delete = explode('delete--',$action);
		if(isset($delete[1])){
			$deleteme = $delete[1];
			
			$app->connect->delete('avid___available_subjects',array('id'=>$deleteme));
			
			$app->redirect('/admin-everything/manage-subjects/'.$category);
			
		}
	}
	
	if(isset($category)){
		$sql = "SELECT * FROM avid___available_subjects WHERE parent_slug = :category ORDER BY id DESC";
		$prepare = array(':category'=>$category);
		$subjects = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		if(isset($subjects[0])){
			$app->subjects = $subjects;
		}
		
	}
	