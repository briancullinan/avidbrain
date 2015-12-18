<?php

    if(isset($app->url)){

        $sql = "
            SELECT
                email
            FROM
                avid___user user
            WHERE
                user.url = :url
                    AND
                user.usertype = 'tutor'
        ";
        $prepare = array(':url'=>$app->url);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();

        $return = array();

        if(isset($results->email)){
            $email = $results->email;

            $sql = "
                SELECT
                    floor((sum(sessions.session_length)/60)) as sum
                FROM
                    avid___sessions sessions
                WHERE
                    sessions.from_user = :email
                        AND
                    sessions.session_length IS NOT NULL
            ";

            $prepare = array(':email'=>$email);
            $results = $app->connect->executeQuery($sql,$prepare)->fetch();
            if(empty($results->sum)){
                $results->sum = 0;
            }

            if(isset($results->sum) && !empty($results->sum)){
                $return['hourstutors'] = batter_badges('hours-tutors','mdi-action-alarm',$results->sum.'+ Hours Tutored');
            }

            $badge_type = badge_type($results->sum,1);
            $return['tutorrank'] = batter_badges('tutor-rank '.$badge_type->class,$badge_type->icon,$badge_type->rank);

            $sql = "
                SELECT
                    count(sessions.review_score) as count
                FROM
                    avid___sessions sessions
                WHERE
                    sessions.from_user = :email
                        AND
                    sessions.review_score IS NOT NULL
            ";

            $prepare = array(':email'=>$email);
            $results = $app->connect->executeQuery($sql,$prepare)->fetch();
            if(isset($results->count) && !empty($results->count)){
                $plural=NULL;
                if($results->count!=1){
                    $plural = 's';
                }
                $return['totalreviews'] = batter_badges('total-reviews','mdi-action-speaker-notes',$results->count.' Review'.$plural);
            }


            $sql = "
                SELECT
                    count(sessions.to_user) as student_count
                FROM
                    avid___sessions sessions
                WHERE
                    sessions.from_user = :email
                GROUP BY
                    sessions.to_user
            ";
            $prepare = array(':email'=>$email);
            $results = $app->connect->executeQuery($sql,$prepare)->fetch();
            if(isset($results->student_count) && !empty($results->student_count)){
                $plural=NULL;
                if($results->student_count!=1){
                    $plural = 's';
                }
                $return['totalstudents'] = batter_badges('total-students','fa fa-user',$results->student_count.' Student'.$plural);
            }

            notify($return);
        }

    }
