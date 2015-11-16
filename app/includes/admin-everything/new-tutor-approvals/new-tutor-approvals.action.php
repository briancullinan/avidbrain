<?php

    $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE complete IS NOT NULL AND  activated IS NULL AND approval_status IS NULL ORDER BY id ASC";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->newtutors = $results;
    }

    $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE  approval_status = 'approved' ORDER BY id ASC";
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
        $sql = "SELECT * FROM avid___new_temps WHERE id = :id AND complete IS NOT NULL";
        $prepare = array(':id'=>$id);
        $app->thetutor = $app->connect->executeQuery($sql,$prepare)->fetch();
    }
