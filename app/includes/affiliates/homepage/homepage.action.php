<?php

    function total_affiliate($count){
        return ($count*20);
    }

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
                AND
            user.usertype = 'student'

        GROUP BY user.email
    ";

    $prepare = array(
        ':promocode'=>$app->affiliate->mycode,
        ':status'=>'complete'
    );

    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->studentsiwthsessions = $results;
    }

    $sql = "
        SELECT
            user.email,user.promocode,user.usertype,user.first_name,user.signup_date,
            sessions.id
        FROM
            avid___user user

        INNER JOIN

            avid___sessions sessions on user.email = sessions.from_user

        WHERE
            promocode = :promocode
                AND
            sessions.session_status = :status
                AND
            user.usertype = 'tutor'

        GROUP BY user.email
    ";

    $prepare = array(
        ':promocode'=>$app->affiliate->mycode,
        ':status'=>'complete'
    );

    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->tutorswithsessions = $results;
    }


    $sql = "
        SELECT
            user.email,user.promocode,user.usertype,user.first_name,user.signup_date,
            payments.id
        FROM
            avid___user user

        LEFT JOIN
            avid___affiliates_payments payments on user.email = payments.paid_email

        WHERE
            promocode = :promocode

        ORDER BY user.id DESC
    ";

    $prepare = array(
        ':promocode'=>$app->affiliate->mycode
    );

    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    
    if(isset($results[0])){
        $app->signups = $results;
    }


    $one = array();
    if(isset($app->studentsiwthsessions)){
        $one = $app->studentsiwthsessions;
    }
    $two = array();
    if(isset($app->tutorswithsessions)){
        $two = $app->tutorswithsessions;
    }

    $three = array_merge($one,$two);
    $app->count = count($three);
