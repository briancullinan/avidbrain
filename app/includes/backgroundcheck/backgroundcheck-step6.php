<?php
    if(!empty($app->newtutor->step1) && !empty($app->newtutor->step2) && !empty($app->newtutor->step3) && !empty($app->newtutor->step4) && !empty($app->newtutor->step5)):
?>

<div class="bgcheck-step">Congratulations</div>
<div class="bgcheck-step-info"> Your background check is complete </div>

<p>We will process your background check and let you know within 7-10 working days.</p>


<?php else: ?>
    Please fill out steps 1-5 before continuing.
<?php endif; ?>
