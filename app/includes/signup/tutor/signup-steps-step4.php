<p class="pageids" id="uploadaphoto">&nbsp;</p>

<div class="signup-title-text">
    Step 5 <span>Add A Photo</span>
</div>

<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">
            <?php if(isset($app->newtutor->cropped)): ?>
                <div class="your-cropped-photo">Your Cropped Photo</div>
                <div class="row">

                    <div class="col s12 m4 l4">
                        <a href="/signup/tutor/action/trash" class="button button-block"><i class="fa fa-trash"></i> Delete Photo</a>
                        <a href="/signup/tutor/action/crop" class="button button-block"><i class="fa fa-crop"></i> Crop Photo</a>
                        <a href="/signup/tutor/action/rotateright" class="button button-block"><i class="fa fa-rotate-right"></i> Rotate Right</a>
                        <a href="/signup/tutor/action/rotateleft" class="button button-block"><i class="fa fa-rotate-left"></i> Rotate Left</a>
                    </div>
                	<div class="col s12 m8 l8">
                		<div class="profile-image avatar"><img src="/image/tutorphotos/cropped/<?php echo $app->newtutor->id; ?>" class="responsive-img" /></div>
                	</div>
                </div>

            <?php else: ?>
                <div class="title">
                    Additional Info
                </div>
                <p>
                    Add a photo of yourself, preferably a head-shot. <span class="signup-required"><i class="fa fa-asterisk"></i></span>
                </p>

                <form enctype="multipart/form-data" action="/signup/tutor" method="post" id="upload-photo-form">
                    <input type="hidden" name="uploadphoto[width]" value="" id="containerwidth"    />
                    <input type="hidden" name="uploadphoto[target]" value="uploadphoto"  />
                    <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                    <input name="uploadphoto[file]" class="hide upload-trigger" type="file" />
                    <button class="select-item btn grey darken-1 btn-block" type="button" data-text = "Uploading Photo">
                        <i class="fa fa-upload"></i> Upload Photo
                    </button>
                </form>
            <?php endif; ?>
    	</div>
    	<div class="col s12 m6 l6">
            <div class="help-info">
                <div class="title">Help</div>
                <p>Please provide a <span class="blue-text">photo</span> of yourself. A photo is required, to ensure that we have the highest quality tutor profiles.</p>

                <p>Allowable file types: .jpg, .png, .gif</p>

                <p>A photo can speak a thousand words, make sure you're saying the right thing.</p>

                <p>Your profile will not be approved if you do not provide a quality photo of yourself.</p>

                <p>Once you photo is approved you can always go back and change it to another one.</p>

            </div>
    	</div>
    </div>
</div>
