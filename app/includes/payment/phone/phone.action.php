<?php

    $app->meta = new stdClass();
    $app->meta->title = 'Validate Your Account';
    $app->meta->h1 = 'Phone Verification';


    $sql = "SELECT * FROM avid___user_verification WHERE email = :email";
    $prepare = array(':email'=>$app->user->email);
    $validate = $app->connect->executeQuery($sql,$prepare)->fetch();
    if(isset($validate->id)){
        $app->phonevalidation = $validate;
    }
