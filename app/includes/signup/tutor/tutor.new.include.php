<h1>Welcome <span><?php echo $app->newtutor->first_name.' '.$app->newtutor->last_name; ?></span></h1>

<h3>
    About Yourself
</h3>
<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">
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
                            <option value="--"> -- </option>
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
    	<div class="col s12 m6 l6">

            <div class="help">
                <div class="title">Help</div>
                <p>Please provide your zip code, a short description, and in-depth description and your gender.</p>

                <p>Your <span class="blue-text">Zip Code</span> is needed to determine what city / state your profile will be associated with.</p>

                <p> Write a short  <span class="blue-text">short description</span> about yorself, so you can catch the eye of students. </p>

                <p> Write an <span class="blue-text">in-depth description</span> about what you tutor, why you tutor, or just write about yourself. The more detailed you are the better change a student will contact you. </p>

                <p> You can choose to show <span class="blue-text">your gender,</span> but it's not required. Some students may want to search by gender, and if you don't list yours you won't show up in the results. </p>
            </div>

    	</div>
    </div>
</div>

<h3 id="tutorinfo">
    Tutoring Information
</h3>
<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">
            <form method="post" class="form-post auto-magic" action="/signup/tutor" id="tutoringinfo">

                <div class="new-inputs">
                    <label>What is your hourly rate?</label>
                    <div class="input-wrapper" id="aboutme_hourly_rate"><input type="text" name="tutoringinfo[hourly_rate]" placeholder="What is your hourly rate?" <?php echo 'value="'.isitset($app->newtutor->hourly_rate).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>Please provide 3 References (Emails, or Phone Numbers)</label>
                    <div class="input-wrapper" id="tutoringinfo_references"><textarea class="materialize-textarea" name="tutoringinfo[references]" placeholder="Please provide 3 References"><?php echo isitset($app->newtutor->references); ?></textarea></div>
                </div>

                <div class="new-inputs">
                    <label>How far are you willing to travel?</label>
                    <div class="input-wrapper-select" id="tutoringinfo_travel_distance">
                        <select name="tutoringinfo[travel_distance]" class="browser-default">
                            <option value="--"> -- </option>
                            <?php
                                $travel_distance = isitset($app->newtutor->travel_distance);
                                foreach(array(1,5,10,20,25,50,100) as $key => $value){
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
                            <option value="--"> -- </option>
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
                            <option value="--"> -- </option>
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
                    <label>What is your cancelation fee?</label>
                    <div class="input-wrapper-select" id="tutoringinfo_cancellation_rate">
                        <select name="tutoringinfo[cancellation_rate]" class="browser-default">
                            <option value="--"> -- </option>
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



                <input type="hidden" name="tutoringinfo[target]" value="tutoringinfo"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>
    	</div>
    	<div class="col s12 m6 l6">
            <div class="help">
                <div class="title">Help</div>

                <p>The average <span class="blue-text">hourly rate</span> for tutoring is $40.00, but it can range widly from $15.00 an hour all the way up to $300.00 an hour.</p>
                <p>We require that you provide <span class="blue-text">3 references</span>, to ensure the highest quality tutors. If you don't have any references, please explain why.</p>
                <p>How far are you  <span class="blue-text">willing to travel</span> to meetup with a student?</p>
                <p>You can tutor <span class="blue-text">Online, In-Person or Both.</span> We provide an online Whiteboard solution you can use to tutor students online. Or if you prefer you can setup an in-person meeting with them at your desired location.</p>
                <p>You can provide a <span class="blue-text">cancelation policy</span> if you would like to require a student to notify you that they have to cancel.</p>
                <p>If a student cancels without letting you know you can charge them a  <span class="blue-text">cancelation fee.</span></p>


            </div>
    	</div>
    </div>
</div>

<h3 id="addaphoto">
    Add A Photo
</h3>
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
                		<div class="profile-image avatar"><img src="/image/tutorphotos/<?php echo $app->newtutor->id; ?>/cropped" class="responsive-img" /></div>
                	</div>
                </div>

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
    	<div class="col s12 m6 l6">
            <div class="help">
                <div class="title">Help</div>
                <p>Please provide a <span class="blue-text">photo</span> of yourself. A photo is required, to ensure that we have the highest quality tutor profiles.</p>

                <p>A photo can speak a thousand words, make sure you're saying the right thing.</p>

                <p>Your profile will not be approved if you do not provide a quality photo of yourself.</p>

                <p>Once you photo is approved you can always go back and change it to another one.</p>

            </div>
    	</div>
    </div>
</div>

<h3>
    Subjects You Teach &amp; Tutor
</h3>
<div class="box" id="mysubjects">
    <div class="row">
    	<div class="col s12 m6 l6">
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
            	<div class="col s12 m4 l4">
                    <?php foreach($app->allsubs as $category): ?>
                        <a id="jt-<?php echo $category->parent_slug; ?>" class="btn btn-block <?php if(isset($action) && $action==$category->parent_slug){ echo ' active ';} ?>" href="/signup/tutor/category/<?php echo $category->parent_slug; ?>#mysubjects">
                            <?php echo $category->subject_parent; ?>
                        </a>
                    <?php endforeach; ?>
            	</div>
            	<div class="col s12 m8 l8">
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
                            <button class="btn blue" type="submit">Save</button>
                        </form>
                    <?php endif; ?>
            	</div>
            </div>
    	</div>
    	<div class="col s12 m5 l5">
            <div class="help">
                <div class="title">Help</div>
                <p>List all the <span class="blue-text">subjects</span> that you teach or tutor.</p>

                <p>Click on a category on the left and then check off all the subjects you tutor.</p>

                <p>Once your profile is approved you can log into the site and add more detailed descriptions for all the subjects.</p>

            </div>
    	</div>
    </div>
</div>

<h3>
    Background Check  <span class="green-text">(Optional)</span>
</h3>
<div class="box">
    <div class="row">
    	<div class="col s12 m8 l8" id="steps">

            <?php if(isset($app->newtutor->candidate_id)): ?>
                <div class="bgcheck-success">You've successfully submited your background check.</div>
            <?php elseif(isset($app->newtutor->step1)): ?>
                <div>Background Check Steps</div>
                <ul class="breadcrumb">

                    <li><a href="/signup/tutor/step1#steps">Step 1</a></li>


                    <?php if(isset($app->newtutor->step1)): ?>
                        <li><a href="/signup/tutor/step2#steps">Step 2</a></li>
                    <?php endif; ?>

                    <?php if(isset($app->newtutor->step2)): ?>
                        <li><a href="/signup/tutor/step3#steps">Step 3</a></li>
                    <?php endif; ?>

                    <?php if(isset($app->newtutor->step3)): ?>
                        <li><a href="/signup/tutor/step4#steps">Step 4</a></li>
                    <?php endif; ?>

                    <?php if(isset($app->newtutor->step4)): ?>
                        <li><a href="/signup/tutor/step5#steps">Step 5</a></li>
                    <?php endif; ?>

                    <?php if(isset($app->newtutor->step5)): ?>
                        <li><a href="/signup/tutor/step6#steps">Step 6</a></li>
                    <?php endif; ?>

                    <li><a href="#">&nbsp;</a></li>
                </ul>
                <div class="the-background-check-complete">
                    <?php
                        if(isset($promocode) && $promocode=='step1' || empty($promocode) && isset($app->newtutor->step1)){
                            include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step1.php');
                        }
                        elseif(isset($promocode) && $promocode=='step2'){
                            include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step2.php');
                        }
                        elseif(isset($promocode) && $promocode=='step3'){
                            include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step3.php');
                        }
                        elseif(isset($promocode) && $promocode=='step4'){
                            include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step4.php');
                        }
                        elseif(isset($promocode) && $promocode=='step5' && empty($app->newtutor->charge_id)){
                            include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step5.php');
                        }
                        elseif(isset($promocode) && $promocode=='step5' && isset($app->newtutor->charge_id)){
                            include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step5.complete.php');
                        }
                        elseif(isset($promocode) && $promocode=='step6'){
                            include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step6.php');
                            if(isset($app->newtutor->charge_id) && empty($app->newtutor->canditate_id)){
                                include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step6.action.php');
                            }
                        }
                    ?>
                </div>
            <?php else: ?>
                <div class="start-background-check" data-status="closed">
                    Begin Background Check
                </div>
                <div class="the-background-check-steps">
                    <?php include($app->dependents->APP_PATH.'includes/backgroundcheck/backgroundcheck-step1.php'); ?>
                </div>
            <?php endif; ?>

    	</div>
    	<div class="col s12 m4 l4">
            <div class="help">
                <div class="title">Help</div>
                <p>Everyone single one of our tutors has to pass a <span class="blue-text">background check</span> before they can interact with students.  </p>
                <p>We don't require the background check to complete a profile and become a tutor, but once a student has contact you, or you would like to apply to a job post you must pass the background check. </p>
                <p>$29.99 (Non-Refundable). You are purchasing a background check on yourself, you get to keep the background check and do whatever you would like with it.</p>
            </div>
    	</div>
    </div>
</div>

<?php if(isset($app->newtutor->aboutme) && isset($app->newtutor->tutorinfo) && isset($app->newtutor->addaphoto) && isset($app->newtutor->subjectsitutor)): ?>
<h3>
    Finishing Your Application
</h3>
<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">


                <form method="post" action="/signup/tutor/" class="form-post">
                    <p>Would you like to be interviewed by our staff?</p>

                    <div class="new-inputs">
                        <input name="finishapplication[yesinterview]" <?php if(isitset($app->newtutor->timeday)){ echo 'checked="checked"'; } ?> class="filled-in" type="checkbox" value="1" id="yesinterview" />
                        <label for="yesinterview">
                            Yes, I would love to have an interview
                        </label>
                    </div>

                    <div class="new-inputs">
                        <label>If Yes. What time / day would be best for you?</label>
                        <div class="input-wrapper" id="finishapplication_timeday"><input type="text" name="finishapplication[timeday]" placeholder="What time / day would be best for you?" <?php echo 'value="'.isitset($app->newtutor->timeday).'"'; ?> /></div>
                    </div>

                    <input type="hidden" name="finishapplication[target]" value="finishapplication"  />
                    <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">


                    <input type="hidden" name="finishapplication[alldone]" value="alldone"  />
                    <button class="btn" type="submit">
                        Submit My Profile For Review
                    </button>

                </form>


    	</div>
    	<div class="col s12 m6 l6">
            <div class="help">
                <div class="title">Help</div>
                <p>If you would like to have an interview, just let us know and we can set one up.</p>

                <p>By being interviewed you get a special <span class="blue-text">intervewed badge</span> on your profile. </p>

                <p>Once you submit your profile for review, you will be logged out, and we will contact you shortly.</p>

            </div>
    	</div>
    </div>
</div>
<?php else: ?>
    <div class="box">
        <?php if(empty($app->newtutor->aboutme)): ?>
            Please finish the About Yourself section before continuing.
        <?php elseif(empty($app->newtutor->tutorinfo)): ?>
            Please finish the Tutoring Information section before continuing.
        <?php elseif(empty($app->newtutor->addaphoto)): ?>
            Please Add A Photo before continuing.
        <?php elseif(empty($app->newtutor->subjectsitutor)): ?>
            Please list at least one subject you tutor before continuing.
        <?php endif; ?>
    </div>
<?php endif; ?>



<style type="text/css">
.help{
    background: #efefef;
    padding: 10px;
    border: solid 1px #ccc;
}
.start-background-check{
    text-align: center;
    padding: 10px;
    background: #0099ff;
    color: #fff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 10px;
}
.start-background-check:hover{
    background: #0077c7;

}
.the-background-check-steps, .the-background-check-complete{
    display: none;
    background: #f5f5f5;
    border: solid 1px #efefef;
    padding: 10px;
    float: left;
    width: 100%;
}
.the-background-check-complete{
    display: block;
}

/*Background Check*/
.bgcheck-step{
    font-size: 18px;
    font-weight: bold;
}
.bgcheck-step-info{
    font-size: 16px;
    border-bottom: solid 1px #ccc;
    color: #666;
    margin-bottom: 10px;

}
.the-background-check-steps .form-post{

}
.labelclass{
	color: #9e9e9e;
    left: 0.75rem;
    font-size: 13px;
    cursor: text;
    margin-top:-20px;
}
.summary-of-our-rights{
	font-size: 12px;
	background: #efefef;
	border: solid 1px #ccc;
	padding: 20px;
	max-height: 200px;
	overflow: auto;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
margin-bottom: 15px;
}
.summary-of-our-rights p{
	margin: 0px;
	padding: 0px;
	margin-bottom: 15px;
	line-height: normal;
}
.bgcheck-success{
    background: #00d52f;
    text-align: center;
    padding: 10px;
    color: #fff;
}
</style>

<script type="text/javascript">
    function showmehideme(data,show,hide){
        var datastatus = $(data).attr('data-status');
        if(datastatus=='closed'){
            $(data).attr('data-status','open');
            eval(show);
        }
        else if(datastatus=='open'){
            $(data).attr('data-status','closed');
            eval(hide);
        }
    }
	$(document).ready(function() {
		$('.start-background-check').on('click',function(){
            var target = '.the-background-check-steps';
			showmehideme(this,"$('"+target+"').slideDown();","$('"+target+"').slideUp();");
		});
	});

</script>
