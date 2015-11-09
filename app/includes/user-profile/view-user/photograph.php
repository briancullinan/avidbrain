<?php if(isset($app->user->username) && $app->user->username==$username || isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
    <img src="/image/photograph/cropped/<?php echo $app->currentuser->username; ?>" />
<?php elseif(isset($app->currentuser->my_upload) && isset($app->currentuser->my_upload_status) && $app->currentuser->my_upload_status=='verified'): ?>
    <img src="/profiles/approved/<?php echo croppedfile($app->currentuser->username.getfiletype($app->currentuser->my_upload)); ?>" />
<?php else: ?>
    <img class="the-avatar" src="<?php echo $app->currentuser->my_avatar; ?>" />
<?php endif; ?>
