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
    elseif(isset($app->updatejob)){

        $updateJob = [];

        if(empty($app->updatejob->zipcode)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Zipcode Required <i class="fa fa-warning"></i>'));
        }
        elseif(empty($app->updatejob->subject)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Subject Required'));
        }
        elseif(empty($app->updatejob->why)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Explain why you need tutored'));
        }

        $app->updatejob->subject_name = $app->updatejob->subject;
        $app->updatejob->job_description = $app->updatejob->why;

        if($app->updatejob->open=='OPEN'){
            $app->updatejob->open = 1;
        }
        elseif($app->updatejob->open=='CLOSED'){
            $app->updatejob->open = NULL;
        }

        if(!empty($app->updatejob->attatchuser)){

            $isuserreal = doesuserexist($app->connect,$app->updatejob->attatchuser);
            if($isuserreal==false){
                new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Invalid User: <span>'.$app->updatejob->attatchuser.'</span>'));
            }
            else{

                if(isset($app->updatejob->attatchuser)){
                    if (strpos($app->updatejob->attatchuser, 'ghost-') !== false){
                        $app->connect->delete('avid___user',array('email'=>$app->updatejob->attatchuser));
                        $app->connect->delete('avid___user_profile',array('email'=>$app->updatejob->attatchuser));
                        $app->connect->delete('avid___user_account_settings',array('email'=>$app->updatejob->attatchuser));
                    }
                }
                $updateJob['email'] = $app->updatejob->attatchuser;
                $app->updatejob->open = NULL;
                $updateJob['anonymous'] = NULL;


            }

        }

        if($app->updatejob->zipcode != $app->thejob->zipcode){
            $newzipcode = get_zipcode_data($app->connect,$app->updatejob->zipcode);

            $updateUser = array(

                'state'=>$newzipcode->state_long,
                'state_long'=>$newzipcode->state_long,
                'state_slug'=>$newzipcode->state_slug,
                'city'=>$newzipcode->city,
                'city_slug'=>$newzipcode->city_slug,
                'zipcode'=>$newzipcode->zipcode,
                '`lat`'=>$newzipcode->lat,
                '`long`'=>$newzipcode->long
            );

            $app->connect->update('avid___user',$updateUser,array('email'=>$app->thejob->email));



        }

        if(empty($app->updatejob->subject_slug)){
            $app->updatejob->subject_slug = $app->thejob->subject_slug;
            $app->updatejob->parent_slug = $app->thejob->parent_slug;
            $app->updatejob->subject_id = $app->thejob->subject_id;
            $app->updatejob->type = $app->thejob->type;
            $app->updatejob->skill_level = $app->thejob->skill_level;
            $app->updatejob->notes = $app->thejob->notes;
        }

        $updateJob['subject_name'] = $app->updatejob->subject_name;
        $updateJob['subject_slug'] = $app->updatejob->subject_slug;
        $updateJob['parent_slug'] = $app->updatejob->parent_slug;
        $updateJob['subject_id'] = $app->updatejob->subject_id;
        $updateJob['date'] = thedate();
        $updateJob['job_description'] = $app->updatejob->job_description;
        $updateJob['type'] = $app->updatejob->type;
        $updateJob['skill_level'] = $app->updatejob->skill_level;
        $updateJob['open'] = $app->updatejob->open;
        $updateJob['price_range_low'] = $app->updatejob->price_range_low;
        $updateJob['price_range_high'] = $app->updatejob->price_range_high;
        $updateJob['notes'] = $app->updatejob->notes;

        //notify($updateJob);

        $app->connect->update('avid___jobs',$updateJob,array('id'=>$id));


        new Flash(array('action'=>'jump-to','location'=>'/admin-everything/post-a-job/'.$id,'formID'=>'setupsession','message'=>'Job Updated'));

    }
