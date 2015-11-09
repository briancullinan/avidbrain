<?php

    define('PHOTOS',$app->dependents->APP_PATH.'uploads/photos/');
    define('APPROVED',$app->dependents->DOCUMENT_ROOT.'profiles/approved/');
    define('AVATAR',$app->dependents->DOCUMENT_ROOT);

    if(isset($app->user->username) && $app->user->username==$id || isset($app->user->usertype) && $app->user->usertype=='admin'){
        if($location=='photograph'){
            $sql = "
                SELECT user.username,user.id,user.email,profile.my_upload,profile.my_upload_status,profile.my_avatar FROM avid___user user
                INNER JOIN avid___user_profile profile on profile.email = user.email
                WHERE username = :username
            ";
            $prepare = array(':username'=>$id);
            $results = $app->connect->executeQuery($sql,$prepare)->fetch();
            if(isset($results->my_upload)){
                $upload = PHOTOS.$results->my_upload;
                $filetype = getfiletype($upload);
                $approved = APPROVED.$results->username.$filetype;
            }
            else{
                $extras = NULL;
                $upload = AVATAR.$results->my_avatar;
            }
        }
    }

    if($location=='tutorphotos'){
        $sql = "SELECT upload FROM avid___new_temps WHERE id = :id";
        $prepare = array(':id'=>$id);
        $results = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(isset($results->upload)){
            $upload = PHOTOS.$results->upload;
        }
    }

    if(empty($upload)){
        notify('UH OH!');
    }

    if(isset($extras) && $extras=='cropped'){
        $upload = croppedfile($upload);
    }

    if(!file_exists($upload)){
        $upload = AVATAR.'profiles/avatars/default-avatar.png';
    }

    if(isset($upload)){
        $img = $app->imagemanager->make($upload);
        header('Content-Type: image/png');
        echo $img->response();
        exit;
    }
