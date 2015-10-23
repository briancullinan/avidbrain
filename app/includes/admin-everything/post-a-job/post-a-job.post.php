<?php

    if(isset($app->postjob->type) && $app->postjob->type=='update' && isset($id)){

        $update = array();

        if(isset($app->postjob->newemail) && !empty($app->postjob->newemail)){
            $isuserreal = doesuserexist($app->connect,$app->postjob->newemail);
            if($isuserreal==false){
                new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Invalid User: <span>'.$app->postjob->newemail.'</span>'));
            }
            else{
                $update['email'] = $app->postjob->newemail;
                $update['anonymous'] = NULL;
            }
        }

        $update['job_description'] = $app->postjob->job_description;
        $update['parent_slug'] = $app->postjob->parent_slug;
        $update['price_range_high'] = $app->postjob->price_range_high;
        $update['price_range_low'] = $app->postjob->price_range_low;
        $update['skill_level'] = $app->postjob->skill_level;
        $update['subject_id'] = $app->postjob->subject_id;
        $update['subject_name'] = $app->postjob->subject_name;
        $update['subject_slug'] = $app->postjob->subject_slug;

        $app->connect->update('avid___jobs',$update,array('id'=>$id));

        new Flash(array('action'=>'jump-to','location'=>'/admin-everything/post-a-job/'.$id,'formID'=>'setupsession','message'=>'Job Updated'));

    }
    elseif(isset($app->postjob)){

        $doesexist = NULL;
        if(isset($app->postjob->subject_slug)){
            $sql = "SELECT id FROM avid___jobs WHERE subject_slug = :subject_slug AND email = :email AND open IS NOT NULL";
            $prepeare = array(':subject_slug'=>$app->postjob->subject_slug,':email'=>$app->user->email);
            $doesexist = $app->connect->executeQuery($sql,$prepeare)->rowCount();
            //notify($doesexist);
        }

        if($doesexist!=0){
            //new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Duplicate posting for <span>'.$app->postjob->subject_name.'</span>'));
        }

        if(empty($app->postjob->subject_name)){
            new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Subject Required <i class="fa fa-warning"></i>'));
        }
        elseif(empty($app->postjob->job_description)){
            new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Job Description Required <i class="fa fa-warning"></i>'));
        }

        if(strlen($app->postjob->job_description)>1000){
            new Flash(array('action'=>'required','formID'=>'sessionreviews','message'=>'<span>1,000</span> Characters Maximum '.strlen($app->postjob->job_description).'/1,000'));
        }

        if(empty($app->postjob->parent_slug)){
            $app->postjob->parent_slug = NULL;
        }
        if(empty($app->postjob->subject_slug)){
            $app->postjob->subject_slug = NULL;
        }
        if(empty($app->postjob->type)){
            $app->postjob->type = NULL;
        }
        if(empty($app->postjob->skill_level)){
            $app->postjob->skill_level = NULL;
        }
        if(empty($app->postjob->id)){
            $app->postjob->id = NULL;
        }

        $newjob = array(
            'email'=>$app->user->email,
            'subject_name'=>$app->postjob->subject_name,
            'subject_slug'=>$app->postjob->subject_slug,
            'parent_slug'=>$app->postjob->parent_slug,
            'subject_id'=>$app->postjob->id,
            'date'=>thedate(),
            'job_description'=>$app->postjob->job_description,
            'type'=>$app->postjob->type,
            'skill_level'=>$app->postjob->skill_level,
            'open'=>1,
            'price_range_low'=>$app->postjob->price_range_low,
            'price_range_high'=>$app->postjob->price_range_high,
            'anonymous'=>1
        );

        $app->connect->insert('avid___jobs',$newjob);
        $jobid = $app->connect->lastInsertId();

        new Flash(array('action'=>'jump-to','location'=>'/admin-everything/post-a-job/'.$jobid,'formID'=>'setupsession','message'=>'New Anonymous Session Setup'));

    }
