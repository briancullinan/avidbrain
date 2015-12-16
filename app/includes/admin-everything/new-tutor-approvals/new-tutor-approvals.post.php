<?php

    if(isset($app->approveprofile)){

        if($app->thetutor->cancellation_policy==0){
            $app->thetutor->cancellation_policy = NULL;
        }
        if($app->thetutor->cancellation_rate==0){
            $app->thetutor->cancellation_rate = NULL;
        }
        if($app->thetutor->gender=='dontshow'){
            $app->thetutor->gender = NULL;
        }

        unset($app->approveprofile->id);
        unset($app->approveprofile->target);

        $updates = new stdClass();
        $updates->username = unique_username($app->connect,4);
        $updates->url = make_my_url($app->thetutor,$updates->username);
        $updates->approved_upload = $app->dependents->DOCUMENT_ROOT.'profiles/approved/'.$updates->username.getfiletype($app->thetutor->upload);
        $updates->file = $updates->username.getfiletype($app->thetutor->upload);
        $updates->crop = croppedfile($updates->file);
        $updates->oldupload = $app->thetutor->upload;
        $updates->olduploadCrop = croppedfile($app->thetutor->upload);
        $updates->olduploadlocation = $app->dependents->APP_PATH.'uploads/photos/';





        $oldFull = $updates->olduploadlocation.$updates->oldupload;
        $newFull = $updates->olduploadlocation.$updates->file;

        $oldCropped = $updates->olduploadlocation.$updates->olduploadCrop;
        $newCropped = $updates->olduploadlocation.$updates->crop;

        // MOVE FILE TO APPROVED CROPPED
        $uploads = $app->dependents->APP_PATH.'uploads';
        $oldPath = $uploads.'/photos/'.$app->thetutor->upload;

        try{
            copy(croppedfile($oldPath),croppedfile($updates->approved_upload));
        }
        catch(Exception $e){
            //echo '<pre>'; print_r($e); echo '</pre>';
        }

        try{
            rename($oldFull,$newFull);
        }
        catch(Exception $e){
            //echo '<pre>'; print_r($e); echo '</pre>';
        }

        try{
            rename($oldCropped,$newCropped);
        }
        catch(Exception $e){
            //echo '<pre>'; print_r($e); echo '</pre>';
        }


        $insertallthesubs = array();
        $allthesubs = $app->approveprofile;
        foreach($allthesubs as $insert){
            $insertallthesubs = (array)$insert;
            $insertallthesubs['status'] = 'verified';
            $insertallthesubs['sortorder'] = 0;
            if(isset($insert->description)){
                $insertallthesubs['description'] = $insert->description;
            }
            $app->connect->insert('avid___user_subjects',$insertallthesubs);
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
            'url'=>$updates->url,
            'emptybgcheck'=>1
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
            'my_upload'=>$updates->file,
            'my_upload_status'=>'verified'
        );

        if(isset($app->thetutor->promocode) && $app->thetutor->promocode=='get80--free-backgroundcheck'){
            $profile['top1000'] = 1;
            $app->thetutor->promocode = 'AvidTeach';
        }
        elseif(isset($app->thetutor->promocode) && $app->thetutor->promocode=='get80'){
            $profile['top1000'] = 1;
        }

        $app->connect->insert('avid___user_profile',$profile);

        if(empty($app->thetutor->candidate_id)){
            $app->connect->insert('avid___needs_bgcheck',array('email'=>$app->thetutor->email,'date'=>thedate()));
        }

        $settings = array(
            'email'=>$app->thetutor->email
        );

        $app->connect->insert('avid___user_account_settings',$settings);

        $app->connect->update('avid___new_temps',array('activated'=>1,'approval_status'=>'approved'),array('email'=>$app->thetutor->email));

        $subject = 'AvidBrain Application Approval';
        $message = '<p>Congratulations <strong>'.$app->thetutor->first_name.' '.$app->thetutor->last_name.'</strong>, your profile has been approved. You can now login and find students.</p>';
        $message.= '<p> Your username is your email address and your password is what you used to signup with. <br/> If you can\'t remember your password you can <a href="'.$app->dependents->DOMAIN.'/help/forgot-password">reset it here</a>. </p>';
        $message.= '<p> <a href="'.$app->dependents->DOMAIN.'/login">Login</a> </p>';

        if(empty($app->thetutor->candidate_id)){
            //$message.= '<br><p> Since you haven\'t completed the background check you can apply to jobs and view students, but you can\'t message them or setup a tutoring session. </p>';
            $message.= '<br><p> Once you login you can apply to jobs and view student profiles, but you won\'t be able to inteact with them untill you complete your background check. </p>';
        }

        if(isset($app->thetutor->comper)){
            $message.= '<br><p> Your background check application fee of $29.99 has been comped by AvidBrain. </p>';
        }


        $app->mailgun->to = $app->thetutor->email;
        $app->mailgun->subject = $subject;
        $app->mailgun->message = $message;
        $app->mailgun->send();

        $app->redirect('/admin-everything/new-tutor-approvals');

    }
    elseif(isset($app->rejectprofile)){



        $reject = array('approval_status'=>'rejected');
        $whoami = array('email'=>$app->thetutor->email);

        printer($reject);
        printer($whoami);
        exit;

        $app->connect->update('avid___new_temps',$reject,$whoami);

        $app->redirect('/admin-everything/new-tutor-approvals/');

    }
    elseif(isset($app->compbackgroundcheck)){

        $comp = array(
            'email'=>$app->compbackgroundcheck->email,
            'date'=>thedate(),
            'comper'=>$app->user->email
        );

        $app->connect->insert('avid___compedbgcheck',$comp);

        $app->redirect('/admin-everything/new-tutor-approvals/'.$id);
    }
