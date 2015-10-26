<div class="private-profile">

    <h1><?php
        if(isset($app->currentuser->settings) && $app->currentuser->settings->showfullname=='yes'){
            echo $app->currentuser->first_name.' '.$app->currentuser->last_name;
        }
        else{
            echo short($app->currentuser);
        }

    ?></h1>

    <div class="profile-image center-align avatar">
        <div class="hidden-avatar">
            <?php $app->currentuser->dontshow = 1; echo show_avatar($app->currentuser,$app->user,$app->dependents); ?>
        </div>
    </div>

    <a class="modal-trigger btn btn-l red" href="#loginModule">This profile is set to private. Please login to view full profile.</a>
</div>
