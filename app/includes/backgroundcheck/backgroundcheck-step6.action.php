<?php
    if(empty($app->newtutor->candidate_id)){
        define('checkrPass',NULL);//490604533e55e6c996bdf6db6c17dcdd8315a1d6

        if($app->dependents->DEBUG==true){
            // 4 = Testing
            define('checkrUsername','490604533e55e6c996bdf6db6c17dcdd8315a1d6');
        }
        else{
            // 5 = Production
            define('checkrUsername','5a055e0454d2727daebad2a56ba51aaad0c05031');
        }

        function curlieque($userInfo,$apiURL){
            $host = $apiURL;
            $process = curl_init($host);
            curl_setopt($process, CURLOPT_HEADER, 1);
            curl_setopt($process, CURLOPT_USERPWD, checkrUsername.":".checkrPass);
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, $userInfo);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $return = curl_exec($process);
            curl_close($process);
            //return $return;

            if(isset($return)){
                $data = explode('{',$return);
                if(isset($data[1])){
                    $realdata = '{'.$data[1];
                    $realdata = json_decode($realdata);
                }
                else{
                    $realdata = json_decode($return);
                }
            }

            return $realdata;
        }


        $candidates = 'https://api.checkr.io/v1/candidates';
        $reports = 'https://api.checkr.io/v1/reports';

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

        $createCanditate = curlieque($userinfo,$candidates);

        if(isset($createCanditate->id)){
            $report = array(
                'u'=>checkrUsername,
                'package' => 'tasker_basic',
                'object' =>'package',
                'candidate_id' => $createCanditate->id
            );
            $report = curlieque($report,$reports);

            $app->connect->update('avid___new_temps',array('candidate_id'=>$createCanditate->id),array('email'=>$app->newtutor->email));
            $app->redirect('/signup/tutor/#finish');
        }

    }
