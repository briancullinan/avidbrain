<?php

    $cachedKey = "cachedsitemapresults";
    $cachedVar = $app->connect->cache->get($cachedKey);
    if($cachedVar == null) {

        $sql = "
            SELECT
                *
            FROM
                avid___search_results


        ";
        $prepare = array();
        $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();

        $cachedVar = $results;
        $app->connect->cache->set($cachedKey, $results, 3600);
    }

    if(!empty($cachedVar)){
        $app->top = $cachedVar;
    }

    $app->meta = new stdClass();
    $app->meta->title = 'Looking for a tutor? Find an Online or In-Person Tutor @ MindSpree';
    $app->meta->h1 = false;
