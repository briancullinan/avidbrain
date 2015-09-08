<?php
	$sql = "SELECT * FROM avid___sessions WHERE contest_dispute IS NOT NULL";
	$prepeare = array();
	$contest_dispute = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	if(isset($contest_dispute[0])){
		$app->contest_dispute = $contest_dispute;
	}
