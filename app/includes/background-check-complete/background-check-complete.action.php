<?php

    if(isset($app->user->bgcheckstatus) && $app->user->bgcheckstatus=='clear'){
        $app->connect->delete('avid___new_temps',array('email'=>$app->user->email));
        $app->connect->update('avid___user',array('emptybgcheck'=>NULL),array('email'=>$app->user->email));
        $app->congrats = true;
    }




    if(empty($app->congrats)){
        $app->redirect('/');
    }


    $app->meta = new stdClass();
    $app->meta->title = 'Background Check Passed';
