<?php

    function ghost($connect){
        $start = "ghost-";
        $middle = unique_username($connect,1);
        $end = "@avidbrain.com";

        return $start.$middle.$end;
    }

    //notify($app->postjob);

    if(isset($app->postjob->type) && $app->postjob->type=='update' && isset($id)){

        $update = array();

        if(empty($app->postjob->zipcode)){
            new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Zipcode Required <i class="fa fa-warning"></i>'));
        }

        if(isset($app->postjob->newemail) && !empty($app->postjob->newemail)){
            $isuserreal = doesuserexist($app->connect,$app->postjob->newemail);
            if($isuserreal==false){
                new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Invalid User: <span>'.$app->postjob->newemail.'</span>'));
            }
            else{

                if(isset($app->thejob->email)){
                    if (strpos($app->thejob->email, 'ghost-') !== false){
                        $app->connect->delete('avid___user',array('email'=>$app->thejob->email));
                        $app->connect->delete('avid___user_profile',array('email'=>$app->thejob->email));
                        $app->connect->delete('avid___user_account_settings',array('email'=>$app->thejob->email));
                    }
                }
                $update['email'] = $app->postjob->newemail;
                $update['anonymous'] = NULL;
            }
        }
        else{
            $email = ghost($app->connect);
            $zipcodeinfo = get_zipcode_data($app->connect,$app->postjob->zipcode);
            $newUser = array(
                // avid___user
                'email'=>$email,
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

            $update['email'] = $email;

        }

        $update['job_description'] = $app->postjob->job_description;
        $update['parent_slug'] = $app->postjob->parent_slug;
        $update['price_range_high'] = $app->postjob->price_range_high;
        $update['price_range_low'] = $app->postjob->price_range_low;
        $update['skill_level'] = $app->postjob->skill_level;
        $update['subject_id'] = $app->postjob->subject_id;
        $update['subject_name'] = $app->postjob->subject_name;
        $update['subject_slug'] = $app->postjob->subject_slug;
        $update['notes'] = $app->postjob->notes;



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

        if(empty($app->postjob->zipcode)){
            new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Zipcode Required <i class="fa fa-warning"></i>'));
        }
        elseif(empty($app->postjob->subject_name)){
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

        $email = ghost($app->connect);

        $newjob = array(
            'email'=>$email,
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
            'anonymous'=>1,
            'notes'=>$app->postjob->notes
        );

        $zipcodeinfo = get_zipcode_data($app->connect,$app->postjob->zipcode);
        $newUser = array(
            // avid___user
            'email'=>$email,
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
        $jobid = $app->connect->lastInsertId();

        // START HERE ----
            $data	=	$app->connect->createQueryBuilder();
            $data	=	$data->select('subjects.subject_name, user.email, user.first_name, user.last_name')->from('avid___user','user');
            $data	=	$data->where('user.usertype = :usertype')->setParameter(':usertype','tutor');
            $data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
            $data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
            $data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
            $data	=	$data->andWhere('settings.newjobs = "yes"');

            $data	=	$data->andWhere('user.status IS NULL');
            $data	=	$data->andWhere('user.hidden IS NULL');
            $data	=	$data->andWhere('user.lock IS NULL');

            if(!empty($app->postjob->subject_name)){
                $data   =   $data->andWhere('subjects.subject_name = :subject_name')->setParameter(':subject_name',$app->postjob->subject_name);
            }
            if(!empty($app->postjob->subject_slug)){
                $data   =   $data->andWhere('subjects.subject_slug = :subject_slug')->setParameter(':subject_slug',$app->postjob->subject_slug);
            }

            ////
            $data	=	$data->addSelect('profile.hourly_rate');
            $data	=	$data->andWhere('profile.hourly_rate BETWEEN :pricerangeLower and :pricerangeUpper');
            $data	=	$data->andWhere('profile.hourly_rate IS NOT NULL');
            $data	=	$data->setParameter(':pricerangeLower',$app->postjob->price_range_low);
            $data	=	$data->setParameter(':pricerangeUpper',$app->postjob->price_range_high);
            ////

            if($app->postjob->type=='both'){

            }
            elseif($app->postjob->type=='online'){
                $data   =   $data->andWhere('profile.online_tutor = :online_tutor')->setParameter(':online_tutor','online');
            }
            elseif($app->postjob->type=='offline'){
                $data   =   $data->andWhere('profile.online_tutor = :online_tutor')->setParameter(':online_tutor','offline');
            }

            $data	=	$data->andWhere('subjects.subject_slug = :subject_slug');
            $data	=	$data->setParameter(':subject_slug',$app->postjob->subject_slug);
            $data	=	$data->andWhere('subjects.parent_slug = :parent_slug');
            $data	=	$data->setParameter(':parent_slug',$app->postjob->parent_slug);
            $data	=	$data->groupBy('user.email');
            $data	=	$data->execute()->fetchAll();

            //notify($data);


            if(isset($data[0]) && $app->dependents->MODE == 'production'){

                $subject = 'A student has posted a new job';
                $message = '<br><h2>'.$app->postjob->subject_name.' Student</h2>';

                $message.= '<p><strong>Job Description:</strong> <br> '.$app->postjob->job_description.'</p>';
                $message.= '<p><strong>Date Posted:</strong> '.formatdate(thedate(), 'M. jS, Y @ g:i a').'</p>';
                $message.= '<p><strong>My Skill Level:</strong> '.$app->postjob->skill_level.'</p>';
                $message.= '<p><strong>Tutoring Type:</strong> '.online_tutor($app->postjob->type).'</p>';
                $message.= '<p><a href="'.$app->dependents->DOMAIN.'/jobs/apply/'.$jobid.'">View Job Posting</a></p>';

                $message.= '<p>If you do not want to receive these emails, you can change your options in the Account Settings Page</p>';

                foreach($data as $sendEmail){
                    $app->mailgun->to = $sendEmail->email;
                    $app->mailgun->subject = $subject;
                    $app->mailgun->message = $message;
                    $app->mailgun->send();
                }
            }
        // END HERE ----

        new Flash(array('action'=>'jump-to','location'=>'/admin-everything/post-a-job/'.$jobid,'formID'=>'setupsession','message'=>'New Anonymous Session Setup'));

    }
