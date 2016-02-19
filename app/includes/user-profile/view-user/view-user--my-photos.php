<h4>Your Photo</h4>

<div class="center-align"><img src="<?php echo userphotographs($app->user,$app->actualuser); ?>" class="responsive-img" /></div>



<?php if(!empty($app->actualuser->my_upload)): ?>
    <form method="post" class="center-align" action="<?php echo $app->actualuser->url; ?>" id="myphoto">

        <?php if(isset($app->adminnow)): ?>
            <?php if($app->actualuser->my_upload_status=='verified'): ?>
                <button type="button" class="button confirm-submit" data-name="myphoto" data-value="reject"><i class="fa fa-ban"></i> Reject Photo </button>
            <?php else: ?>
                <button type="button" class="button confirm-submit" data-name="myphoto" data-value="approve"><i class="fa fa-check"></i> Approve Photo </button>
            <?php endif; ?>


        <?php endif; ?>
        <button type="button" class="button confirm-submit" data-name="myphoto" data-value="crop"><i class="fa fa-crop"></i> Crop Photo</button>
        <button type="button" class="button confirm-submit" data-name="myphoto" data-value="delete"><i class="fa fa-trash"></i> Delete Photo</button>
        <button type="button" class="button confirm-submit" data-name="myphoto" data-value="rotate-right"><i class="fa fa-rotate-right"></i> Rotate Right</button>
        <button type="button" class="button confirm-submit" data-name="myphoto" data-value="rotate-left"><i class="fa fa-rotate-left"></i> Rotate Left</button>

        <input type="hidden" name="myphoto[target]" value="myphoto"  />
        <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
    </form>
<?php else: ?>
    <form class="center-align" enctype="multipart/form-data" action="<?php echo $app->actualuser->url; ?>" method="post" id="upload-photo-form">
        <input type="hidden" name="upload[width]" value="200" id="pagewidth"  />
        <input type="hidden" name="upload[target]" value="upload"  />
        <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
        <input name="upload[file]" class="hide upload-trigger" type="file" />
        <button class="select-item btn grey darken-1" type="button" data-text = "Uploading Photo">
            <i class="fa fa-upload"></i> Upload Photo
        </button>
    </form>
<?php endif; ?>

<br><br>

<h4>Available Avatars</h4>
<form method="post" action="<?php echo $app->currentuser->url; ?>" id="myavatar">
    <div class="row">
        <?php foreach(get_avatars(DOCUMENT_ROOT) as $avatars): ?>
            <div class="col s6 m4 l4 avatar-clicks <?php if(isset($app->actualuser->my_avatar) && $app->actualuser->my_avatar==$avatars){ echo ' activeAvatar ';} ?>">
                <label>
                    <img class="responsive-img circle" src="<?php echo $avatars; ?>" />
                    <input <?php if(isset($app->actualuser->my_avatar) && $app->actualuser->my_avatar==$avatars){ echo 'checked="checked"';} ?> type="radio" name="myavatar[name]" value="<?php echo $avatars; ?>" />
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" name="myavatar[target]" value="myavatar"  />
    <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
</form>
