<?php

function ghost($connect){
    $start = "ghost-";
    $middle = unique_username($connect,2);
    $end = "@avidbrain.com";

    return $start.$middle.$end;
}

    // IT"S THE JEBS
    if(isset($app->postanewjob)){

        if(empty($app->postanewjob->zipcode)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Zipcode Required <i class="fa fa-warning"></i>'));
        }
        elseif(empty($app->postanewjob->subject)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Subject Required'));
        }
        elseif(empty($app->postanewjob->why)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Explain why you need tutored'));
        }

        $app->postanewjob->subject_name = $app->postanewjob->subject;
        $app->postanewjob->job_description = $app->postanewjob->why;


        $ghost = ghost($app->connect);
        $zipcodeinfo = get_zipcode_data($app->connect,$app->postanewjob->zipcode);

        $newjob = array(
            'email'=>$ghost,
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
            'anonymous'=>1,
            'notes'=>$app->postanewjob->notes
        );

        $newUser = array(
            // avid___user
            'email'=>$ghost,
            'usertype'=>'student',
            'state'=>$zipcodeinfo->state_long,
            'state_long'=>$zipcodeinfo->state_long,
            'state_slug'=>$zipcodeinfo->state_slug,
            'city'=>$zipcodeinfo->city,
            'city_slug'=>$zipcodeinfo->city_slug,
            'zipcode'=>$zipcodeinfo->zipcode,
            '`lat`'=>$zipcodeinfo->lat,
            '`long`'=>$zipcodeinfo->long,
            'username'=>unique_username($app->connect,1),
            'status'=>NULL
        );

        $newUserProfile = array('email'=>$email);
        $newUserSettings = array('email'=>$email);



        $app->connect->insert('avid___user',$newUser);
        $app->connect->insert('avid___user_profile',$newUserProfile);
        $app->connect->insert('avid___user_account_settings',$newUserSettings);
        $app->connect->insert('avid___jobs',$newjob);
        $lastid = $app->connect->lastInsertId();

        new Flash(array('action'=>'jump-to','location'=>'/admin-everything/post-a-job/send-emails/'.$lastid,'formID'=>'setupsession','message'=>'Job Added'));

    }
