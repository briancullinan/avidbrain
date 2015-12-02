<div class="title">Mailed Check</div>


<div>Mailing Address</div>
<p>Please enter your mailing address, so we can send you bi-monthly checks.</p>
<?php

    $getpaid = new Forms($app->connect);
    $getpaid->formname = 'cutchecks';
    $getpaid->url = '/affiliates/information';
    $getpaid->dependents = $app->dependents;
    $getpaid->csrf_key = $csrf_key;
    $getpaid->csrf_token = $csrf_token;
    if(isset($app->cutchecksinfo)){
        $getpaid->formvalues = $app->cutchecksinfo;
    }
    $getpaid->makeform();
?>
