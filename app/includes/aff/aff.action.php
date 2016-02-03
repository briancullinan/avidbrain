<?php

    if(isset($trackingid)){

        $app->setCookie('promocode',$trackingid, '2 days');
        $app->redirect('/signup');
        //notify($_COOKIE);

    }
