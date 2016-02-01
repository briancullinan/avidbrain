<?php

$limit = 100;

$sql = "
    SELECT
        subjects.subject_slug,
        subjects.parent_slug,
        subjects.subject_name,
        count(subject_slug) as count
    FROM
        avid___user_subjects subjects

    GROUP BY subjects.subject_slug

    ORDER BY count DESC

    LIMIT $limit
";
$prepare = array(

);


$cachedKey = "toptutoredsubjects--".$limit."limit";
$results = $app->connect->cache->get($cachedKey);
if($results == null) {
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    $app->connect->cache->set($cachedKey, $results, 3600);
}

if(isset($results[0])){
    $app->top = $results;
}
