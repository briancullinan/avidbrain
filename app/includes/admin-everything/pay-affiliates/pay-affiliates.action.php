<?php
    $sql = "
        SELECT
            email,id,first_name,last_name,mycode
        FROM
            avid___affiliates
    ";
    $prepare = array(':usertype'=>'tutor');
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();


    foreach($results as $key=> $getdata){

        $sql = "
            SELECT id,email,promocode,usertype FROM avid___user WHERE promocode = :mycode
        ";
        $prepare = array(':mycode'=>$getdata->mycode);
        $mycodeusers = $app->connect->executeQuery($sql,$prepare)->fetchAll();

        if(isset($mycodeusers[0])){
            foreach($mycodeusers as $checkforsession){

                $sql = "
                    SELECT
                        sessions.id,sessions.from_user,sessions.session_status,sessions.session_cost
                    FROM
                        avid___sessions sessions



                    WHERE
                        sessions.from_user = :email
                            AND
                        sessions.session_status = 'complete'
                ";
                $prepare = array(':email'=>$checkforsession->email);
                $from_user = $app->connect->executeQuery($sql,$prepare)->fetchAll();

                if(isset($from_user[0])){
                    $results[$key]->from_user = $from_user;
                }

                $sql = "
                    SELECT id,from_user,session_status,session_cost FROM avid___sessions WHERE to_user = :email AND session_status = 'complete'
                ";
                $prepare = array(':email'=>$checkforsession->email);
                $to_user = $app->connect->executeQuery($sql,$prepare)->fetchAll();
                if(isset($to_user[0])){
                    $results[$key]->to_user = $to_user;
                }

            }
        }
        else{
            unset($results[$key]);
        }

    }

    notify($results);

    if(count($results)>0){
        $app->payaffiliates = $results;
    }

    if(isset($id)){
        $sql = "SELECT * FROM avid___affiliates WHERE id = :id";
        $prepare = array(':id'=>$id);
        $app->affiliateuser = $app->connect->executeQuery($sql,$prepare)->fetch();

            $tutorsessions = array();
            $sql = "
                SELECT
                    user.email,user.usertype,
                    sessions.id as sessionid,
                    sessions.session_status as status
                FROM
                    avid___user user

                INNER JOIN

                    avid___sessions sessions on sessions.from_user = user.email and user.usertype = 'tutor' AND user.promocode = :mycode

                GROUP BY user.email

                ORDER BY
                    user.usertype ASC
            ";
            $prepare = array(
                ':mycode'=>$app->affiliateuser->mycode
            );
            $tutorsessions = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            //notify($tutorsessions);

            $studentsessions = array();
            $sql = "
                SELECT
                    user.email,user.usertype,
                    sessions.id as sessionid,
                    sessions.session_status as status
                FROM
                    avid___user user

                INNER JOIN

                    avid___sessions sessions on sessions.to_user = user.email and user.usertype = 'student' AND user.promocode = :mycode

                GROUP BY user.email

                ORDER BY
                    user.usertype ASC
            ";
            $prepare = array(
                ':mycode'=>$app->affiliateuser->mycode
            );
            $studentsessions = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            $app->affiliateuser->everything = array_merge($studentsessions,$tutorsessions);

    }

    $app->meta = new stdClass();
    $app->meta->title = 'Pay Affiliates';
