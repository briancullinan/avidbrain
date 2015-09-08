<?php

	if(isset($dependents->offline)){
		
		$cdncss = array(
			'/offline/font-awesome.min.css',
			'/offline/materialize.min.css',
		);
		$headjs = array(
			'/offline/jquery-2.1.1.min.js'
		);
		$cdnjs = array(
			'/offline/materialize.min.js'
		);
		
	}
	else{
		$material = '0.97.0';
		$cdncss = array(
			'//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700',
			'//fonts.googleapis.com/css?family=Exo+2:700,400&subset=latin,cyrillic',
			'//cdnjs.cloudflare.com/ajax/libs/materialize/'.$material.'/css/materialize.min.css',
			'//fonts.googleapis.com/icon?family=Material+Icons',
			'//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'
		);
		$headjs = array(
			'https://code.jquery.com/jquery-2.1.1.min.js'
		);
		$cdnjs = array(
			'https://cdnjs.cloudflare.com/ajax/libs/materialize/'.$material.'/js/materialize.min.js'
		);
	}
	

	$localcss = array(
		'jquery.nouislider.min.css',
		'fonts.css',
		'everything.css',
		'everything.media.css',
		#'base.css',
		#'media.css',
		#'pages.homepage.css',
		#'crop.css',
		#'time.picker.css'
	);

	

	$localjs = array(
		'functions.js',
		#'brainscript.js',
		'javascript.js',
		'jquery.nouislider.min.js',
		'js.cookie.js',
		'jcrop.js',
		'sortable.js',
		'jquery.autocomplete.js',
		'time.picker.js'
	);

	$app->header = new stdClass();
	$app->header->cdncss = $cdncss;
	$app->header->localcss = $localcss;
	$app->header->cdnjs = $cdnjs;
	$app->header->localjs = $localjs;
	$app->header->headjs = $headjs;
