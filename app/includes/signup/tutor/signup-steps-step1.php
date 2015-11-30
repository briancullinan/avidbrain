<p class="pageids" id="aboutyourself">&nbsp;</p>

<div class="signup-title-text">
    Step 2 <span>About Yourself</span>
</div>

<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">
            <form method="post" class="form-post xxx" action="/signup/tutor" id="aboutme">
                <div class="new-inputs">
                    <label>Your Zip Code <span class="signup-required"><i class="fa fa-asterisk"></i></span> </label>
                    <div class="input-wrapper" id="aboutme_zipcode"><input type="text" name="aboutme[zipcode]" placeholder="Your Zip Code" maxlength="5" <?php echo 'value="'.isitset($app->newtutor->zipcode).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>Write a short description about yourself <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper" id="aboutme_short_description"><input type="text" name="aboutme[short_description]" placeholder="Write a short description about yourself" <?php echo 'value="'.isitset($app->newtutor->short_description).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>Write an in-depth description about yourself <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper" id="aboutme_personal_statement"><textarea class="materialize-textarea" name="aboutme[personal_statement]" placeholder="Write an in-depth description about yourself and why / what you tutor"><?php echo isitset($app->newtutor->personal_statement); ?></textarea></div>
                </div>

                <div class="new-inputs">
                    <label>What is your gender? <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper-select" id="aboutme_gender">
                        <select name="aboutme[gender]" class="browser-default">
                            <option value="--"> -- </option>
                            <?php
                                $gender = isitset($app->newtutor->gender);

                                foreach(array('dontshow'=>"Don't Show My Gender",'male'=>'Male','female'=>'Female') as $key => $value){
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

                <button type="submit" class="btn success">Save</button>
                <input type="hidden" name="aboutme[target]" value="aboutme"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>
    	</div>
    	<div class="col s12 m6 l6">

            <div class="help-info">
                <div class="title">Help</div>
                <p>Please provide your zip code, a short description, an in-depth description and your gender.</p>

                <p>Your <span class="blue-text">Zip Code</span> is needed to determine what city / state your profile will be associated with.</p>

                <p> Write a   <span class="blue-text">short description</span> about yourself, so you can catch the eye of students. </p>

                <p> Write an <span class="blue-text">in-depth description</span> about what you tutor, why you tutor, or just write about yourself. The more detailed you are the better chance a student will contact you. </p>

                <p> You can choose to show <span class="blue-text">your gender,</span> but it's not required. Some students may want to search by gender, and if you don't list yours you won't show up in the results. </p>
            </div>

    	</div>
    </div>
</div>
