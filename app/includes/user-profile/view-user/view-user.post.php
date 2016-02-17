<?php

    unset($app->makechanges->target);

    //notify($app->makechanges);

    $allowed = [
        'mytagline',
        'statement',
        'first_name',
        'last_name',
        'hourly_rate',
        'city',
        'state_long',
        'gender',
        'travel_distance',
        'cancellation_policy',
        'cancellation_rate',
        'online_tutor',
        'locationinfo',
        'zipcode'
    ];

    function checkagainst($array,$allowed){
        foreach($array as $key=> $checkAgainst){
            if(!in_array($key, $allowed)){
                return true;
            }
        }
    }

    if($app->actualuser->email==$app->user->email && isset($app->mysubjects)){

        printer($app->mysubjects);

        if(isset($app->mysubjects->newitem)){

            $sql = "SELECT sortorder FROM avid___user_subjects WHERE email = :email ORDER BY sortorder DESC LIMIT 1";
            $prepeare = array(':email'=>$app->actualuser->email);
            $sortMax = $app->connect->executeQuery($sql,$prepeare)->fetch();

            $insert = [
                'email'=>$app->actualuser->email,
                'subject_slug'=>$app->mysubjects->subject_slug,
                'parent_slug'=>$app->mysubjects->parent_slug,
                'description'=>$app->mysubjects->description,
                'last_modified'=>thedate(),
                'status'=>'needs-review',
                'usertype'=>'tutor',
                'subject_name'=>$app->mysubjects->subject_name,
                'sortorder'=>($sortMax->sortorder+1)
            ];

            $app->connect->insert('avid___user_subjects',$insert);
        }
        if(isset($app->mysubjects->description_verified)){
            $update = [
                'description'=>$app->mysubjects->description_verified,
                'last_modified'=>thedate(),
                'status'=>'needs-review'
            ];
            $app->connect->update('avid___user_subjects',$update,array('email'=>$app->actualuser->email,'id'=>$app->mysubjects->id));
        }
        elseif(isset($app->mysubjects->status) && $app->mysubjects->status=='save'){
            $update = [
                'description'=>$app->mysubjects->description,
                'last_modified'=>thedate(),
                'status'=>'needs-review'
            ];
            $app->connect->update('avid___user_subjects',$update,array('email'=>$app->actualuser->email,'id'=>$app->mysubjects->id));
        }
        elseif(isset($app->mysubjects->status) && $app->mysubjects->status=='delete'){
            $app->mysubjects->subject_slug = NULL;
            $app->connect->delete('avid___user_subjects',array('email'=>$app->actualuser->email,'id'=>$app->mysubjects->id));
        }
        else{
            printer('UHOH!');
        }
        $app->redirect($app->actualuser->url.'/my-subjects/'.$app->mysubjects->parent_slug.'/'.$app->mysubjects->subject_slug);
    }
    elseif($app->actualuser->email==$app->user->email && isset($app->makechanges)){

        if(checkagainst($app->makechanges,$allowed)!==true){

            $updateUser = [];
            $updateProfile = [];

            if(isset($app->makechanges->mytagline)){

                if(!empty($app->actualuser->short_description_verified) && $app->makechanges->mytagline != $app->actualuser->short_description_verified){
                    $updateProfile['short_description'] = $app->makechanges->mytagline;
                }
                elseif(!empty($app->actualuser->short_description_verified) && $app->makechanges->mytagline == $app->actualuser->short_description_verified){
                    $updateProfile['short_description'] = $app->makechanges->mytagline;
                    $updateProfile['short_description_verified'] = $app->makechanges->mytagline;
                }
                else{
                    $updateProfile['short_description'] = $app->makechanges->mytagline;
                }

            }

            if(isset($app->makechanges->statement)){

                if(!empty($app->actualuser->personal_statement_verified) && $app->makechanges->statement != $app->actualuser->personal_statement_verified){
                    $updateProfile['personal_statement'] = $app->makechanges->statement;
                }
                elseif(!empty($app->actualuser->personal_statement_verified) && $app->makechanges->statement == $app->actualuser->personal_statement_verified){
                    $updateProfile['personal_statement'] = $app->makechanges->statement;
                    $updateProfile['personal_statement_verified'] = $app->makechanges->statement;
                }
                else{
                    $updateProfile['personal_statement'] = $app->makechanges->statement;
                }

            }

            if(isset($app->makechanges->zipcode) && isset($app->makechanges->locationinfo)){
                $zipdata = get_zipcode_data($app->connect,$app->makechanges->zipcode);
                if(isset($zipdata->id)){

                    $updateUser['zipcode'] = $zipdata->zipcode;
                    $updateUser['state'] = $zipdata->state;
                    $updateUser['state_long'] = $zipdata->state_long;
                    $updateUser['`lat`'] = $zipdata->lat;
                    $updateUser['`long`'] = $zipdata->long;
                    $updateUser['state_slug'] = $zipdata->state_slug;
                    $updateUser['city_slug'] = $zipdata->city_slug;
                    $updateUser['city'] = $zipdata->city;

                    $updateUser['url'] = update_zipcode($app->actualuser,$zipdata);
                }
            }


            $updateUser['first_name'] = ($app->makechanges->first_name ? $app->makechanges->first_name : $app->actualuser->first_name);
            $updateUser['last_name'] = ($app->makechanges->last_name ? $app->makechanges->last_name : $app->actualuser->last_name);


            #$updateProfile['short_description_verified'] = ($app->makechanges->mytagline ? $app->makechanges->mytagline : $app->actualuser->short_description_verified);
            #$updateProfile['personal_statement_verified'] = ($app->makechanges->personal_statement_verified ? $app->makechanges->personal_statement_verified : $app->actualuser->personal_statement_verified);
            $updateProfile['hourly_rate'] = ($app->makechanges->hourly_rate ? $app->makechanges->hourly_rate : $app->actualuser->hourly_rate);
            $updateProfile['gender'] = ($app->makechanges->gender ? $app->makechanges->gender : $app->actualuser->gender);
            $updateProfile['travel_distance'] = ($app->makechanges->travel_distance ? $app->makechanges->travel_distance : $app->actualuser->travel_distance);
            $updateProfile['cancellation_policy'] = ($app->makechanges->cancellation_policy ? $app->makechanges->cancellation_policy : $app->actualuser->cancellation_policy);
            $updateProfile['cancellation_rate'] = ($app->makechanges->cancellation_rate ? $app->makechanges->cancellation_rate : $app->actualuser->cancellation_rate);
            $updateProfile['online_tutor'] = ($app->makechanges->online_tutor ? $app->makechanges->online_tutor : $app->actualuser->online_tutor);

            if(isset($updateUser['url'])){
                $url = $updateUser['url'];
            }
            else{
                $url = $app->actualuser->url;
            }

            $app->connect->update('avid___user_profile',$updateProfile,array('email'=>$app->user->email));
            $app->connect->update('avid___user',$updateUser,array('email'=>$app->user->email));
            $app->redirect($url);
        }
        else{
            notify($app->makechanges);
            notify('UHOH!');
        }

    }
    else{
        notify('science');
    }
