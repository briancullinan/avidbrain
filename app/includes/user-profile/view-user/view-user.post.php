<?php

    unset($app->makechanges->target);

    $allowed = [
        'short_description_verified',
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
        'personal_statement_verified',
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

    if($app->actualuser->email==$app->user->email && isset($app->makechanges)){

        if(checkagainst($app->makechanges,$allowed)!==true){

            $updateUser = [];

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

            $updateProfile = [];
            $updateProfile['short_description_verified'] = ($app->makechanges->short_description_verified ? $app->makechanges->short_description_verified : $app->actualuser->short_description_verified);
            $updateProfile['hourly_rate'] = ($app->makechanges->hourly_rate ? $app->makechanges->hourly_rate : $app->actualuser->hourly_rate);
            $updateProfile['gender'] = ($app->makechanges->gender ? $app->makechanges->gender : $app->actualuser->gender);
            $updateProfile['travel_distance'] = ($app->makechanges->travel_distance ? $app->makechanges->travel_distance : $app->actualuser->travel_distance);
            $updateProfile['cancellation_policy'] = ($app->makechanges->cancellation_policy ? $app->makechanges->cancellation_policy : $app->actualuser->cancellation_policy);
            $updateProfile['cancellation_rate'] = ($app->makechanges->cancellation_rate ? $app->makechanges->cancellation_rate : $app->actualuser->cancellation_rate);
            $updateProfile['online_tutor'] = ($app->makechanges->online_tutor ? $app->makechanges->online_tutor : $app->actualuser->online_tutor);
            $updateProfile['personal_statement_verified'] = ($app->makechanges->personal_statement_verified ? $app->makechanges->personal_statement_verified : $app->actualuser->personal_statement_verified);

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
