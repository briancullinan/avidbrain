<?php

    //notify($app->user);

    if(isset($app->user->email)){
        $app->usersettings = $app->user->settings();
        if($app->usersettings->affiliateprogram=='yes'){
            $sql = "SELECT * FROM avid___affiliates WHERE email = :email";
            $prepare = array(':email'=>$app->user->email);
            $results = $app->connect->executeQuery($sql,$prepare)->fetch();
            if(empty($results)){

                $insert = array(
                    'email'=>$app->user->email,
                    'mycode'=>randomaffiliate($app->connect,3),
                    'active'=>1,
                    'password'=>$app->user->password,
                    'first_name'=>$app->user->first_name,
                    'last_name'=>$app->user->last_name
                );

                if(!empty($app->user->getpaid)){
                    $insert['getpaid'] = $app->user->getpaid;
                }
                if(!empty($app->user->account_id)){
                    $insert['account_id'] = $app->user->account_id;
                }
                if(!empty($app->user->managed_id)){
                    $insert['managed_id'] = $app->user->managed_id;
                }

                $app->connect->insert('avid___affiliates',$insert);
            }
            else{

                $update = array();
                $update['password'] = $app->user->password;
                $update['first_name'] = $app->user->first_name;
                $update['last_name'] = $app->user->last_name;
                $update['getpaid'] = $app->user->getpaid;
                $update['account_id'] = $app->user->account_id;
                $update['managed_id'] = $app->user->managed_id;

                $app->connect->update('avid___affiliates',$update,array('email'=>$app->user->email));
            }

            $app->affiliate = $results;
        }
        elseif($app->usersettings->affiliateprogram=='no'){

        }
    }
    else{
        $app->redirect('/signup/affiliate');
    }
