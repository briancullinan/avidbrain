<?php
	foreach(range(0,100) as $insert){
		$random = random_all(8);
		$sql = "SELECT promocode FROM avid___promotions WHERE promocode = :promocode";
		$prepare = array(':promocode'=>$random);
		$results = $app->connect->executeQuery($sql,$prepare)->rowCount();
		
		$value = array(20,20,20,20,20,20,20,30,30,30,40,40,50);
		shuffle($value);
		$value = $value[0];
		
		
		if($results==0){
			$app->connect->insert('avid___promotions',array('promocode'=>$random,'value'=>$value));
		}
	}
	echo 'done';
	exit;
?>