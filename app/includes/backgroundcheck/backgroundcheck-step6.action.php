<?php

    if(empty($app->newtutor->candidate_id) && isset($app->newtutor->charge_id)){


        $candidates = 'https://api.checkr.com/v1/candidates';
        $reports = 'https://api.checkr.com/v1/reports';

        $userinfo = array(
            'us'=>checkrUsername,
            'first_name'=>$app->newtutor->first_name,
            'middle_name'=>$app->newtutor->middle_name,
            'last_name'=>$app->newtutor->last_name,
            'email'=>$app->newtutor->email,
            'phone'=>$app->newtutor->phone,
            'zipcode'=>$app->newtutor->zipcode,
            'dob'=>$app->crypter->decrypt($app->newtutor->dob),
            'ssn'=>$app->crypter->decrypt($app->newtutor->ssn)
        );

        if(isset($userinfo['middle_name']) && $userinfo['middle_name']=='no_middle_name'){
            $userinfo['middle_name'] = NULL;
            $userinfo['no_middle_name'] = true;
        }
        //notify($userinfo);

        if(isset($app->newtutor->location) && $app->newtutor->location=='completecheck'){
            $url = '/background-check/complete';
        }
        else{
            $url = '/signup/tutor/#finish';
        }


        $createCanditate = curlieque($userinfo,$candidates);
        if(isset($createCanditate->error)){
            $_SESSION['slim.flash']['error'] = $createCanditate->error;
            redirect($url);
            exit;
        }

        if(isset($createCanditate->id)){
            $report = array(
                'u'=>checkrUsername,
                'package' => 'tasker_basic',
                'object' =>'package',
                'candidate_id' => $createCanditate->id
            );


            try{
            	$report = curlieque($report,$reports);
            }
            catch(Exception $e){
            	echo '<pre>'; print_r($e); echo '</pre>';
                exit;
            }

            $app->connect->update('avid___new_temps',array('candidate_id'=>$createCanditate->id,'report_ids'=>$report->id),array('email'=>$app->newtutor->email));
            $app->connect->delete('avid___needs_bgcheck',array('email'=>$app->newtutor->email));
            $app->redirect($url);
        }

    }
