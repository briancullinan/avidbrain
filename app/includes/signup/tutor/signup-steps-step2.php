<p class="pageids" id="uploadresume">&nbsp;</p>

<div class="signup-title-text">
    Step 3 <span>List what makes you a great tutor</span>
</div>

<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">



            <form  action="/signup/tutor" method="post" id="myresume">


                <div class="new-inputs">
                    <label>What makes you a great tutor?</label>
                    <div class="input-wrapper" id="resume_text"><textarea class="materialize-textarea" name="myresume[resume_text]"><?php echo isitset($app->newtutor->resume_text); ?></textarea></div>
                </div>

                <input type="hidden" name="myresume[target]" value="myresume"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

                <button class="btn blue" type="submit">
                     Save
                </button>
            </form>



    	</div>
    	<div class="col s12 m6 l6">
    		<div class="help-info">
                <div class="title">Help</div>
                <p>List what makes you a great candidate to become a tutor with MindSpree</p>
            </div>
    	</div>
    </div>
</div>
