<?php
	// Empty
	if(!empty($app->postanewjob)){

		$sql = "SELECT * FROM avid___jobs WHERE jobid = :jobid";
		$prepare = array(':jobid'=>$app->postanewjob->jobid);
		$haveiposted = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($haveiposted->id)){
			new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Double Post'));
		}


		if(empty($app->postanewjob->subject)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Subject Required'));
        }
        elseif(empty($app->postanewjob->why)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Explain why you need tutored'));
        }

		$app->postanewjob->subject_name = $app->postanewjob->subject;
        $app->postanewjob->job_description = $app->postanewjob->why;

		if(empty($app->postanewjob->subject_slug)){
			$app->postanewjob->subject_slug = NULL;
		}
		if(empty($app->postanewjob->parent_slug)){
			$app->postanewjob->parent_slug = NULL;
		}
		if(empty($app->postanewjob->subject_id)){
			$app->postanewjob->subject_id = NULL;
		}

		$newjob = array(
            'email'=>$app->user->email,
            'subject_name'=>$app->postanewjob->subject_name,
            'subject_slug'=>$app->postanewjob->subject_slug,
            'parent_slug'=>$app->postanewjob->parent_slug,
            'subject_id'=>$app->postanewjob->id,
            'date'=>thedate(),
            'job_description'=>$app->postanewjob->job_description,
            'type'=>$app->postanewjob->type,
            'skill_level'=>$app->postanewjob->skill_level,
            'open'=>1,
            'price_range_low'=>$app->postanewjob->price_range_low,
            'price_range_high'=>$app->postanewjob->price_range_high,
            'anonymous'=>NULL,
            'notes'=>NULL,
			'jobid'=>$app->postanewjob->jobid
        );

		$app->connect->insert('avid___jobs',$newjob);
        $lastid = $app->connect->lastInsertId();

        new Flash(array('action'=>'jump-to','location'=>'/jobs/completepost/'.$lastid,'formID'=>'setupsession','message'=>'Job Added'));

	}
