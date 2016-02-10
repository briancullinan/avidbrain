<?php

    $sql = "
        SELECT
            affiliates.*,
            user.id as userid
        FROM
            avid___affiliates affiliates

        LEFT JOIN
            avid___user user on user.email = affiliates.email

    ";
    $prepare = array(

    );
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    //notify($results);
    if(isset($results[0])){
        $app->affiliates = $results;
    }


    if(isset($action) && $action=='view' && isset($id)){
        $sql = "
            SELECT
                affiliates.*,
                user.id as userid,
                user.usertype,
                user.url
            FROM
                avid___affiliates affiliates

            LEFT JOIN
                avid___user user on user.email = affiliates.email

            WHERE affiliates.id = :id

        ";
        $prepare = array(
            ':id'=>$id
        );
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->id)){
            $app->affiliate = $results;
        }
    }
