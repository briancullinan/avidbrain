<?php
	
	if($app->request->isXhr()==true){

		$query = $app->request->get('query');

		$sql = "SELECT id,subject_name, subject_slug, parent_slug FROM avid___available_subjects WHERE subject_name LIKE :subject_name GROUP BY subject_name";
		$prepeare = array(':subject_name'=>"%".$query."%");
		$results = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

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

	}
