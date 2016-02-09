<?php
    if(isset($app->searching)){
        include($app->dependents->APP_PATH.'includes/searching/searching-includer.php');
    }
    else{
        include($app->dependents->APP_PATH.'includes/searching/lonely-searchbox.php');
    }
?>
