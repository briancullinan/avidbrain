<h2>Change Password</h2>

<?php
    $thelogin = new Forms($app->connect);
    $thelogin->formname = 'changepassword';
    $thelogin->url = $app->request->getPath();
    $thelogin->dependents = $app->dependents;
    $thelogin->csrf_key = $csrf_key;
    $thelogin->csrf_token = $csrf_token;
    $thelogin->makeform();
?>
