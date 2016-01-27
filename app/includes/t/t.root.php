<?php

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

    LIMIT 30
";
$prepare = array(

);


$cachedKey = "toptutoredsubjects--30limit";
$results = $app->connect->cache->get($cachedKey);
if($results == null) {
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    $app->connect->cache->set($cachedKey, $results, 3600);
}

$random = $results;
shuffle($random);
$random = $random[0];
