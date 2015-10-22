<?php

function printer($data,$exit=false){
	echo '<pre>'; print_r($data); echo '</pre>';
	if($exit){
		exit;
	}
}

    $location = '/var/www/avidbrain.com/resources/livebackup.sh';

    //printer($location);

    $test1 = file_get_contents($location);
    echo shell_exec($test1);

    $test2 = exec('bash '.$location);
	printer($test2);


    $test3 =  shell_exec("sh ".$location) or die("bash didn't work");
	printer($test3);

?>
