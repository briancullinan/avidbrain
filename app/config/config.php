<?php

    function show($arrayOrString){
        echo '<pre>'; print_r($arrayOrString); echo '</pre>';
        exit;
    }

    $server = (object)$_SERVER;
    date_default_timezone_set('America/Phoenix');
    define('SERVERNAME',$server->SERVER_NAME);
    define('APP_PATH',str_replace('/html','/app/',$server->DOCUMENT_ROOT));
    define('DOCUMENT_ROOT',$server->DOCUMENT_ROOT.'/');
    define('SALT','4,CrHGdb}tATeGMCd9KomebEc4kz>zDQD4HEcMfBVx;g72k++y');
    define('IV',password_hash(str_shuffle(rand(0,64).uniqid()), PASSWORD_BCRYPT));

    // Website Details
    define('SITENAME','avidbrain');
    define('SITENAME_PROPPER','AvidBrain');
    define('VERSION','1.701');
    define('SYSTEM_EMAIL','donotreply@avidbrain.com');
    define('EMAIL_DOMAIN','avidbrain.com');
    define('TEMPLATE','amozek.php');

    // MAILGUN
    define('MAILGUN_DOMAIN','avidbrain.com');
    define('MAILGUN_KEY','key-78294wr0c4mlq8d0nx-bma1pugoo0zg1');
    define('MAILGUN_PUBLIC','pubkey-5nfmay4eqeewzb4mkk1qaw1xx4p7h-v9');

    // database
    define('ENGINE','mysql');
    define('PORT','3306');
    define('CHARSET','utf8');

    // TWILIO
    define('TWILIO_ID','AC0b159b382464c3e1c63f5d18fdf7ca22');
    define('TWILIO_AUTH_TOKEN','e3d65fabfe6d0e6e688ad2f9a369946a');
    define('TWILIO_NUMBER','+14803511893');

    // Scribblar
    define('SCRIBBLAR_ID', '27D1B127-9CCB-A496-810CC85CDECC42D1');

    // Pagination
    define('PERPAGE',11);

    // social
    define('socialQa','https://qa.avidbrain.com');
    define('socialFacebook','https://www.facebook.com/avidbrain');
    define('socialTwitter','https://twitter.com/avidbrain');
    define('socialLinkedin','https://www.linkedin.com/company/avidbrain/');
    define('socialPinterest','https://www.pinterest.com/avidbrain/');
    define('socialBlog','https://blog.avidbrain.com');

    if(SERVERNAME=='avidbrain.dev'){

        // DEBUG
        define('DEBUG',true);
        define('MODE','development');
        define('DOMAIN','http://avidbrain.dev');

        // STRIPE
        define('STRIPE_SECRET','sk_test_RKw0H6vV3pyB5JsBuQKXU4sO');
        define('STRIPE_PUBLIC','pk_test_jIcjo9aRNH4Xm8uaWuGZdf7B');

        // Database
        define('HOST','localhost');
        define('DBUSER','root');
        define('DBPASS','root');

        // CHECKR
        define('CHECKR_USERNAME','490604533e55e6c996bdf6db6c17dcdd8315a1d6');

    }
    else{

        // DEBUG
        define('DEBUG',false);
        define('MODE','production');
        define('DOMAIN','https://www.avidbrain.com');

        // STRIPE
        define('STRIPE_SECRET','sk_live_XUObU4RQbEVKsWq8yU5XFjJU');
        define('STRIPE_PUBLIC','pk_live_QjMUIzGXr1yqTKehZrvwXCsQ');

        // Database
        define('HOST','7b9488aeb86ce5dc0843d7298b2b70b44ddeb574.rackspaceclouddb.com');
        define('DBUSER','brainiac');
        define('DBPASS','ipi}nGaN6P4QAEJtxJ3W^Xc%Q9aforDBwnpFk}B');

        // CHECKR
        define('CHECKR_USERNAME','5a055e0454d2727daebad2a56ba51aaad0c05031');

    }


    $slimConfig = [
        'templates.path'=>APP_PATH.'views',
        'template'=>TEMPLATE,
        'debug'=>DEBUG,
        'mode'=>MODE
    ];