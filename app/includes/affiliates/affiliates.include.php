<h1>affiliate page</h1>

<?php
    if(isset($app->user->settings()->affiliateprogram) && $app->user->settings()->affiliateprogram == 'yes'){
        echo 'okgood';
    }
    else{
        echo 'okbad';
    }
?>
