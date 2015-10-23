<?php

    $sql = "SELECT * FROM avid___jobs WHERE anonymous IS NOT NULL ORDER BY date DESC";
    $prepare = array();
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($results[0])){
        $app->postedjobs = $results;
    }

    if(isset($id)){
        $sql = "SELECT * FROM avid___jobs WHERE anonymous IS NOT NULL AND id = :id";
        $prepare = array(':id'=>$id);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->id)){
            $app->thejob = $results;
        }
    }

    $app->meta = new stdClass();
    $app->meta->title = 'Post a craigslist job';
