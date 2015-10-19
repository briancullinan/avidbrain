<?php

    $cachedKey = "find-a-subject---".$subject;
    $cachedVar = $app->connect->cache->get($cachedKey);
    if($cachedVar == null) {
        $sql = "SELECT * FROM avid___available_subjects WHERE subject_slug LIKE :subject_slug LIMIT 1";
        $prepare = array(':subject_slug'=>"%$subject%");
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->id)){
            $redirect = '/categories/'.$results->parent_slug.'/'.$results->subject_slug;
        }
        else{
            $redirect = '/tutors';
        }

        $cachedVar = $redirect;
        $app->connect->cache->set($cachedKey, $redirect, 3600);
    }

    $app->redirect($cachedVar);
