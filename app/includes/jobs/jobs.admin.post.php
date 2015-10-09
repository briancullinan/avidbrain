<?php

    if(isset($app->flagjob->value) && $app->flagjob->value=='flag'){
        $flag = 1;
    }
    elseif(isset($app->flagjob->value) && $app->flagjob->value=='unflag'){
        $flag = NULL;
    }

    $app->connect->update('avid___jobs',array('flag'=>$flag),array('id'=>$app->flagjob->id));

    $app->redirect($app->flagjob->page);
