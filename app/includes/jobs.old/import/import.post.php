<?php
	
	if(isset($app->importstatus)){
		
		if($app->importstatus->status=='delete'){
			
			$delete = array(
				'email'=>$app->user->email,
				'id'=>$app->importstatus->id
			);
			
			$app->connect->delete('avid___user_subjects',$delete);
			
			new Flash(array('action'=>'jump-to','location'=>'/jobs/import','message'=>'Post Deleted'));
			
		}
		else{
			
			$sql = "SELECT * FROM avid___user_subjects WHERE id = :id";
			$prepare = array(':id'=>$app->importstatus->id);
			$results = $app->connect->executeQuery($sql,$prepare)->rowCount();
			if($results!=1){
				new Flash(array('action'=>'required','message'=>'Post Already Imported'));
			}
			
			
			if(empty($app->importstatus->description)){
				new Flash(array('action'=>'required','message'=>'Description Required'));
			}
			
			$insert = array(
				'email'=>$app->user->email,
				'subject_name'=>$app->importstatus->subject_name,
				'subject_slug'=>$app->importstatus->subject_slug,
				'parent_slug'=>$app->importstatus->parent_slug,
				'subject_id'=>$app->importstatus->subject_id,
				'date'=>$app->importstatus->last_modified,
				'job_description'=>$app->importstatus->description,
				'type'=>NULL,
				'skill_level'=>NULL,
				'open'=>1,
				'applicants'=>NULL
			);
			
			$delete = array(
				'email'=>$app->user->email,
				'id'=>$app->importstatus->id
			);
			
			$app->connect->insert('avid___jobs',$insert);
			$app->connect->delete('avid___user_subjects',$delete);
			
			new Flash(array('action'=>'jump-to','location'=>'/jobs/import','message'=>'Post Imported'));
			
			
		}
		
	}
	
