<?php // Empty Action

    if(isset($category) && $category=='crop-photo' && isset($subject)){
        $app->imgwidth = $subject;
    }
