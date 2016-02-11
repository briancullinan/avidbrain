<?php
    $thelogin = new Forms($app->connect);
    $thelogin->formname = 'login';
    $thelogin->url = '/login/affiliates';
    $thelogin->csrf_key = $csrf_key;
    $thelogin->csrf_token = $csrf_token;
    $thelogin->button = 'Login';
    $thelogin->makeform();
?>
