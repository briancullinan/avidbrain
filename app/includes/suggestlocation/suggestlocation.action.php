<?php

    $queryString = $app->request->get('query');
    $cachedKey = 'cachedlocation---'.$queryString;

    $cachedResults = $app->connect->cache->get($cachedKey);
    if($cachedResults == null){
        $sql = "
            SELECT
                CONCAT(location.city,', ',location.state_long) as location,
                zipcode,
                city,
                state_long
            FROM
                avid___location_data location
            WHERE
                CONCAT(location.city,' ',location.state,' ',location.state_long,' ',location.zipcode) LIKE :location
            GROUP BY location.state

            ORDER BY state ASC

        ";

        $prepare = array(':location'=>"%$queryString%");
        $cachedResults = $app->connect->executeQuery($sql,$prepare)->fetchAll();
        $app->connect->cache->set($cachedKey, $cachedResults, 3600);
    }

    $suggestions = [];
    if(!empty($cachedResults)){
        foreach($cachedResults as $suggestme){
            $suggestions[] = array('value'=>$suggestme->location,'data'=>$suggestme->zipcode);
        }
    }


    $response = array(
		'query'=>'Unit',
		'suggestions'=>$suggestions
	);

    echo json_encode($response);
	exit;
