<div class="signup-title-text">
    Step 7 <span>Submit Application</span>
</div>


<?php if(isset($app->newtutor->aboutme) && isset($app->newtutor->tutorinfo) && isset($app->newtutor->addaphoto) && isset($app->newtutor->subjectsitutor) && isset($app->newtutor->my_resume)): ?>
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

                    <div class="alert red white-text">Once you submit your profile for review, you will be logged out, and we will review your application.</div>
                    <input type="hidden" name="finishapplication[alldone]" value="alldone"  />
                    <button class="btn confirm-submit" type="button">
                        Submit My Profile For Review
                    </button>

                </form>


    	</div>
    	<div class="col s12 m6 l6">
            <div class="help-info">
                <div class="title">Help</div>
                <p>If you would like to have an interview, just let us know and we can set one up.</p>

            </div>
            <div class="require-check">
                <div class="title">Required Background Check</div>
                <p>Everyone single one of our tutors has to pass a <span>background check</span> before they can interact with students.  </p>
                <p>We don't require the background check to complete a profile and become a tutor, but once a student has contacted you, and you want to setup a tutoring session, it's required. </p>
                <p>When you apply for the background check, you are purchasing a background check, which is <span class="green-text">$29.99 (Non-Refundable)</span>, you may request a copy of the background check at any time from our provider <a href="https://checkr.com/" target="_blank">Checkr</a>.</p>

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
