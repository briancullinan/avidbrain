<?php
    if(isset($app->approveprofile)){

        unset($app->approveprofile->id);
        unset($app->approveprofile->target);

        $updates = new stdClass();
        $updates->username = unique_username($app->connect,4);
        $updates->url = make_my_url($app->thetutor,$updates->username);
        $updates->approved_upload = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$updates->username.getfiletype($app->thetutor->upload);

        $uploads = $app->dependents->APP_PATH.'uploads';
        $oldPath = $uploads.'/tutorphotos/'.$app->thetutor->upload;
        $newPath = $uploads.'/photos/'.$app->thetutor->upload;

        try{
        	rename($oldPath,$newPath);
        }
        catch(Exception $e){
        	//echo '<pre>'; print_r($e); echo '</pre>';
        }

        $oldPath = $uploads.'/tutorphotos/'.$app->thetutor->cropped;
        $newPath = $uploads.'/photos/'.$app->thetutor->cropped;


        try{
            copy($oldPath,$updates->approved_upload);
        }
        catch(Exception $e){
            //echo '<pre>'; print_r($e); echo '</pre>';
        }


        try{
            rename($oldPath,$newPath);
        }
        catch(Exception $e){
            //echo '<pre>'; print_r($e); echo '</pre>';
        }

        
        foreach($app->approveprofile as $insertSub){
            $insertSub = (array)$insertSub;
            $insertSub['status'] = 'needs-review';
            $insertSub['sortorder'] = 0;
            $app->connect->insert('avid___user_subjects',$insertSub);
        }

        $user = array(
            'email'=>$app->thetutor->email,
            'password'=>$app->thetutor->password,
            'usertype'=>$app->thetutor->usertype,
            'first_name'=>$app->thetutor->first_name,
            'last_name'=>$app->thetutor->last_name,
            'promocode'=>$app->thetutor->promocode,
            'signup_date'=>$app->thetutor->signupdate,
            'phone'=>$app->thetutor->phone,
            'zipcode'=>$app->thetutor->zipcode,
            'state'=>$app->thetutor->state,
            'state_long'=>$app->thetutor->state_long,
            'state_slug'=>$app->thetutor->state_slug,
            'city'=>$app->thetutor->city,
            'city_slug'=>$app->thetutor->city_slug,
            '`lat`'=>$app->thetutor->lat,
            '`long`'=>$app->thetutor->long,
            'status'=>NULL,
            'hidden'=>NULL,
            'username'=>$updates->username,
            'url'=>$updates->url
        );

        $app->connect->insert('avid___user',$user);

        $profile = array(
            'email'=>$app->thetutor->email,
            'short_description'=>$app->thetutor->short_description,
            'short_description_verified'=>$app->thetutor->short_description,
            'short_description_verified_status'=>NULL,
            'personal_statement'=>$app->thetutor->personal_statement,
            'personal_statement_verified'=>$app->thetutor->personal_statement,
            'personal_statement_verified_status'=>NULL,
            'hourly_rate'=>$app->thetutor->hourly_rate,
            'gender'=>$app->thetutor->gender,
            'travel_distance'=>$app->thetutor->travel_distance,
            'online_tutor'=>$app->thetutor->online_tutor,
            'cancellation_policy'=>$app->thetutor->cancellation_policy,
            'cancellation_rate'=>$app->thetutor->cancellation_rate,
            'my_upload'=>$app->thetutor->upload,
            'my_upload_status'=>'verified'
        );

        $app->connect->insert('avid___user_profile',$profile);

        if(empty($app->thetutor->candidate_id)){
            $app->connect->insert('avid___needs_bgcheck',array('email'=>$app->thetutor->email,'date'=>thedate()));
        }

        $settings = array(
            'email'=>$app->thetutor->email
        );

        $app->connect->insert('avid___user_account_settings',$settings);

        $app->connect->update('avid___new_temps',array('activated'=>1),array('email'=>$app->thetutor->email));

        $app->redirect('/admin-everything/new-tutor-approvals');

    }
