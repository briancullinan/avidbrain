<?php
    if(isset($app->searching)){
        include(APP_PATH.'includes/searching/searching-includer.php');
    }
    else{
        include(APP_PATH.'includes/searching/lonely-searchbox.php');
    }
?>
