<?php
	
	$app->meta = new stdClass();
	$app->meta->title = SITENAME_PROPPER." FAQ's";
	
	$sql = "SELECT * FROM avid___help_faqs WHERE section = :url ORDER BY `sortorder` ASC";
	$prepeare = array(':url'=>'general');
	$app->general = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	
	$sql = "SELECT * FROM avid___help_faqs WHERE section = :url ORDER BY `sortorder` ASC";
	$prepeare = array(':url'=>'students');
	$app->students = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	
	$sql = "SELECT * FROM avid___help_faqs WHERE section = :url ORDER BY `sortorder` ASC";
	$prepeare = array(':url'=>'tutors');
	$app->tutors = $app->connect->executeQuery($sql,$prepeare)->fetchAll();