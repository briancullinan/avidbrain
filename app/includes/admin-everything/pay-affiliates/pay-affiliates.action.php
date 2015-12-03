<?php
    $sql = "
        SELECT
            affiliates.email,
            affiliates.id,
            affiliates.first_name,
            affiliates.last_name,
            affiliates.mycode

        FROM
            avid___affiliates affiliates

        GROUP BY email

    ";
    $prepare = array(':usertype'=>'tutor');
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();

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
