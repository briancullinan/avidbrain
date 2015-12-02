<?php

    $app->meta = new stdClass();
    $app->meta->title = 'Affiliate Login';
    

    if(isset($code)){
        $sql = "SELECT * FROM avid___affiliates WHERE validation_code = :validation_code";
        $prepare = array(':validation_code'=>$code);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->id)){
            $app->connect->update('avid___affiliates',array('active'=>1,'validation_code'=>NULL),array('email'=>$results->email));
            $app->affiliatesetup = true;
        }
        else{
            $app->redirect('/signup/affiliate');
        }
    }
