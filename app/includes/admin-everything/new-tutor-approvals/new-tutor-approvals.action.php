<?php

    $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE complete IS NULL ORDER BY ID DESC ";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->everyoneelse = $results;
    }

    $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE complete IS NOT NULL AND  activated IS NULL AND approval_status IS NULL ORDER BY id ASC";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->newtutors = $results;
    }

    $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE  approval_status = 'approved' ORDER BY id DESC";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->approvedtutors = $results;
    }

    $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE complete IS NOT NULL AND  activated IS NULL AND approval_status = 'rejected' ORDER BY id ASC";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->rejectedtutors = $results;
    }

    if(isset($id)){
        $sql = "SELECT temps.*,user.url,comp.id as comper FROM avid___new_temps temps

        LEFT JOIN

        avid___user user on user.email = temps.email

        LEFT JOIN

        avid___compedbgcheck comp on comp.email = temps.email

        WHERE temps.id = :id ";



        $prepare = array(':id'=>$id);
        $app->thetutor = $app->connect->executeQuery($sql,$prepare)->fetch();

        //notify('snakes');
    }


    if(isset($action)){

        $file = $app->dependents->APP_PATH.'uploads/resumes/'.$app->thetutor->my_resume;
        header('Content-type:'. mime_content_type($file));
        header('Content-Disposition: inline; filename="thefile.'.getfiletype($file).'"');
        @readfile($file);
        exit;
    }
