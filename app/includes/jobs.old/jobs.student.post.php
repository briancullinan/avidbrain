<?php

    //notify($app->user);

    if(isset($app->postjob)){
        $doesexist = NULL;
        if(isset($app->postjob->subject_slug)){
            $sql = "SELECT id FROM avid___jobs WHERE subject_slug = :subject_slug AND email = :email AND open IS NOT NULL";
            $prepeare = array(':subject_slug'=>$app->postjob->subject_slug,':email'=>$app->user->email);
            $doesexist = $app->connect->executeQuery($sql,$prepeare)->rowCount();
            //notify($doesexist);
        }

        if($doesexist!=0){
            new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Duplicate posting for <span>'.$app->postjob->subject_name.'</span>'));
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
            'price_range_high'=>$app->postjob->price_range_high
        );

        $app->connect->insert('avid___jobs',$newjob);
        if(isset($app->user->id)){
            $app->user->status = NULL;
            $app->user->save();
        }
        $jobid = $app->connect->lastInsertId();

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


        $newjobmessage = '<p>New job post from: '.short($app->user).'</p>';
        $newjobmessage.= '<p>Subject Name: '.$app->postjob->subject_name.'</p>';
        $newjobmessage.= '<p>Job Description: '.$app->postjob->job_description.'</p>';
        $newjobmessage.= '<p><a href="https://www.mindspree.com/jobs/apply/'.$jobid.'">View Post</a> </p>';
        if(!empty($app->user->customer_id)){
            $newjobmessage.= '<p> '.short($app->user).' has a credit card on file. </p>';
        }

        if(DEBUG==true){
            $app->mailgun->to = 'admins@mindspree.com';
        }
        else{
            $app->mailgun->to = 'admins@mindspree.com';
        }
        $app->mailgun->subject = 'New Job Post -- Please verify';
        $app->mailgun->message = $newjobmessage;
        $app->mailgun->send();


        if(isset($data[0]) && MODE == 'production'){

            $subject = 'A student has posted a new job';
            $message = '<br><h2>'.$app->postjob->subject_name.' Student</h2>';

            if(isset($app->user->city) && isset($app->user->state)){
                $message.= '<p><strong>Location:</strong>   '.$app->user->city.', '.$app->user->state.'</p>';
            }
            $message.= '<p><strong>Job Description:</strong> <br> '.$app->postjob->job_description.'</p>';
            $message.= '<p><strong>Date Posted:</strong> '.formatdate(thedate(), 'M. jS, Y @ g:i a').'</p>';
            $message.= '<p><strong>My Skill Level:</strong> '.$app->postjob->skill_level.'</p>';
            $message.= '<p><strong>Tutoring Type:</strong> '.online_tutor($app->postjob->type).'</p>';
            $message.= '<p><a href="'.DOMAIN.'/jobs/apply/'.$jobid.'">View Job Posting</a></p>';

            $message.= '<p>If you do not want to receive these emails, you can change your options in the Account Settings Page</p>';


            foreach($data as $sendEmail){
                $app->mailgun->to = $sendEmail->email;
                $app->mailgun->subject = $subject;
                $app->mailgun->message = $message;
                $app->mailgun->send();
            }
        }

        new Flash(array('action'=>'jump-to','location'=>'/jobs/manage/'.$jobid.'','message'=>'Job Posted'));

    }
