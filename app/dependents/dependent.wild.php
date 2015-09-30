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
			'//fonts.googleapis.com/css?family=Quicksand:300,400,700',
			'//fonts.googleapis.com/css?family=Exo+2:700,400&subset=latin,cyrillic',
			'//cdnjs.cloudflare.com/ajax/libs/materialize/'.$material.'/css/materialize.min.css',
			'//fonts.googleapis.com/icon?family=Material+Icons',
			'//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'
		);
		$headjs = array(
			'https://js.stripe.com/v2',
			'//code.jquery.com/jquery-2.1.1.min.js'
		);
		$cdnjs = array(
			'//cdnjs.cloudflare.com/ajax/libs/materialize/'.$material.'/js/materialize.min.js'
		);
	}
	



	$localcss = array(
		'wild.css',
		'hiw.css',
		'material.fix.css',
		'forms.css',
		'view-user.css',
		'customize-avatar.css',
		'wild.media.css',
	);

	

	$localjs = array(
		'functions.js',
		'wild.js',
		'jquery.nouislider.min.js',
		'js.cookie.js',
		'jcrop.js',
		'sortable.js',
		'jquery.autocomplete.js',
		'time.picker.js',
		'typed.js',
		'scribblar.js',
		'highlight.js'
	);

	$app->header = new stdClass();
	$app->header->cdncss = $cdncss;
	$app->header->localcss = $localcss;
	$app->header->cdnjs = $cdnjs;
	$app->header->localjs = $localjs;
	$app->header->headjs = $headjs;
