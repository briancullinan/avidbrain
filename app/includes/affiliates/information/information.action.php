<?php

    $sql = "SELECT * FROM avid___user_checks WHERE email = :email LIMIT 1";
    $prepare = array(':email'=>$app->affiliate->email);
    $checks = $app->connect->executeQuery($sql,$prepare)->fetch();
    if(isset($checks->id)){
        $checkid = $checks->id;
        $checkemail = $checks->email;
        foreach($checks as $decryptKey => $decryptValue){
            $checks->$decryptKey = $app->crypter->decrypt($decryptValue);
        }
        $checks->id = $checkid;
        $checks->email = $checkemail;
        $app->cutchecksinfo = $checks;
    }
