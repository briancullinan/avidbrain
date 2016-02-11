<?php

	if(isset($dependents->offline)){

		$cdncss = array(
			'/offline/font-awesome.min.css',
			'/offline/materialize.min.css',
		);
		$headjs = array(
			'https://js.stripe.com/v2',
			'/offline/jquery-2.1.1.min.js'
		);
		$cdnjs = array(
			'/offline/materialize.min.js'
		);

	}
	else{
		$material = '0.97.1';
		$cdncss = array(
			'//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700|Quicksand:300,400,700|Exo+2:700,400|Material+Icons',
			//'//cdnjs.cloudflare.com/ajax/libs/materialize/'.$material.'/css/materialize.min.css',
			//'//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'
		);
		$headjs = array(
			'/js/jquery-2.1.1.min.js',
			'https://js.stripe.com/v2',
			//'//code.jquery.com/jquery-2.1.1.min.js'
		);
		$cdnjs = array(
			//'//cdnjs.cloudflare.com/ajax/libs/materialize/'.$material.'/js/materialize.min.js'
		);
	}

	$localcss = array(
		'materialize.min.css',
		'font-awesome.min.css',
		'wild.css',
		'wild.core.css',
		'wild.homepage.css',
		'material.fix.css',
		'jquery.nouislider.min.css',
		'forms.css',
		'view-user.css',
		'sessions-messages.css',
		'subs.css',
		'searching.css',
		'newjob.css',
		'customize-avatar.css',
		'crop.css',
		'wild.media.css',
		'time.picker.css',
		'shepherd-theme-arrows.css',
		'newstyles.css'

	);

	$localjs = array();
	$localjs[] = 'tether.min.js';
	$localjs[] = 'shepherd.js';
	if($dependents->DOMAIN=='http://avidbrain.dev'){
		$localjs['wild'] = 'wild.functions.js';
	}
	else{
		$localjs['production'] = 'production.functions.js';
	}
	$localjs[] = 'functions.js';
	$localjs[] = 'js.cookie.js';
	$localjs[] = 'mustache.js';
	$localjs[] = 'searching.js';
	$localjs[] = 'wild.js';
	$localjs[] = 'jquery.nouislider.min.js';
	$localjs[] = 'jcrop.js';
	$localjs[] = 'sortable.js';
	$localjs[] = 'jquery.autocomplete.js';
	$localjs[] = 'time.picker.js';
	$localjs[] = 'typed.js';
	$localjs[] = 'scribblar.js';
	$localjs[] = 'highlight.js';
	$localjs[] = 'materialize.min.js';

	$app->header = new stdClass();
	$app->header->cdncss = $cdncss;
	$app->header->localcss = $localcss;
	$app->header->cdnjs = $cdnjs;
	$app->header->localjs = $localjs;
	$app->header->headjs = $headjs;
