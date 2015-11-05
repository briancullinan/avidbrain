<?php

    if($location=='tutorphotos'){
        $sql = "SELECT upload FROM avid___new_temps WHERE id = :id";
        $prepare = array(':id'=>$id);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->upload)){
            $upload = $results->upload;
        }
    }
    if(isset($extras) && $extras=='cropped'){
        $upload = croppedfile($upload);
    }

    if(isset($upload)){
        $path = $app->dependents->APP_PATH.'uploads/'.$location.'/'.$upload;
        $img = $app->imagemanager->make($path);
        header('Content-Type: image/png');
        echo $img->response();
        exit;
    }
