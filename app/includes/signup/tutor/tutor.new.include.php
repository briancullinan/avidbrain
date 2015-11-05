<h1>Welcome Back <span><?php echo $app->newtutor->first_name.' '.$app->newtutor->last_name; ?></span></h1>
<p>Thank you for signing up to become a tutor with AvidBrain. We have recently updated the signup process to be easier and words go here.</p>

<p>Now that we've got the easy stuff out of the way, lets proceed on to the next couple steps.</p>

<?php
    function isitset($var=NULL){
        if(isset($var) && !empty($var)){
            return $var;
        }
    }
?>

<div class="row">
	<div class="col s12 m6 l4">

        <div class="block">
            <div class="title">
                About Yourself
            </div>

            <form method="post" class="form-post auto-magic" action="/signup/tutor" id="aboutme">
                <div class="new-inputs">
                    <label>Your Zip Code</label>
                    <div class="input-wrapper" id="aboutme_zipcode"><input type="text" name="aboutme[zipcode]" placeholder="Your Zip Code" maxlength="5" <?php echo 'value="'.isitset($app->newtutor->zipcode).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>Write a short description about yourself</label>
                    <div class="input-wrapper" id="aboutme_short_description"><input type="text" name="aboutme[short_description]" placeholder="Write a short description about yourself" <?php echo 'value="'.isitset($app->newtutor->short_description).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>Write an in-depth description about yourself</label>
                    <div class="input-wrapper" id="aboutme_personal_statement"><textarea class="materialize-textarea" name="aboutme[personal_statement]" placeholder="Write an in-depth description about yourself and why / what you tutor"><?php echo isitset($app->newtutor->personal_statement); ?></textarea></div>
                </div>

                <div class="new-inputs">
                    <label>What is your gender?</label>
                    <div class="input-wrapper-select" id="aboutme_gender">
                        <select name="aboutme[gender]" class="browser-default">
                            <?php
                                $gender = isitset($app->newtutor->gender);

                                foreach(array(NULL=>"Don't Show My Gender",'male'=>'Male','female'=>'Female') as $key => $value){
                                    $activate = NULL;
                                    if(isset($gender) && $gender==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';//isitset($app->newtutor->hourly_rate)
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="aboutme[target]" value="aboutme"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>

        </div>
	</div>

    <div class="col s12 m6 l4">

        <div class="block">
            <div class="title">
                Tutoring Information
            </div>

            <form method="post" class="form-post auto-magic" action="/signup/tutor" id="tutoringinfo">

                <div class="new-inputs">
                    <label>What is your hourly rate?</label>
                    <div class="input-wrapper" id="aboutme_hourly_rate"><input type="text" name="tutoringinfo[hourly_rate]" placeholder="What is your hourly rate?" <?php echo 'value="'.isitset($app->newtutor->hourly_rate).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>How far are you willing to travel?</label>
                    <div class="input-wrapper-select" id="tutoringinfo_travel_distance">
                        <select name="tutoringinfo[travel_distance]" class="browser-default">
                            <?php
                                $travel_distance = isitset($app->newtutor->travel_distance);
                                foreach(array(0,5,10,20,25,50,100) as $key => $value){
                                    $activate = NULL;
                                    if(isset($travel_distance) && $travel_distance==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.' Miles</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <label>Do you tutor: online, in-person or both?</label>
                    <div class="input-wrapper-select" id="tutoringinfo_online_tutor">
                        <select name="tutoringinfo[online_tutor]" class="browser-default">
                            <?php
                                $online_tutor = isitset($app->newtutor->online_tutor);
                                foreach(array('online'=>'Online','offline'=>'In-Person','both'=>'Both') as $key => $value){
                                    $activate = NULL;
                                    if(isset($online_tutor) && $online_tutor==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <label>How long is your cancelation policy?</label>
                    <div class="input-wrapper-select" id="tutoringinfo_cancellation_policy">
                        <select name="tutoringinfo[cancellation_policy]" class="browser-default">
                            <?php
                                $cancellation_policy = isitset($app->newtutor->cancellation_policy);
                                foreach(array(''=>'No Cancelation Policy',1=>'1 Hour',2=>'2 Hours',6=>'6 Hours',12=>'12 Hours',24=>'24 Hours') as $key => $value){
                                    $activate = NULL;
                                    if(isset($cancellation_policy) && $cancellation_policy==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <label>What is your cancelation rate?</label>
                    <div class="input-wrapper-select" id="tutoringinfo_cancellation_rate">
                        <select name="tutoringinfo[cancellation_rate]" class="browser-default">
                            <?php
                                $cancellation_rate = isitset($app->newtutor->cancellation_rate);
                                foreach(array(NULL=>'No Cancelation Rate',10=>'$10.00',20=>'$20.00',30=>'$30.00',40=>'$40.00',50=>'$50.00') as $key => $value){
                                    $activate = NULL;
                                    if(isset($cancellation_rate) && $cancellation_rate==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <label>Please provide 3 References (Emails, or Phone Numbers)</label>
                    <div class="input-wrapper" id="tutoringinfo_references"><textarea class="materialize-textarea" name="tutoringinfo[references]" placeholder="Please provide 3 References"><?php echo isitset($app->newtutor->references); ?></textarea></div>
                </div>

                <input type="hidden" name="tutoringinfo[target]" value="tutoringinfo"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>

        </div>
	</div>

    <div class="col s12 m6 l4">

        <div class="block">
            <?php if(isset($app->newtutor->cropped)): ?>
                <div class="your-cropped-photo">Your Cropped Photo</div>
                <div class="row">
                	<div class="col s12 m12 l12">
                		<div class="profile-image avatar"><img src="/image/tutorphotos/<?php echo $app->newtutor->id; ?>/cropped" class="responsive-img" /></div>
                	</div>
                </div>

                <a href="/signup/tutor/action/trash" class="button button-block"><i class="fa fa-trash"></i> Delete Photo</a>
                <a href="/signup/tutor/action/crop" class="button button-block"><i class="fa fa-crop"></i> Crop Photo</a>
                <a href="/signup/tutor/action/rotateright" class="button button-block"><i class="fa fa-rotate-right"></i> Rotate Right</a>
                <a href="/signup/tutor/action/rotateleft" class="button button-block"><i class="fa fa-rotate-left"></i> Rotate Left</a>

            <?php else: ?>
                <div class="title">
                    Additional Info
                </div>
                <p>
                    Add a photo of yourself, preferably a head-shot.
                </p>
                <form enctype="multipart/form-data" action="/signup/tutor" method="post" id="upload-photo-form">
        			<input type="hidden" name="uploadphoto[width]" value="" id="containerwidth"    />
        			<input type="hidden" name="uploadphoto[target]" value="upload"  />
        			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
        			<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
        			<input name="uploadphoto[file]" class="hide" id="upload-trigger" type="file" />
        			<button id="select-photo" class="btn grey darken-1 btn-block" type="button">
        				<i class="fa fa-upload"></i> Upload Photo
        			</button>
        		</form>
            <?php endif; ?>

        </div>
	</div>

</div>

<div class="block">
    <div class="title">Subjects I Tutor</div>
    <?php
        if(isset($action)){
            $fixname = str_replace('-','',$action);
            $name = NULL;
            $name = 'mysubs_'.$fixname;
            $name = $app->newtutor->$name;
            if(!empty($name)){
                $myvals = (array)json_decode($name)->$fixname;

            }
        }
    ?>
    <div class="row">
    	<div class="col s12 m3 l3">
            <?php foreach($app->allsubs as $category): ?>
                <a id="jt-<?php echo $category->parent_slug; ?>" class="btn btn-block <?php if(isset($action) && $action==$category->parent_slug){ echo ' active ';} ?>" href="/signup/tutor/category/<?php echo $category->parent_slug; ?>#jt-<?php echo $category->parent_slug; ?>">
                    <?php echo $category->subject_parent; ?>
                </a>
            <?php endforeach; ?>
    	</div>
    	<div class="col s12 m9 l9">
    		<?php if(isset($app->allcats)): ?>
                <form method="post" action="/signup/tutor/">
                    <input type="hidden" name="mysubjects[parent_slug]" value="<?php echo $app->allcats[0]->parent_slug; ?>" />
                    <?php foreach($app->allcats as $sub):  ?>

                    <div>
                        <input <?php if(isset($myvals) && in_array($sub->id, $myvals)){ echo 'checked="checked"'; } ?> name="mysubjects[]" class="filled-in" type="checkbox" value="<?php echo $sub->id; ?>" id="<?php echo $sub->id; ?>" />
                        <label for="<?php echo $sub->id; ?>">
                            <?php echo $sub->subject_name; ?>
                        </label>
                    </div>

                    <?php endforeach; ?>

                    <input type="hidden" name="mysubjects[target]" value="mysubjects"  />
        			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
                    <button type="submit">Go</button>
                </form>
            <?php endif; ?>
    	</div>
    </div>
</div>
