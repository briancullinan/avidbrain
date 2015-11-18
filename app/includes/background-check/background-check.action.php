<?php

    if(empty($app->user->needs_bgcheck)){
        $app->redirect($app->user->url);
        exit;
    }

    $app->connect->update('avid___new_temps',array('token'=>$app->user->sessiontoken),array('email'=>$app->user->email));

    $_SESSION['temptutor']['email'] = $app->crypter->encrypt($app->user->email);
    $_SESSION['temptutor']['token'] = $app->crypter->encrypt($app->user->sessiontoken);


    $app->newtutor = new tutorsignup($app->connect,$app->crypter);
    $app->newtutor->location = 'completecheck';


    $sql = "SELECT * FROM avid___compedbgcheck WHERE email = :email";
    $prepare = array(':email'=>$app->user->email);
    $compedBGcheck = $app->connect->executeQuery($sql,$prepare)->fetch();
    if(isset($compedBGcheck->id)){
        $app->newtutor->comp = $compedBGcheck;
    }
