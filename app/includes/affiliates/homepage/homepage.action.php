<?php

    $sql = "
        SELECT
            user.email,user.promocode,user.usertype,user.first_name,user.signup_date,
            sessions.id
        FROM
            avid___user user

        INNER JOIN

            avid___sessions sessions on user.email = sessions.to_user

        WHERE
            promocode = :promocode
                AND
            sessions.session_status = :status
    ";

    $prepare = array(
        ':promocode'=>$app->affiliate->mycode,
        ':status'=>'complete'
    );

    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->signupswithsessions = $results;
    }


    $sql = "
        SELECT
            user.email,user.promocode,user.usertype,user.first_name,user.signup_date,
            sessions.id
        FROM
            avid___user user

        LEFT JOIN

            avid___sessions sessions on user.email = sessions.to_user

        WHERE
            promocode = :promocode
    ";

    $prepare = array(
        ':promocode'=>$app->affiliate->mycode
    );

    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->signups = $results;
    }
