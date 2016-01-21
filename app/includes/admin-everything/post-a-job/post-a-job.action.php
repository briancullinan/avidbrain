<?php

    $sql = "SELECT * FROM avid___jobs WHERE anonymous IS NOT NULL ORDER BY date DESC";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->postedjobs = $results;
    }

    if(isset($id)){
        $sql = "
            SELECT jobs.*, user.zipcode FROM avid___jobs jobs
                LEFT JOIN
                avid___user user on user.email = jobs.email
            WHERE
                jobs.id = :id
        ";
        //anonymous IS NOT NULL AND jobs.id = :id
        $prepare = array(':id'=>$id);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();

        if(isset($results->id)){

            $sql = "
                SELECT
                    applicants.*,
                    user.url,
                    user.first_name,
                    user.last_name,
                    user.zipcode,
                    user.phone,
                    user.city,
                    user.state,
                    profile.hourly_rate
                FROM
                    avid___jobs_applicants applicants

                INNER JOIN
                    avid___user user on user.email = applicants.email

                INNER JOIN
                    avid___user_profile profile on profile.email = user.email

                WHERE applicants.jobid = :id
            ";
    		$prepare = array(
    			':id'=>$id
    		);
    		$applicants = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            if(isset($applicants[0])){
                $results->applicants = $applicants;
            }

            $app->thejob = $results;
            //printer($app->thejob);
        }
    }

    $app->meta = new stdClass();
    $app->meta->title = 'Post a craigslist job';
