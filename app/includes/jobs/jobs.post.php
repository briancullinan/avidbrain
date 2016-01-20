<?php
	// Empty
	if(!empty($app->postanewjob)){



		if(empty($app->postanewjob->subject)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Subject Required'));
        }
        elseif(empty($app->postanewjob->why)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Explain why you need tutored'));
        }

		$app->postanewjob->subject_name = $app->postanewjob->subject;
        $app->postanewjob->job_description = $app->postanewjob->why;

		$newjob = array(
            'email'=>$app->user->email,
            'subject_name'=>$app->postanewjob->subject_name,
            'subject_slug'=>$app->postanewjob->subject_slug,
            'parent_slug'=>$app->postanewjob->parent_slug,
            'subject_id'=>$app->postanewjob->id,
            'date'=>thedate(),
            'job_description'=>$app->postanewjob->job_description,
            'type'=>$app->postanewjob->jobtype,
            'skill_level'=>$app->postanewjob->skill_level,
            'open'=>1,
            'price_range_low'=>$app->postanewjob->price_range_low,
            'price_range_high'=>$app->postanewjob->price_range_high,
            'anonymous'=>NULL,
            'notes'=>NULL
        );


		$app->connect->insert('avid___jobs',$newjob);
        $lastid = $app->connect->lastInsertId();

        new Flash(array('action'=>'jump-to','location'=>'/jobs/completepost/'.$lastid,'formID'=>'setupsession','message'=>'Job Added'));

	}
