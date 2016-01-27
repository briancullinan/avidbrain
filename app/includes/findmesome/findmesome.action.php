<?php
    //$query = $app->request->get('query');

    $queryString = $app->request->get('query');
    $cachedKey = 'cachedQueryName---'.$queryString;




    $cachedResults = $app->connect->cache->get($cachedKey);
    if($cachedResults == null){
        $sql = "
            SELECT
                *
            FROM
                avid___available_subjects subjects
            WHERE
                CONCAT(subjects.subject_parent,' ',subjects.subject_name,' ',subjects.subject_slug,' ',subjects.parent_slug) LIKE :searchSubject

            GROUP BY subjects.subject_slug
        ";

        $prepare = array(':searchSubject'=>"%$queryString%");
        $cachedResults = $app->connect->executeQuery($sql,$prepare)->fetchAll();
        $app->connect->cache->set($cachedKey, $cachedResults, 3600);
    }

    //notify($cachedResults);

    $suggestions = [];
    if(!empty($cachedResults)){
        foreach($cachedResults as $suggestme){
            $suggestions[] = array('value'=>$suggestme->subject_name,'data'=>$suggestme->subject_slug);
        }
    }

    //notify($suggestions);

    #$suggestions = [];
    #$suggestions[] = array('value'=>'ninja','data'=>'buffalo');


    $response = array(
		'query'=>'Unit',
		'suggestions'=>$suggestions
	);

    echo json_encode($response);
	exit;



	// if(isset($query) && !empty($query)){
	// 	$query = $query;
	// }
	// else{
	// 	$query = $app->request->get('query');
	// }
	//
	//
	// $queryKey = "queryname---".$query;
	// $queryVariables = $app->connect->cache->get($queryKey);
	// if($queryVariables == null) {
	// 	$sql = "SELECT id,subject_name, subject_slug, parent_slug FROM avid___available_subjects WHERE subject_name LIKE :subject_name GROUP BY subject_name LIMIT 30";
	// 	$prepeare = array(':subject_name'=>"%".$query."%");
	// 	$results = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	//     $queryVariables = $results;
	//     $app->connect->cache->set($queryKey, $results, 3600);
	// }
	//
	// $results = $queryVariables;
	//
	// $suggestions = array();
	//
	// if(isset($results[0])){
	// 	foreach($results as $key=> $items){
	// 		$suggestions[$key]['value'] = $items->subject_name;
	// 		$suggestions[$key]['data'] = $items;
	// 	}
	// }
	//
	// $response = array(
	// 	'query'=>'Unit',
	// 	'suggestions'=>$suggestions
	// );
	//
	//
	// echo json_encode($response);
	// exit;
