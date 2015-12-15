<?php

if(isset($query) && !empty($query)){
	$query = $query;
}
else{
	$query = $app->request->get('query');
}


$queryKey = "queryname---".$query;
$queryVariables = $app->connect->cache->get($queryKey);
if($queryVariables == null) {
	$sql = "SELECT id,subject_name, subject_slug, parent_slug FROM avid___available_subjects WHERE subject_name LIKE :subject_name GROUP BY subject_name LIMIT 30";
	$prepeare = array(':subject_name'=>"%".$query."%");
	$results = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
    $queryVariables = $results;
    $app->connect->cache->set($queryKey, $results, 3600);
}

$results = $queryVariables;

$suggestions = array();

if(isset($results[0])){
	foreach($results as $key=> $items){
		$suggestions[$key]['value'] = $items->subject_name;
		$suggestions[$key]['data'] = $items;
	}
}

$response = array(
	'query'=>'Unit',
	'suggestions'=>$suggestions
);


echo json_encode($response);
exit;
