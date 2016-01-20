<?php

    $sql = "
        SELECT
            jobs.*,
            user.zipcode,
            user.lat,
            user.long
        FROM
            avid___jobs jobs

        INNER JOIN
            avid___user user on user.email = jobs.email
        WHERE
            jobs.id = :id
    ";
    $prepare = array(':id'=>$id);
    $results = $app->connect->executeQuery($sql,$prepare)->fetch();
    if(isset($results->id)){
        $app->job = $results;
    }
    //notify($app->job);

    $sql = "
        SELECT
            *
        FROM
            avid___jobs_log
        WHERE
            job_id = :id
    ";
    $prepared = array(':id'=>$id);
    $app->joblog = $app->connect->executeQuery($sql,$prepared)->fetch();


    if(empty($app->joblog->id)){

        $prepared = [];
        $additional ='';
        $having = '';
        $andWhere = '';

        if(isset($app->job->type)){
            if($app->job->type=='offline'){
                $getDistance = "
                    ,round(((acos(sin((" . $app->job->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $app->job->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$app->job->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515)
                ";
                $asDistance = ' as distance ';
                $additional.= $getDistance.$asDistance;
                $having = "HAVING distance <= :distance";
                $prepared[':distance'] = 60;
            }
            elseif($app->job->type=='online'){
                $andWhere = " AND profile.online_tutor = 'online' ";
            }
            elseif($app->job->type=='both'){
                $andWhere = " AND profile.online_tutor = 'both' ";
            }
        }

        $sql = "
            SELECT
                user.email,
                user.first_name,
                user.last_name,
                user.last_active,
                subjects.subject_slug,
                settings.newjobs,
                profile.hourly_rate,
                profile.online_tutor
                $additional

            FROM
                avid___user user

            INNER JOIN
                avid___user_subjects subjects
                    ON
                user.email = subjects.email

            INNER JOIN
                avid___user_account_settings settings
                    ON
                user.email = settings.email

            INNER JOIN
                avid___user_profile profile
                    ON
                user.email = profile.email

            WHERE
                user.status IS NULL

                    AND
                user.hidden IS NULL

                    AND
                user.lock IS NULL

                    AND
                subjects.subject_slug = :subject_slug

                    AND
                settings.newjobs = 'yes'

                    AND
                profile.online_tutor = :tutortype

                    AND
                profile.hourly_rate BETWEEN :pricerangeLower and :pricerangeUpper

                    $andWhere

                GROUP BY user.email

                $having



        ";

        $prepared[':subject_slug'] = $app->job->subject_slug;
        $prepared[':tutortype'] = $app->job->type;
        $prepared[':pricerangeLower'] = $app->job->price_range_low;
        $prepared[':pricerangeUpper'] = $app->job->price_range_high;


        $results = $app->connect->executeQuery($sql,$prepared)->fetchAll();
        //notify($results);


        $emailText = "New Student Job Post";
        $emailMessage = "<p><strong>A student has posted a new job request, fitting your profile</strong></p>";
        $emailMessage.= "<div><strong>Subject: </strong> ".$app->job->subject_name." </div>";
        $emailMessage.= "<div><strong>Date Posted: </strong> ".formatdate($app->job->date)." </div>";
        $emailMessage.= "<div><strong>Job Description: </strong> ".$app->job->job_description." </div>";
        if(!empty($app->job->skill_level)){
            $emailMessage.= "<div><strong>Skill Level: </strong> ".$app->job->skill_level." </div>";
        }
        $emailMessage.= "<div><strong>Zipcode: </strong> ".$app->job->zipcode." </div>";
        $emailMessage.= '<div><strong>Tutoring Type:</strong> '.online_tutor($app->job->type).'</div>';
        $emailMessage.= '<p><a href="'.$app->dependents->DOMAIN.'/jobs/apply/'.$app->job->id.'">View Job Posting</a></p>';
        $emailMessage.= '<small>If you do not want to receive these emails, you can change your options in the Account Settings Page</small>';




        $json = array();
        foreach($results as $convertojson){
            $json[] = (object)array('email'=>$convertojson->email,'name'=>$convertojson->first_name.' '.$convertojson->last_name);
        }

        $jsoncode = json_encode($json);

        $insert = array(
            'date'=>thedate(),
            'job_id'=>$id,
            'email_list'=>$jsoncode
        );

        $app->connect->insert('avid___jobs_log',$insert);


        if($app->dependents->DEBUG==true){
            // Do Nothing
        }
        else{
            //notify("FRAMS");
            foreach($results as $sendEamil){
                $app->mailgun->to = $sendEamil->email;
                $app->mailgun->subject = $emailText;
                $app->mailgun->message = $emailMessage;
                $app->mailgun->send();
            }
        }

        $app->redirect($app->request->getPath());

    }
