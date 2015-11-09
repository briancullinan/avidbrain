<?php

    echo "PHOTOGRAPHITI";

    /*
    <?php if(isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
        <img src="<?php echo $app->user->my_avatar; ?>" />
    <?php elseif(isset($app->user->username) && $app->user->username==$username || isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
        <img src="/image/photograph/cropped/<?php echo $app->currentuser->username; ?>" />
    <?php elseif(isset($app->currentuser->my_upload) && isset($app->currentuser->my_upload_status) && $app->currentuser->my_upload_status=='verified'): ?>
        <img src="/profiles/approved/<?php echo ; ?>" />
    <?php else: ?>
        <img class="the-avatar" src="<?php echo $app->currentuser->my_avatar; ?>" />
    <?php endif; ?>

    */
    /*
    <?php if(isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
    <?php elseif(isset($app->user->username)): ?>
        <img src="/image/photograph/cropped/<?php echo $app->user->username; ?>" />
    <?php elseif(isset($app->user->my_avatar)): ?>
        <img class="the-avatar" src="<?php echo $app->user->my_avatar; ?>" />
    <?php endif; ?>
    */
    // $photoid = NULL;
    // if(isset($usernamegiven)){
    //     $photoid = $usernamegiven;
    // }
    // if(isset($photoid) && !empty($photoid)){
    //     if(isset($usernamegiven->usertype) && $usernamegiven->usertype=='admin'){
    //         $img = '/profiles/approved/'.croppedfile($usernamegiven->username.getfiletype($usernamegiven->my_upload));
    //     }
    //     elseif(isset($app->user->username) && $app->user->username==$usernamegiven->username){
    //         $img = '/image/photograph/cropped/'.$usernamegiven->username;
    //     }
    //     elseif(isset($usernamegiven->my_upload) && isset($usernamegiven->my_upload_status) && $usernamegiven->my_upload_status=='verified'){
    //         $img = '/profiles/approved/'.croppedfile($usernamegiven->username.getfiletype($usernamegiven->my_upload));
    //     }
    //     else{
    //         $img = $usernamegiven->my_avatar;
    //     }
    // }



?>
