<?php

	$jobOptions = array();
	$jobOptions['type'] = (object)array(
		'No Preference'=>'both',
		'Online'=>'online',
		'In Person'=>'offline'
	);
	$jobOptions['skill_level'] = (object)array(
		'Novice','Advanced Beginner','Competent','Proficient','Expert'
	);
	
	$app->jobOptions = $jobOptions;
?>
<form class="form-post" method="post" action="/find-me-a-tutor" id="postajob">
	
	<div class="input-field" id="findasubjectemail-input">
		<input type="text" name="postjob[email]" id="findasubjectemail"  data-name="postjob" />
		<label for="findasubjectemail">
			What is your email address?
		</label>
	</div>
	
	<div class="input-field" id="findasubject-input">
		<input type="text" name="postjob[subject_name]" id="findasubject" class="autogenerate--subject" data-name="postjob" />
		<label for="findasubject">
			Find The Subject You Want To Learn
		</label>
	</div>

	<div class="input-field" id="job_description-input">
		<textarea id="job_description" name="postjob[job_description]" class="materialize-textarea"></textarea>
		<label for="job_description">
			Please explain why you need help with this subject
		</label>
	</div>
	
	<div class="input-field input-range jobs-range">
	
		<div class="jobs-price-range">What is your price range?</div>

        <div class="pricerange slidebox"></div>
        <div class="slidebox-inputs">
            <input type="text" name="postjob[price_range_low]" id="pricerangeLower" data-value="20" />
            <input type="text" name="postjob[price_range_high]" id="pricerangeUpper" data-value="100" />
        </div>

	</div>
	<p></p>
	
	<div class="row">
		<div class="col s12 m6 l6">
			<div class="input-field">
				<label class="select-label" for="textarea1">
					What type of tutor are you looking for?
				</label>
				<select name="postjob[type]" class="browser-default">
					<?php foreach($app->jobOptions['type'] as $key => $type): ?>
					<option <?php if(isset($app->user->online_tutor) && $app->user->online_tutor == $type){ echo 'selected="selected"';} ?> value="<?php echo $type; ?>"><?php echo $key; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="col s12 m6 l6">
			<div class="input-field">
				<label class="select-label" for="textarea1">
					What is your skill level?
				</label>
				<select name="postjob[skill_level]" class="browser-default">
					<option value="">Select Skill Level</option>
					<?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
					<option value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	
	<input type="hidden" name="postjob[target]" value="postjob"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	
	<p></p>
	<div class="form-submit">
		<button class="btn blue" type="submit">
			Post Job
		</button>
	</div>
	
</form>