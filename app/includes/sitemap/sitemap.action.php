<?php
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Sitemap';
	$app->meta->h1 = 'Sitemap';


		$sql = "
			SELECT
				*
			FROM
				avid___search_results

			ORDER BY text ASC
		";
		$prepare = array();
		$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		if(isset($results[0])){
			$app->searchresults = $results;
		}
