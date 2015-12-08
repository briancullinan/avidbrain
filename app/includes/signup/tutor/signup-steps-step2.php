<p class="pageids" id="uploadresume">&nbsp;</p>

<div class="signup-title-text">
    Step 3 <span>Upload Your Resume</span>
</div>

<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">
            <?php if(!empty($app->newtutor->my_resume)): ?>
                <div class="green center-align white-text padd5">Thank your for uploading your resume</div>
            <?php else: ?>

                <p>Please upload your resume <span class="signup-required"><i class="fa fa-asterisk"></i></span></p>

                <form enctype="multipart/form-data" action="/signup/tutor" method="post" id="upload-resume-form">
                    <input type="hidden" name="uploadresume[target]" value="uploadresume"  />
                    <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                    <input name="uploadresume[file]" class="hide upload-trigger" type="file" />
                    <button class="select-item btn grey darken-1 btn-block" type="button" data-text = "Uploading Resume">
                        <i class="fa fa-upload"></i> Upload Resume
                    </button>
                </form>
            <?php endif; ?>

            <br>


            <form  action="/signup/tutor" method="post" id="myresume">


                <div class="new-inputs">
                    <label>If you dont' have a resume available you can type out your resume below:</label>
                    <div class="input-wrapper" id="resume_text"><textarea class="materialize-textarea" name="myresume[resume_text]"><?php echo isitset($app->newtutor->resume_text); ?></textarea></div>
                </div>

                <input type="hidden" name="myresume[target]" value="myresume"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

                <button class="btn blue" type="submit">
                    <i class="fa fa-save"></i> Save Text Resume
                </button>
            </form>



    	</div>
    	<div class="col s12 m6 l6">
    		<div class="help-info">
                <div class="title">Help</div>
                <p>Allowable file types: .pdf, .doc, .docx, .rtf, .odt</p>
                <p>Please upload your resume, so we can review it.</p>
            </div>
    	</div>
    </div>
</div>
