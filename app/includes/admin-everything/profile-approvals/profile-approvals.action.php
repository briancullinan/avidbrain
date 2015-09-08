<?php
	
	$sql = "SELECT * FROM avid___user_needsprofilereview WHERE usertype = :usertype GROUP BY `email` ORDER BY id DESC";
	$prepeare = array(':usertype'=>'tutor');
	$app->tutorrequests = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	
	$sql = "SELECT * FROM avid___user_needsprofilereview WHERE usertype = :usertype GROUP BY `email` ORDER BY id DESC";
	$prepeare = array(':usertype'=>'student');
	$app->studentrequests = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

