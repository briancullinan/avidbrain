<?php
use MatthiasMullie\Minify;
if(in_array('wild.functions.js', $app->header->localjs)){
    $app->header->localjs['wild'] = 'production.functions.js';
}


// Remove Old File
$oldFile = DOCUMENT_ROOT;
$oldFileCSS = glob($oldFile.'css/final.*.*');
$oldFileJS = glob($oldFile.'js/final.*.*');
$remove = array_merge($oldFileCSS,$oldFileJS);
foreach($remove as $file){
    if(file_exists($file)){
        unlink($file);
    }
}

$minifier = new Minify\CSS();
foreach($app->header->localcss as $cssfile){
    $minifier->add(DOCUMENT_ROOT.'css/'.$cssfile);
}
$minifier->minify(DOCUMENT_ROOT.'css/final.'.VERSION.'.css');

$minifier = new Minify\JS();
foreach($app->header->localjs as $jsfiles){
    $minifier->add(DOCUMENT_ROOT.'js/'.$jsfiles);
}
$minifier->minify(DOCUMENT_ROOT.'js/final.'.VERSION.'.js');
notify('ALL DONE');
exit;
