<?php
    if(isset($app->message)){
        include('view-the-message.php');
    }
    else{
        echo 'No Message Found';
    }
?>
