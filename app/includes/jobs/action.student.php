<?php
    // ACTION CALLS

    $sql = "
        SELECT
            *
        FROM
            avid___jobs jobs
        WHERE
            email = :email
    ";
    $prepare = array(':email'=>$app->user->email);
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->myJobs = $results;
    }


    $jobOptions = array();
    $jobOptions['type'] = (object)array(
        'No Preference'=>'both',
        'Online'=>'online',
        'In Person'=>'offline'
    );
    $jobOptions['skill_level'] = (object)array(
        'Novice','Advanced Beginner','Competent','Proficient','Expert'
    );
    $app->jobOptions = $jobOptions;
