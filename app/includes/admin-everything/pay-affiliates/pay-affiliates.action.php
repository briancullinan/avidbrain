<?php

    $sql = "
        SELECT
            affiliates.email,
            affiliates.first_name,
            affiliates.last_name,
            affiliates.mycode,
            user.promocode,
            user.email as useremail,
            sessions.id,
            payments.trasfer_id,
            affiliates.id

        FROM
            avid___affiliates affiliates

        INNER JOIN
            avid___user user on user.promocode = affiliates.mycode

        INNER JOIN

            avid___sessions sessions on sessions.to_user = user.email OR sessions.from_user = user.email

        LEFT JOIN

            avid___affiliates_payments payments on payments.sessionid = sessions.id

        WHERE

            payments.trasfer_id IS NULL


        GROUP BY affiliates.email

    ";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();

    //notify($results);

    if(count($results)>0){
        $app->payaffiliates = $results;
    }

    if(isset($id)){

        $sql = "SELECT * FROM avid___affiliates WHERE id = :id";
        $prepare = array(':id'=>$id);
        $app->affiliateuser = $app->connect->executeQuery($sql,$prepare)->fetch();

        $sql = "
            SELECT
                user.id,user.email,user.promocode,
                payments.id as payment_id,
                sessions.id as sessions_id
            FROM
                avid___user user

            LEFT JOIN
                avid___affiliates_payments payments on payments.paid_email = user.email

            INNER JOIN
                avid___sessions sessions on sessions.from_user = user.email OR sessions.to_user = user.email

            WHERE
                user.promocode = :mycode

            GROUP BY email
        ";

        $prepare = array(
            ':mycode'=>$app->affiliateuser->mycode
        );

        $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
        $paymentinfo = array();
        if(isset($results[0])){
            foreach($results as $affiliate){
                if(empty($affiliate->payment_id)){
                    $paymentinfo[] = $affiliate;
                }
            }
        }
        $app->affiliateuser->everything = $paymentinfo;
        //notify($app->affiliateuser);

    }

    $app->meta = new stdClass();
    $app->meta->title = 'Pay Affiliates';
