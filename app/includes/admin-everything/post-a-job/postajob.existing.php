<?php //printer($app->thejob); ?>

<h2>Update Job: <span class="blue-text"><?php echo $app->thejob->subject_name; ?></span></h2>

<form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>" id="updatejob">

    <div class="input-field">
        <input type="text" id="zipcode" name="updatejob[zipcode]" minlength="5" maxlength="5" value="<?php echo $app->thejob->zipcode; ?>"  />
        <label for="zipcode">
            Zip Code
        </label>
    </div>

    <div class="input-field">
        <input type="text" id="subject" name="updatejob[subject]" data-name="updatejob" class="autogenerate--subject" value="<?php echo $app->thejob->subject_name; ?>" />
        <label for="subject">
            Subject
        </label>
    </div>

    <div class="input-field">
        <textarea id="why" name="updatejob[why]" class="materialize-textarea"><?php echo $app->thejob->job_description; ?></textarea>
        <label for="why">
            Explain why you need help
        </label>
    </div>

    <div class="input-field input-range jobs-range">

        <div class="jobs-price-range">What is your price range?</div>

        <div class="pricerange slidebox"></div>
        <div class="slidebox-inputs">
            <input type="text" name="updatejob[price_range_low]" id="pricerangeLower" data-value="<?php echo $app->thejob->price_range_low; ?>" />
            <input type="text" name="updatejob[price_range_high]" id="pricerangeUpper" data-value="<?php echo $app->thejob->price_range_high; ?>" />
        </div>

    </div>

    <div class="row">
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label class="select-label" for="textarea1">
                    What type of tutor are you looking for?
                </label>
                <select name="updatejob[type]" class="browser-default">
                    <?php foreach($app->jobOptions['type'] as $key => $type): ?>
                    <option <?php if(!empty($app->thejob->type) && $app->thejob->type==$type){ echo 'selected="selected"'; } ?>  value="<?php echo $type; ?>"><?php echo $key; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="input-field">
                <label class="select-label" for="textarea1">
                    What is your skill level?
                </label>
                <select name="updatejob[skill_level]" class="browser-default">
                    <option value="">Select Skill Level</option>
                    <?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
                        <option <?php if(!empty($app->thejob->skill_level) && $app->thejob->skill_level==$skill_level){ echo 'selected="selected"'; } ?> value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <br/>
    <div>
        <span>
            <input id="openopen" type="radio" name="updatejob[open]" value="OPEN" <?php if(!empty($app->thejob->open)){ echo 'checked="checked"'; } ?> />
            <label for="openopen">Open</label>
        </span>
        <span>
            <input id="openclosed"  type="radio" name="updatejob[open]" value="CLOSED" <?php if(empty($app->thejob->open)){ echo 'checked="checked"'; } ?> />
            <label for="openclosed">Closed</label>
        </span>
    </div>


    <input type="hidden" name="updatejob[email]" value="<?php echo $app->thejob->email; ?>" />

    <br/>
    <div class="input-field">
        <textarea id="notes" name="updatejob[notes]" class="materialize-textarea"><?php echo $app->thejob->notes; ?></textarea>
        <label for="notes">
            Notes
        </label>
    </div>

    <?php if (strpos($app->thejob->email, 'ghost-') !== false): ?>
        <div class="attatch-to-user">



            <div>Attatch Real User Email</div>

            <label for="subject">
                User's Email Address
            </label>
            <input type="text"  name="updatejob[attatchuser]"  />


        </div>
    <?php endif; ?>


    <input type="hidden" name="updatejob[target]" value="updatejob"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

    <button type="submit" class="btn success">
        Update Job
    </button>

</form>


<style type="text/css">
.attatch-to-user{
	background: #efefef;
    border: solid 1px #ccc;
    padding: 10px;
    margin-bottom: 15px;
}
</style>
