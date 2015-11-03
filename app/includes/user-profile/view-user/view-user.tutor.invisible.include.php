<div class="private-profile">

    <div class="profile-image center-align avatar">
        <div class="hidden-avatar">
            <?php $app->currentuser->dontshow = 1; echo show_avatar($app->currentuser,$app->user,$app->dependents); ?>
        </div>
    </div>

    <a class="modal-trigger btn btn-l red" href="#loginModule">This profile is set to private. Please login to view full profile.</a>
</div>
